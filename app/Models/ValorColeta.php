<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValorColeta extends Model
{
    protected $table = 'sistemachamine.tabela_valores_coletas';
    protected $primaryKey = 'id_valor';
    public $timestamps = false;

    protected $fillable = [
        'id_perfil',
        'id_parametro',
        'numero_coleta',
        'valor',
    ];

    // Relacionamento: pertence a um Perfil
    public function perfil()
    {
        return $this->belongsTo(TabelaPerfil::class, 'id_perfil');
    }

    // Relacionamento: pertence a um Parâmetro
    public function parametro()
    {
        return $this->belongsTo(Parametro::class, 'id_parametro');
    }

    public static function getDetalhesPorPerfil($idPerfil)
{
    return self::query()
        ->join('sistemachamine.tabela_parametros as p', 'sistemachamine.tabela_valores_coletas.id_parametro', '=', 'p.id_parametro')
        ->select(
            'sistemachamine.tabela_valores_coletas.numero_coleta',
            'sistemachamine.tabela_valores_coletas.valor',
            'p.nome as parametro_nome',
            'p.unidade as parametro_unidade'
        )
        ->where('sistemachamine.tabela_valores_coletas.id_perfil', $idPerfil)
        ->orderBy('p.nome')
        ->orderBy('sistemachamine.tabela_valores_coletas.numero_coleta')
        ->get();
}
}
