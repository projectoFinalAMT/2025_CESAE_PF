<?php

namespace App\Models;

use App\Models\Modulo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alunos extends Model
{
    use HasFactory;

    protected $table = 'alunos';

    protected $fillable = ['nome','email','telefone','observacoes'];

    public function modulos()
    {
        return $this->belongsToMany(
                Modulo::class,
                'alunos_modulos',
                'alunos_id',
                'modulos_id'
            )->withPivot(['notaAluno','estado_alunos_id'])
             ->withTimestamps();
    }
}
