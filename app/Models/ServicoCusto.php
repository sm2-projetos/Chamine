<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicoCusto extends Model
{
    protected $table = 'servicos_custos';
    protected $fillable = ['descricao', 'coletas_por_fontes', 'qtd_fontes', 'valor_por_fonte', 'total', 'id_proposta'];

    public function proposta()
    {
        return $this->belongsTo(Proposta::class, 'id_proposta');
    }
}