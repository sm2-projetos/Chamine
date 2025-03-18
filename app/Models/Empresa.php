<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'endereco',
        'contato',
        'lixeira',
    ];

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_empresa', 'empresa_id', 'cliente_id');
    }
}