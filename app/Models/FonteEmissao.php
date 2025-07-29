<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FonteEmissao extends Model
{
    protected $table = 'fonte_emissao';
    protected $fillable = ['fonte', 'numero_de_fontes', 'numero_de_coletas', 'parametros', 'id_proposta'];

    public function proposta()
    {
        return $this->belongsTo(Proposta::class, 'id_proposta');
    }
}