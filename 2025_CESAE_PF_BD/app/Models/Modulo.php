<?php

namespace App\Models;

use App\Models\Curso;
use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modulo extends Model
{
    use HasFactory;

    protected $fillable = ['nomeModulo', 'descricao', 'duracaoHoras'];

   public function cursos()
{
    return $this->belongsToMany(Curso::class, 'curso_modulo', 'modulo_id', 'curso_id');
}

    // Relacionamento com Event
    public function events()
    {
        return $this->hasMany(Event::class, 'modulos_id');
    }

    // Método para retornar todos os cursos com indicação de associação
    public function todosCursosComAssociacao()
    {
        $cursos = Curso::with('instituicao')->get();

        return $cursos->map(function ($curso) {
            // Marca os cursos que pertencem a este módulo
            $curso->associado = $this->cursos->contains($curso->id);
            return $curso;
        });
    }
// Modulo.php
public function todosCursosPorInstituicao()
{
    $cursos = Curso::with('instituicao')->get();

    // Marca os cursos que pertencem a este módulo
    $cursos = $cursos->map(function ($curso) {
        $curso->associado = $this->cursos->contains($curso->id);
        return $curso;
    });

    // Agrupa por instituição
    return $cursos->groupBy(function ($curso) {
        return $curso->instituicao->id ?? 0;
    });
}

public function cursoModulos() {
    return $this->hasMany(CursoModulo::class, 'modulo_id', 'id');
}

}
