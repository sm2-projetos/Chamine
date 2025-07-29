<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Legislacao;
class LegislacaoController extends Controller
{
    public function index() {
        $legislacoes = Legislacao::all();
        return view('legislacao', compact('legislacoes'));
    }

    public function store(Request $request) {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        Legislacao::create($request->only('nome', 'descricao'));
        return back()->with('success', 'Legislação criada com sucesso!');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $legislacao = Legislacao::findOrFail($id);
        $legislacao->update($request->only('nome', 'descricao'));
        return back()->with('success', 'Legislação atualizada com sucesso!');
    }

    public function destroy($id) {
        Legislacao::findOrFail($id)->delete();
        return back()->with('success', 'Legislação excluída com sucesso!');
    }
}
