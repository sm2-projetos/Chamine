<?php
namespace App\Http\Controllers;

use App\Models\Infraestrutura;
use Illuminate\Http\Request;

class InfraestruturaController extends Controller
{

    public function create()
    {
        return view('infraestrutura.create');
    }

    public function store(Request $request)
    {   
        $ordemAtual= 0;
        $ultimoConjuntoId = Infraestrutura::max('conjunto_id');

        $novoConjuntoId = is_null($ultimoConjuntoId) ? 1 : $ultimoConjuntoId + 1;

        // Receber o nome do conjunto via form
        $conjuntoNome = $request->input('conjunto_nome');

        // Agora salve os blocos usando esse conjunto_id e nome
        foreach ($request->blocos as $ordem => $bloco) {
            $conteudoFinal = null;

            if ($bloco['tipo'] === 'imagem' && isset($bloco['conteudo'])) {
                $file = $bloco['conteudo'];
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $filename = uniqid('infra_') . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('storage/imagens/infraestrutura'), $filename);
                    $conteudoFinal = 'imagens/infraestrutura/' . $filename;
                }
            } else {
                $conteudoFinal = $bloco['conteudo'];
            }

            Infraestrutura::create([
                'conjunto_id'    => $novoConjuntoId,
                'conjunto_nome'  => $conjuntoNome,
                'ordem'          => $ordem,
                'tipo'           => $bloco['tipo'],
                'conteudo'       => $conteudoFinal,
            ]);
        }

        return redirect()->back()->with('success', 'Infraestrutura salva com sucesso!');
    }
}
