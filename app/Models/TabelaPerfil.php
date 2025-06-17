<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TabelaPerfil extends Model
{
    protected $table = 'sistemachamine.tabela_perfil';
    protected $primaryKey = 'id_perfil';
    public $timestamps = false;

    protected $fillable = [
        'projeto',
        'fonte',
        'data_execucao',
        'equipe',
        'empresa_nome',
        'cidade',
        'processo',
        'parametros_medidos',
        'montante',
        'jusante',
        'diametro_medio',
        'jdc',
        'mdc',
        'area_chamine',
        'comprimento',
        'diametro_equivalente',
        'numero_de_pontos',
        'numero_de_eixos',
        'numero_de_prontos_por_eixo',
        'tempo_total_coleta',
        'tempo_por_ponto',
        'created_ar',
    ];

    // Relacionamento: possui vários valores coletados
    public function valores()
    {
        return $this->hasMany(ValorColeta::class, 'id_perfil');
    }
}
