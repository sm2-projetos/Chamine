<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropostaGrupo extends Model
{
    use HasFactory;

    protected $table = 'proposta_grupos';

    protected $fillable = [
        'nome',
        'proposta_id',
    ];

    public function proposta()
    {
        return $this->belongsTo(Proposta::class, 'proposta_id');
    }

    public function metodologias()
    {
        return $this->hasMany(Metodologia::class, 'grupo_id');
    }
}
