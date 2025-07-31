<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropostaMetodologia extends Model
{
    protected $table = 'proposta_metodologia';

    protected $fillable = [
        'proposta_id',
        'metodologia_id',
    ];

    public function proposta()
    {
        return $this->belongsTo(Proposta::class);
    }

    public function metodologia()
    {
        return $this->belongsTo(Metodologia::class);
    }
}
