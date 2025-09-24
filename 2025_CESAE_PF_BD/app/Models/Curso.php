<?php

namespace App\Models;

use App\Models\Modulo;
use App\Models\Instituicao;
use Illuminate\Support\Facades\Auth;
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
            return Modulo::query()
                ->leftJoin('curso_modulo', 'modulos.id', '=', 'curso_modulo.modulo_id')
                ->leftJoin('cursos', function ($join) {
                    // a condição de user fica DENTRO do join, assim não elimina módulos “soltos”
                    $join->on('cursos.id', '=', 'curso_modulo.curso_id')
                         ->where('cursos.users_id', Auth::id());
                })
                ->select('modulos.*')
                ->distinct()
                ->with(['cursos' => function ($q) {
                    $q->where('users_id', Auth::id())
                      ->with('instituicao');
                }])
                ->get()
                ->map(function ($modulo) {
                    $modulo->associado = $this->modulos->contains($modulo->id);
                    return $modulo;
                });
        }




}
