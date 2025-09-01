<?php

namespace App\Models;

use App\Models\User;
use App\Models\Curso;
use App\Models\Modulo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory; //habilitar a factory do Eloquent

    // Campos que podem ser preenchidos via mass assignment
    protected $fillable = [
        'title',
        'nota',
        'start',
        'end',
        'users_id',
        'modulos_id',
    ];

    // Relacionamento com User (formador)
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Relacionamento com Modulo
    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'modulos_id');
    }

    // Acesso facilitado ao curso do módulo
    public function curso()
    {
        return $this->hasOneThrough(
            Curso::class,      // Modelo final (Curso)
            Modulo::class,     // Modelo intermédio (Modulo)
            'id',              // Chave local da tabela Modulo na relação (modulos.id)
            'id',              // Chave local da tabela Curso (cursos.id)
            'modulos_id',      // Chave local do Event para Modulo
            'cursos_id'        // Chave estrangeira de Modulo para Curso
        );
    }

    // Método opcional para facilitar o FullCalendar
    public function toCalendarArray()
    {
        return [
            'id'    => $this->id,
            'title' => $this->title ?? ($this->modulo->nomeModulo ?? 'Evento'),
            'start' => $this->start,
            'end'   => $this->end,
            'color' => $this->modulo->cor ?? '#3788d8',
            'nota'       => $this->nota,
            'modulos_id' => $this->modulos_id,
        ];
    }
}
