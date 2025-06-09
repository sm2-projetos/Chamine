<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerfilChamine;

class PerfilController extends Controller
{
    public function getProfilesByEmpresa(Request $request)
    {
        $empresaNome = $request->input('empresa_nome'); // Recebendo o nome da empresa

        if (!$empresaNome) {
            return response()->json(['perfis' => []]); // Retorna array vazio se não tiver empresa selecionada
        }

        // Buscar apenas os perfis vinculados à empresa selecionada (comparação pelo nome)
        $perfis = PerfilChamine::where('empresa_nome', $empresaNome)->get();

        return response()->json(['perfis' => $perfis]);
    }
}
