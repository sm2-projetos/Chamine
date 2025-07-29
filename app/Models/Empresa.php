<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'endereco',
        'email',
        'cep',
        'telefone',
        'nome_contato',
        'telefone_contato',
        'email_contato',
        'lixeira',
    ];


     public static function buscarPorCnpjComPerfis($cnpj)
    {
        return DB::table('empresas')
            ->join('tabela_perfil', DB::raw("CONVERT(empresas.nome USING utf8mb4) COLLATE utf8mb4_general_ci"), '=', DB::raw("tabela_perfil.empresa_nome"))
            ->where('empresas.cnpj', $cnpj)
            ->where('empresas.lixeira', false)
            ->select(
                'empresas.id as empresa_id',
                'empresas.nome as empresa_nome',
                'empresas.cnpj',
                // Adicione outros campos que desejar da tabela empresas
                'tabela_perfil.id_perfil',
                'tabela_perfil.projeto',
                'tabela_perfil.empresa_nome as perfil_empresa_nome'
            )
            ->first();
    }
}