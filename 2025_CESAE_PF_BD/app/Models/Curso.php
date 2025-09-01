<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curso extends Model
{
     use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'titulo',
        'descrição',
        'duracaoTotal',
        'precoHora',
        'dataInicio',
        'dataFim',
        'instituicoes_id',
        'users_id',
        'estado_cursos_id',
    ];

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class, 'instituicoes_id');
    }
}
