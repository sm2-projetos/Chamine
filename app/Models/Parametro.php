<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $table = 'sistemachamine.tabela_parametros';
    protected $primaryKey = 'id_parametro';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'unidade',
    ];

    // Relacionamento: possui vários valores coletados
    public function valores()
    {
        return $this->hasMany(ValorColeta::class, 'id_parametro');
    }
}
