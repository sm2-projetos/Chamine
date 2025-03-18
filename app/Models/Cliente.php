<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cliente';
    public $incrementing = true; // Se for autoincremento
    protected $keyType = 'int';

    protected $fillable = [
        'nome',
        'cnpj_cpf',
        'endereco',
        'email',
        'telefone',
        'lixeira',
    ];

    public function empresas()
    {
        return $this->belongsToMany(Empresa::class, 'cliente_empresa', 'cliente_id', 'empresa_id');
    }
}
