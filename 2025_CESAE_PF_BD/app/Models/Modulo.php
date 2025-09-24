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
        return $this->belongsToMany(Curso::class, 'curso_modulo', 'modulo_id', 'curso_id')
        ->withTimestamps();    }

    // Relacionamento com Event
    public function events()
    {
        return $this->hasMany(Event::class, 'modulos_id');
    }

    // Método para retornar todos os cursos com indicação de associação
    public function todosCursosComAssociacao($id)
    {
        $cursos = Curso::where('users_id',$id)->with('instituicao')->get();

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

public function curso()
{
    return $this->belongsTo(Curso::class, 'cursos_id');
}


public function alunos()
{
    return $this->belongsToMany(
            Alunos::class,
            'alunos_modulos',
            'modulos_id',
            'alunos_id'
        )
        ->withPivot('notaAluno', 'estado_alunos_id')
        ->withTimestamps();
}

public function documentos()
    {
        return $this->belongsToMany(Documento::class, 'documentos_modulos', 'modulos_id', 'documentos_id');
    }

   public function documentosComAssociacao()
{
    // Pega os IDs de documentos associados a este módulo
    $documentosAssociados = $this->documentos->pluck('id')->toArray();

    return Documento::all()->map(function ($documento) use ($documentosAssociados) {
        // Marca como associado se o documento estiver neste módulo
        $documento->associado = in_array($documento->id, $documentosAssociados);
        return $documento;
    });
}

}
