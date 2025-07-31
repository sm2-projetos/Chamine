<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposta;
use App\Models\OS;
use App\Models\PerfilChamine; // Importar o modelo de Perfil
use App\Models\FonteEmissao;
use App\Models\ServicoCusto;
use App\Models\Equipamento;
use App\Models\Infraestrutura;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PropostasController extends Controller
{


    public function index(Request $request)
    {
        $status = $request->input('status');
        // $query = Proposta::query();

        // if ($status) {
        //     $query->where('status', $status);
        // }

        // $propostas = $query->get();

        $propostas = Proposta::buscarComRelacionamentosPorStatus($status);

        $zz = $propostas->toArray();
        return view('propostas.index', compact('propostas', 'status'));
    }


    public function create()
    {
        $infraestruturas = Infraestrutura::select('conjunto_id', 'conjunto_nome')
            ->groupBy('conjunto_id', 'conjunto_nome')
            ->orderBy('conjunto_id', 'desc')
            ->get();
        $equipamentos = Equipamento::all();
        return view('propostas.create', compact('equipamentos', 'infraestruturas')); 
    }   

    public function show($id)
    {
         // Pode vir via query param ou você pode passar fixo
        $proposta = Proposta::buscarComRelacionamentosPorId($id);
        $ze = $proposta->toArray();
        $pdf = Pdf::loadView('propostas.pdf', compact('proposta'));

        return $pdf->download("proposta-{$proposta->id}.pdf");
    }
    
     public function os($id)
    {
         // Pode vir via query param ou você pode passar fixo
        $proposta = Proposta::buscarComRelacionamentosPorId($id);
        $ze = $proposta->toArray();
        $pdf = Pdf::loadView('os.pdf', compact('proposta'));

        return $pdf->download("OS-{$proposta->id}.pdf");
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); // Início da transação

        try {
            $data = $request->input();
            $provedoresSelecionados = $request->input('provedores', []);
            $provedoresString = implode(', ', $provedoresSelecionados);
            $equipamentosSelecionados = $request->input('equipamentos', []);
            $equipamentosIdsString = implode(',', $equipamentosSelecionados);

            $infraestruturasSelecionados = $request->input('infraestruturas', []);
            $infraestruturasIdsString = implode(',', $infraestruturasSelecionados);

            $dados = $request->validate([
                'id_empresa' => 'required',
                'numero_proposta' => 'required',
                'servico_solicitado' => 'required',
                'metodo_utilizado' => 'required',
                'capacidade_recursos' => 'required',
                'alteracao_proposta' => 'required',
                'propostatxt' => 'required',
                'apresentacao' => 'required',
                'objetivo' => 'required',
                'observacoes' => 'nullable',
                'status' => 'required',
            ]);

            $dados['provedores_externos'] = $provedoresString;
            $dados['equipamentos'] = $equipamentosIdsString;
            $dados['infraestruturas'] = $infraestruturasIdsString;
            $dados['lixeira'] = false;

            $proposta = Proposta::create($dados);

            $grupos = $request->input('grupos', []);

            foreach ($grupos as $grupo) {
                $grupoModel = \App\Models\PropostaGrupo::create([
                    'nome' => $grupo['nome'] ?? '',
                    'proposta_id' => $proposta->id,
                ]);

                if (!empty($grupo['metodologias']) && is_array($grupo['metodologias'])) {
                    foreach ($grupo['metodologias'] as $metodologia) {
                        \App\Models\PropostaMetodologia::create([
                            'grupo_id' => $grupoModel->id,
                            'nome' => $metodologia['nome'],
                            'acreditado' => $metodologia['acreditado'],
                        ]);
                    }
                }
            }

            // Salvar fontes de emissão
            if ($request->has('fonte_emissao')) {
                foreach ($request->fonte_emissao as $linha) {
                    FonteEmissao::create([
                        'id_proposta' => $proposta->id,
                        'fonte' => $linha['fonte'],
                        'numero_de_fontes' => $linha['numero_fontes'],
                        'numero_de_coletas' => $linha['numero_coletas'],
                        'parametros' => $linha['parametros'],
                    ]);
                }
            }

            // Salvar serviços e custos
            if ($request->has('servico')) {
                foreach ($request->servico as $item) {
                    ServicoCusto::create([
                        'id_proposta' => $proposta->id,
                        'descricao' => $item['descricao'],
                        'coletas_por_fontes' => $item['coletas_por_fonte'],
                        'qtd_fontes' => $item['qtd_fontes'],
                        'valor_por_fonte' => $item['valor_por_fonte'],
                        'total' => $item['total'],
                    ]);
                }
            }

            // Se a proposta for aprovada, cria a OS
            if ($dados['status'] == 'Aprovado') {
                OS::create([
                    'proposta_id' => $proposta->id,
                    'metodologia_documentos' => json_encode([]),
                    'equipamentos_necessarios' => json_encode([]),
                    'observacao' => '',
                    'lixeira' => false,
                ]);
            }

            DB::commit(); // Tudo certo, confirma a transação

            return redirect()->route('propostas.index')
                            ->with('success', 'Proposta criada com sucesso!');
        
        } catch (\Exception $e) {
            DB::rollBack(); // Deu erro, desfaz tudo

            return back()->with('error', 'Erro ao criar proposta: ' . $e->getMessage())
                        ->withInput();
        }
    }


    public function update(Request $request, $id)
    {
        $proposta = Proposta::findOrFail($id);
        $proposta->update($request->all());

        return redirect()->route('os.criar', ['id' => $id])
                        ->with('success', 'Proposta atualizada com sucesso!');
    }
}
