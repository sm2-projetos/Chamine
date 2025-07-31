<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metodologia extends Model
{
    use HasFactory;

    protected $table = 'metodologias';

    protected $fillable = [
        'grupo_id',
        'nome',
        'acreditado'
    ];

    public function grupo()
    {
        return $this->belongsTo(PropostaGrupo::class, 'grupo_id');
    }
}
