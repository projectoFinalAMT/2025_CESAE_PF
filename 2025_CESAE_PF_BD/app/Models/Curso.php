<?php

namespace App\Models;

use App\Models\Modulo;
use App\Models\Instituicao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curso extends Model
{
     use HasFactory;

    protected $table = 'cursos';


    protected $fillable = [
        'titulo',
        'descricao',
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

    // Relacionamento com Modulos

    public function modulos()
    {
        return $this->belongsToMany(Modulo::class, 'curso_modulo', 'curso_id', 'modulo_id')
        ->withTimestamps();    }

   public function modulosComAssociacao()
    {
        return Modulo::with('cursos.instituicao')->get()->map(function ($modulo) {
            $modulo->associado = $this->modulos->contains($modulo->id);
            return $modulo;
        });
    }
       


}
