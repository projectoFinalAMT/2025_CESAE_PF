<?php

namespace App\Models;

use App\Models\Curso;
use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modulo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomeModulo',
        'descricao',
        'duracaoHoras',
        'cursos_id',
    ];

    // Relacionamento com Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'cursos_id');
    }

    // Relacionamento com Event
    public function events()
    {
        return $this->hasMany(Event::class, 'modulos_id');
    }
}
