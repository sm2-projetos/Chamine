<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\ClienteEmpresa;

class ClientesController extends Controller
{

    public function index()
    {
        $clientes = Cliente::where('lixeira', false)->get();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        $empresas = \App\Models\Empresa::orderBy('nome')->get();
        return view('clientes.create', compact('empresas'));
    }

    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj_cpf' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'empresa_id' => 'nullable|exists:empresas,id', // Validação para o novo campo
            // Mantém os outros campos para compatibilidade com formulários existentes
            'empresa_nome.*' => 'nullable|string|max:255',
            'empresa_cnpj.*' => 'nullable|string|max:20',
            'empresa_endereco.*' => 'nullable|string|max:255',
            'empresa_contato.*' => 'nullable|string|max:20',
        ]);

        // Criação do cliente
        $cliente = Cliente::create([
            'nome' => $request->input('nome'),
            'cnpj_cpf' => $request->input('cnpj_cpf'),
            'endereco' => $request->input('endereco'),
            'email' => $request->input('email'),
            'telefone' => $request->input('telefone'),
        ]);

        // Verifica se foi selecionada uma empresa existente
        if ($request->has('empresa_id') && !empty($request->input('empresa_id'))) {
            ClienteEmpresa::create([
                'cliente_id' => $cliente->id_cliente, // Use o campo correto conforme seu modelo
                'empresa_id' => $request->input('empresa_id'),
            ]);
        }
        // Caso contrário, processa criação de novas empresas se houver
        else {
            $empresaNomes = $request->input('empresa_nome');
            $empresaCnpjs = $request->input('empresa_cnpj');
            $empresaEnderecos = $request->input('empresa_endereco');
            $empresaContatos = $request->input('empresa_contato');

            if ($empresaNomes && is_array($empresaNomes)) {
                foreach ($empresaNomes as $index => $empresaNome) {
                    if (!empty($empresaNome)) {
                        $empresa = Empresa::create([
                            'nome' => $empresaNome,
                            'cnpj' => $empresaCnpjs[$index] ?? null,
                            'endereco' => $empresaEnderecos[$index] ?? null,
                            'contato' => $empresaContatos[$index] ?? null,
                        ]);

                        ClienteEmpresa::create([
                            'cliente_id' => $cliente->id_cliente,
                            'empresa_id' => $empresa->id,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj_cpf' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
        ]);

        // Atualização do cliente
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update(['lixeira' => true]);

        return redirect()->route('clientes.index')->with('success', 'Cliente movido para a lixeira com sucesso!');
    }

    public function checkCpf(Request $request)
    {
        $exists = Cliente::where('cnpj_cpf', $request->input('cnpj_cpf'))
                ->where('clientes.lixeira', 0) // Filtra apenas clientes que não estão na lixeira
                ->exists();
    return response()->json(['exists' => $exists]);
    }

    public function getClientData(Request $request)
    {
    $cpf = $request->input('cnpj_cpf');
    
    // Busca o cliente apenas se ele não estiver na lixeira
    $cliente = Cliente::where('cnpj_cpf', $cpf)->where('clientes.lixeira', 0)->first();

    if ($cliente) {
        // Filtra as empresas para retornar apenas as que não estão na lixeira
        $empresas = $cliente->empresas()->where('empresas.lixeira', 0)->get();

        return response()->json([
            'id' => $cliente->id_cliente,
            'nome' => $cliente->nome,
            'empresas' => $empresas
        ]);
    }

    return response()->json(['error' => 'Cliente não encontrado'], 404);
    }

}
