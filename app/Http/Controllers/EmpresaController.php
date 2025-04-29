<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente; // Adicione o import do modelo Cliente
use App\Models\Empresa;
use App\Models\Contato;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresa::where('lixeira', false)->get();
        return view('empresas.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        return view('empresas.create', compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'required|string|max:20',
            'cliente_id' => 'nullable|exists:clientes,id_cliente',
        ]);

        $empresa = Empresa::create($request->all());

        // Se um cliente foi selecionado, criar a relação
        if ($request->has('cliente_id') && !empty($request->input('cliente_id'))) {
            $empresa->clientes()->attach($request->input('cliente_id'));
        }

        // Processar contatos se houver
        if ($request->has('contato_nome')) {
            for ($i = 0; $i < count($request->contato_nome); $i++) {
                if (!empty($request->contato_nome[$i]) && !empty($request->contato_telefone[$i])) {
                    Contato::create([
                        'empresa_id' => $empresa->id,
                        'nome' => $request->contato_nome[$i],
                        'cargo' => $request->contato_cargo[$i] ?? null,
                        'email' => $request->contato_email[$i] ?? null,
                        'telefone' => $request->contato_telefone[$i],
                    ]);
                }
            }
        }

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $empresa = Empresa::with('contatos')->findOrFail($id);
        $clientes = Cliente::orderBy('nome')->get();
        return view('empresas.edit', compact('empresa', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'required|string|max:20',
            'cliente_id' => 'nullable|exists:clientes,id_cliente',
        ]);

        $empresa = Empresa::findOrFail($id);
        $empresa->update([
            'nome' => $request->nome,
            'cnpj' => $request->cnpj,
            'endereco' => $request->endereco,
            'email' => $request->email,
            'telefone' => $request->telefone,
        ]);

        // Atualizar relação com cliente se informado
        if ($request->has('cliente_id')) {
            $empresa->clientes()->sync([$request->cliente_id]);
        }

        // Processar contatos
        if ($request->has('contato_nome')) {
            // Arrays de dados
            $contatoIds = $request->contato_id;
            $contatoNomes = $request->contato_nome;
            $contatoCargos = $request->contato_cargo;
            $contatoEmails = $request->contato_email;
            $contatoTelefones = $request->contato_telefone;

            for ($i = 0; $i < count($contatoNomes); $i++) {
                if (!empty($contatoNomes[$i]) && !empty($contatoTelefones[$i])) {
                    // Se tem ID, atualiza o contato existente
                    if (!empty($contatoIds[$i])) {
                        Contato::where('id', $contatoIds[$i])->update([
                            'nome' => $contatoNomes[$i],
                            'cargo' => $contatoCargos[$i] ?? null,
                            'email' => $contatoEmails[$i] ?? null,
                            'telefone' => $contatoTelefones[$i],
                        ]);
                    } 
                    // Se não tem ID, cria um novo contato
                    else {
                        Contato::create([
                            'empresa_id' => $empresa->id,
                            'nome' => $contatoNomes[$i],
                            'cargo' => $contatoCargos[$i] ?? null,
                            'email' => $contatoEmails[$i] ?? null,
                            'telefone' => $contatoTelefones[$i],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
