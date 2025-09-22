<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlunoModulo extends Model
{
    use HasFactory;

    protected $table = 'alunos_modulos';

    protected $fillable = ['nome','email','telefone','observacoes'];

    public function modulos()
    {
        return $this->belongsToMany(
                Modulo::class,
                'notaAluno',
                'modulos_id',
                'alunos_id',
                'estado_alunos_id'
            )
             ->withTimestamps();
    }
}
