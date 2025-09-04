<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model
{
    use HasFactory;

    // Diz explicitamente qual tabela o model deve usar
    protected $table = 'instituicoes';

    // Campos que podem ser preenchidos em massa (mass assignment)
    protected $fillable = [
        'nomeInstituicao',
        'morada',
        'NIF',
        'emailResponsavel',
        'nomeResponsavel',
        'telefoneResponsavel',
        'cor',
        'users_id',
    ];
}
