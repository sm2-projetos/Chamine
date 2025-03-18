<?php

namespace App\Http\Controllers;

use App\Models\OS;
use App\Models\PerfilChamine;
use App\Models\Empresa;
use Illuminate\Http\Request;

class OSController extends Controller
{
    public function create()
    {
        return view('os.create');
    }

    public function store(Request $request)
    {
        // Lógica para armazenar a OS
        // Por exemplo:
        // OS::create($request->all());

        return redirect()->route('os.create')->with('success', 'OS criada com sucesso!');
    }

    public function showForm($id)
    {
        $os = OS::findOrFail($id);
        $proposta = $os->proposta; // Obter a proposta associada à OS
        $empresa = Empresa::findOrFail($proposta->id_empresa); // Buscar a empresa pelo ID
        $perfis = PerfilChamine::where('empresa_nome', $empresa->nome)->get(); // Buscar perfis pelo nome da empresa

        return view('os.form', compact('os', 'perfis'));
    }
}
