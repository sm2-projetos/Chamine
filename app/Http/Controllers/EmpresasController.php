<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\ClienteEmpresa;

class EmpresasController extends Controller
{
    public function index()
    {
        $empresas = Empresa::where('lixeira', false)->get();
        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('empresas.create');
    }
    public function store(Request $request)
    {
        $empresaNome = $request->input('empresa_nome');
        $empresaCnpj = $request->input('empresa_cnpj');
        $empresaEndereco = $request->input('empresa_endereco');
        $empresaContato = $request->input('empresa_contato');

        $request->validate([
            'empresa_nome' => 'nullable|string|max:255',
            'empresa_cnpj' => 'nullable|string|max:20',
            'empresa_endereco' => 'nullable|string|max:255',
            'empresa_contato' => 'nullable|string|max:100',
        ]);

        $empresa = Empresa::create([
            'nome' => $empresaNome,
            'cnpj' => $empresaCnpj ?? null,
            'endereco' => $empresaEndereco ?? null,
            'contato' => $empresaContato ?? null,
        ]);

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
            'cnpj' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'required|string|max:20',
        ]);

        // Atualização da empresa
        $empresa = Empresa::findOrFail($id);
        $empresa->update([
            'nome' => $request->input('nome'),
            'cnpj' => $request->input('cnpj'),
            'endereco' => $request->input('endereco'),
            'email' => $request->input('email'),
            'contato' => $request->input('telefone'), // Compatibilidade com campo existente
            'telefone' => $request->input('telefone'),
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
