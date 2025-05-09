<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilChamine extends Model
{
    use HasFactory;

    protected $table = 'tabela_perfil';

    protected $primaryKey = 'id_perfil'; // Define a chave primária como id_perfil

    protected $fillable = ['empresa_nome', 'projeto'];
}