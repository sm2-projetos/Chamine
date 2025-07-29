<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Legislacao;
use App\Models\OS;
use App\Models\PerfilChamine;
use App\Models\Empresa;
use App\Models\Proposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class OSController extends Controller
{
    public function index(){
        $os = OS::all();
        return view('os.index', compact('os'));
    }
    public function create($id)
    {
        $proposta = Proposta::buscarComRelacionamentosPorId($id);
        return view('os.create', compact('proposta'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'proposta_id' => 'required|exists:propostas,id',
            'numero_projeto' => 'required|string|max:255',
            'numero_relatorio' => 'required|string|max:255',
            'numero_plano' => 'required|string|max:255',
            'servico' => 'required|string|max:255',
            'data_amostragem' => 'required|date',
            'observacao' => 'nullable|string',
        ]);

         $existe = Os::where('numero_projeto', $validated['numero_projeto'])->exists();

        if ($existe) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['numero_projeto' => 'Já existe uma OS com esse número de projeto.']);
        }

        $os = Os::create($validated);

        return redirect()->route('os.index')->with('success', 'OS salva com sucesso!');
    }

    public function showOS($id){
        $ordem = OS::buscarComRelacionamentosPorId($id);
        $ze = $ordem->toArray();
        $pdf = Pdf::loadView('os.pdf', compact('ordem'));

        return $pdf->download("OS-{$ordem->id}.pdf");
    }

    public function showForm($id)
    {
        $os = OS::findOrFail($id);
        $proposta = $os->proposta; // Obter a proposta associada à OS
        $empresa = $proposta->empresa; // Buscar a empresa pelo relacionamento
        $cliente = $proposta->cliente; // Buscar o cliente pelo relacionamento
        $perfis = PerfilChamine::where('empresa_nome', $empresa->nome)->get(); // Buscar perfis pelo nome da empresa

        // Dados para preencher automaticamente
        $dadosAuto = [
            'nomeCliente' => $cliente->nome ?? '',
            'nRelatorio' => $os->id,
            'empresaCliente' => $empresa->nome ?? '',
            'cepEmpresa' => $empresa->endereco ?? '', // Supondo que o endereço contenha o CEP
            'cnpjEmpresa' => $empresa->cnpj ?? '',
            'cidadeCliente' => $cliente->endereco ?? '',
        ];

        // Caminho absoluto para a pasta de templates
        $templatesPath = storage_path('app/templates');
        if (!File::exists($templatesPath)) {
            File::makeDirectory($templatesPath, 0755, true);
        }
        $templates = collect(File::files($templatesPath))
            ->filter(function ($file) {
                return $file->getExtension() === 'docx';
            })
            ->map(function ($file) {
                return $file->getFilenameWithoutExtension();
            })
            ->values();

        $legislacoes = Legislacao::all();

        $certificados = Certificado::all();

        return view('os.form', compact('os', 'perfis', 'templates', 'dadosAuto', 'legislacoes', 'certificados'));
    }
}
