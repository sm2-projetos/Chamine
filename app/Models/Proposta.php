<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cliente',
        'id_empresa',
        'analise_critica',
        'fonte_emissao',
        'numero_fontes',
        'parametros',
        'servicos_custos',
        'observacoes',
        'status',
        'lixeira',
    ];

    protected $casts = [
        'servicos_custos' => 'array',
    ];

    public function os()
    {
        return $this->hasOne(OS::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}