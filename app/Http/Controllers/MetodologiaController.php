<?php

namespace App\Http\Controllers;
use App\Models\Metodologia;
use App\Models\PropostaGrupo;


class MetodologiaController extends Controller
{
    public function index()
    {
        $grupos = PropostaGrupo::with('metodologias')->get();
        return view('metodologia.index', compact('grupos'));
    }

}