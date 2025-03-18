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

    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);
        $cliente = $empresa->clientes()->first(); // Assumindo que uma empresa pertence a um cliente
        return view('empresas.edit', compact('empresa', 'cliente'));
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
            'contato' => 'required|string|max:20',
        ]);

        // Atualização da empresa
        $empresa = Empresa::findOrFail($id);
        $empresa->update($request->all());

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
