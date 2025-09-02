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

    //cor texto
    private function pickTextColor(string $hex): string
{
    // remove '#'
    $hex = ltrim($hex, '#');

    // rgb 0–255
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // luminância relativa simples
    $luminance = (0.299*$r + 0.587*$g + 0.114*$b) / 255;

    return $luminance > 0.6 ? '#000000' : '#FFFFFF'; // claro -> texto preto, escuro -> texto branco
}

    // Método opcional para facilitar o FullCalendar
    public function toCalendarArray()
    {
        $cursoId = null;
        $cursoTitulo = null;
        $moduloNome = null;
        $bg = '#3788d8'; // cor default quando não há módulo
        $text = '#ffffff';

        if ($this->modulo) {
            $moduloNome = $this->modulo->nomeModulo ?? null;

            // se o módulo tiver cor, usa-a
            if (!empty($this->modulo->cor)) {
                $bg = $this->modulo->cor;
                $text = $this->pickTextColor($bg);
            }

            // se usas relação N:N curso<->módulo, obter o primeiro curso
            $curso = $this->modulo->cursos()->select('cursos.id','cursos.titulo')->first();
            if ($curso) {
                $cursoId = $curso->id;
                $cursoTitulo = $curso->titulo;
            }
        }

        // título conforme lógica que definimos
        $title = $this->title ?? ($moduloNome ?? $cursoTitulo ?? 'Evento');

        return [
            'id'           => $this->id,
            'title'        => $title,
            'start'        => $this->start,
            'end'          => $this->end,

            // cores para o FullCalendar
            'backgroundColor' => $bg,
            'borderColor'     => $bg,
            'textColor'       => $text,

            // extra props para o teu JS
            'nota'         => $this->nota,
            'modulos_id'   => $this->modulos_id,
            'curso_id'     => $cursoId,
            'curso_titulo' => $cursoTitulo,
            'modulo_nome'  => $moduloNome,
        ];
    }


}
