<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoModulo extends Model
{
    protected $table = 'curso_modulo'; // força o Laravel a usar o nome correto
    public $timestamps = false; // se não tiver created_at/updated_at
    protected $fillable = ['curso_id', 'modulo_id']; // ajuste conforme sua tabela
}
