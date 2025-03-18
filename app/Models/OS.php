<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OS extends Model
{
    use HasFactory;

    protected $table = 'os'; // Especifica explicitamente o nome da tabela

    protected $fillable = [
        'proposta_id',
        'perfil_id',
        'metodologia_documentos',
        'equipamentos_necessarios',
        'observacao',
        'lixeira',
    ];

    protected $casts = [
        'metodologia_documentos' => 'array',
        'equipamentos_necessarios' => 'array',
    ];

    public function proposta()
    {
        return $this->belongsTo(Proposta::class, 'proposta_id');
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }
}