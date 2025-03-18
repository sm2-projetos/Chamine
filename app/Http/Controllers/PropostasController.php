<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposta;
use App\Models\OS;

class PropostasController extends Controller
{


    public function index(Request $request)
    {
        $status = $request->input('status');
        $query = Proposta::query();

        if ($status) {
            $query->where('status', $status);
        }

        $propostas = $query->get();

        return view('propostas.index', compact('propostas', 'status'));
    }


    public function create()
    {
        // Lógica para exibir a página de criação de proposta
        return view('propostas.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'id_cliente' => 'required',
            'id_empresa' => 'required',
            'analise_critica' => 'required',
            'fonte_emissao' => 'required',
            'numero_fontes' => 'required',
            'parametros' => 'required',
            'servicos_custos' => 'required',
            'observacoes' => 'nullable',
            'status' => 'required',
        ]);

        $dados['lixeira'] = false;

        $proposta = Proposta::create($dados);

        if ($dados['status'] == 'Aprovado') {
            OS::create([
                'proposta_id' => $proposta->id,
                'perfil_id' => null, // Inicialmente vazio
                'metodologia_documentos' => json_encode([]), // Inicialmente vazio, pode ser atualizado depois
                'equipamentos_necessarios' => json_encode([]), // Inicialmente vazio, pode ser atualizado depois
                'observacao' => '',
                'lixeira' => false,
            ]);
        }

        return redirect()->route('propostas.index')
                         ->with('success', 'Proposta criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $proposta = Proposta::findOrFail($id);
        $proposta->update($request->all());

        if ($request->status == 'Aprovado') {
            OS::create([
                'proposta_id' => $proposta->id,
                'perfil_id' => null, // Inicialmente vazio
                'metodologia_documentos' => [], // Inicialmente vazio, pode ser atualizado depois
                'equipamentos_necessarios' => [], // Inicialmente vazio, pode ser atualizado depois
                'observacao' => '',
                'lixeira' => false,
            ]);
        }

        return redirect()->route('propostas.index')
                         ->with('success', 'Proposta atualizada com sucesso!');
    }
}
