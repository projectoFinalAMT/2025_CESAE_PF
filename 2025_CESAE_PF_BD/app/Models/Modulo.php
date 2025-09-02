<?php

namespace App\Models;

use App\Models\Curso;
use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modulo extends Model
{
    use HasFactory;

    protected $fillable = ['nomeModulo', 'descricao', 'duracaoHoras','cor'];

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_modulo', 'modulo_id', 'curso_id')
        ->withTimestamps();    }

    // Relacionamento com Event
    public function events()
    {
        return $this->hasMany(Event::class, 'modulos_id');
    }
}
