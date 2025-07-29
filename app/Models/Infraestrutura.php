<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infraestrutura extends Model
{
    protected $fillable = [
        'conjunto_id',
        'conjunto_nome',
        'ordem',
        'tipo',
        'conteudo',
    ];

}
