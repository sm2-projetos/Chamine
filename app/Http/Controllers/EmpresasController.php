<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\ClienteEmpresa;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class EmpresasController extends Controller
{
    public function index()
    {
        $empresas = Empresa::where('lixeira', false)->get();
        return view('empresas.index', compact('empresas'));
    }

    public function checkCnpj(Request $request)
    {
        $cnpj = $request->input('cnpj');

        $dados = Empresa::where('cnpj', $cnpj)->first();

        if ($dados) {
            return response()->json($dados);
        } else {
            return response()->json(['message' => 'Empresa não encontrada.'], 404);
        }
    }


    public function create()
    {
        return view('empresas.create');
    }
    public function store(Request $request)
    {
        $nome = $request->input('nome');
        $cnpj = $request->input('cnpj');
        $endereco = $request->input('endereco');
        $email = $request->input('email');
        $cep = $request->input('cep');
        $cidade_estado = $request->input('cidade_estado');
        $cep = $cep . ' - ' . $cidade_estado;
        $telefone = $request->input('telefone');
        $nome_contato = $request->input('nome_contato');
        $email_contato = $request->input('email_contato');
        $telefone_contato = $request->input('telefone_contato');

        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:200',
            'telefone' => 'nullable|string|max:45',
            'nome_contato' => 'nullable|string|max:80',
            'email_contato' => 'nullable|email|max:200',
            'telefone_contato' => 'nullable|string|max:45',
        ]);

        $empresa = Empresa::create([
            'nome' => $nome,
            'cnpj' => $cnpj,
            'endereco' => $endereco,
            'cep' => $cep,
            'email' => $email,
            'telefone' => $telefone,
            'nome_contato' => $nome_contato,
            'email_contato' => $email_contato,
            'telefone_contato' => $telefone_contato,
        ]);

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $path = "public/imagens/empresa";

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $path =  "public/imagens/empresa/empresa-{$empresa->id}.png";
            $imageManager = new ImageManager(new GdDriver());

            // Converte e salva como PNG
            $image = $imageManager
                ->read($request->file('logo')->getPathname())
                ->toPng();

            Storage::put($path, (string) $image);

        }

        return redirect()->route('empresas.index')->with('success', 'Empresa cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);
        $clientes = \App\Models\Cliente::orderBy('nome')->get(); // Adicione esta linha
        return view('empresas.edit', compact('empresa', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:200',
            'telefone' => 'nullable|string|max:45',
            'nome_contato' => 'nullable|string|max:80',
            'email_contato' => 'nullable|email|max:200',
            'telefone_contato' => 'nullable|string|max:45',
        ]);

        // Atualização da empresa
        $empresa = Empresa::findOrFail($id);
        $empresa->update([
            'nome' => $request->input('nome'),
            'cnpj' => $request->input('cnpj'),
            'endereco' => $request->input('endereco'),
            'cep' => $request->input('cep'),
            'email' => $request->input('email'),
            'telefone' => $request->input('telefone'),
            'contato' => $request->input('nome_contato'),
            'email_contato' => $request->input('email_contato'),
            'telefone_contato' => $request->input('telefone_contato'),
        ]);

        return redirect()->route('empresas.index')->with('success', 'Empresa atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->update(['lixeira' => true]);

        // Marcar os vínculos com clientes como excluídos
        ClienteEmpresa::where('empresa_id', $id)->update(['lixeira' => true]);

        return redirect()->route('empresas.index')->with('success', 'Empresa movida para a lixeira com sucesso!');
    }
}
