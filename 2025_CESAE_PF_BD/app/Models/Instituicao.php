<?php

namespace App\Models;

use App\Models\Financa;
use App\Models\Recebimento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    // Relação com recebimentos
    public function recebimentos(){
        return $this->hasMany(Recebimento::class, 'instituicoes_id');
    }

    // Relação com finanças
     public function financas(){
        return $this->hasMany(Financa::class, 'instituicoes_id');
    }
}
