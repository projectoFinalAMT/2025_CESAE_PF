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
        'cursos_id'
    ];

    // >>> ACRESCIMO: casts para datas
    protected $casts = [
        'start' => 'datetime',
        'end'   => 'datetime',
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
        return $this->belongsTo(Curso::class, 'cursos_id');

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

        // cor por defeito
        $bg = '#3788d8';
        $text = '#ffffff';

        if ($this->modulo) {
            $moduloNome = $this->modulo->nomeModulo ?? null;

            $curso = $this->modulo
                ->cursos()
                ->with('instituicao') // precisa para ler nome/cor
                ->first();

            if ($curso) {
                $cursoId     = $curso->id;
                $cursoTitulo = $curso->titulo ?? $curso->nomeCurso ?? null;

                if ($curso->instituicao) {
                    // cor vem da instituição
                    $bg = $curso->instituicao->cor ?? $bg;
                }
            }
        }
        elseif ($this->curso) {
            $cursoId     = $this->curso->id;
            $cursoTitulo = $this->curso->titulo ?? $this->curso->nomeCurso ?? null;

            if ($this->curso->instituicao) {
                $bg = $this->curso->instituicao->cor ?? $bg;
            }
        }

        $text = $this->pickTextColor($bg);

        // já vem pronto do DB (pois no controller usamos buildTitle)
        $title = $this->title ?? ($moduloNome ?? $cursoTitulo ?? 'Evento');

        return [
            'id'           => $this->id,
            'title'        => $title,
            'start'        => $this->start,
            'end'          => $this->end,
            'color'        => $bg,
            'textColor'    => $text,

            'nota'         => $this->nota,
            'modulos_id'   => $this->modulos_id,
            'curso_id'     => $cursoId,
            'curso_titulo' => $cursoTitulo,
            'modulo_nome'  => $moduloNome,
            'instituicao_cor' => $bg,

        ];
    }

    // >>> ACRESCIMO: scopes para reutilizar em queries/exports
    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('users_id', $userId);
    }

    public function scopeBetween($query, $start, $end)
    {
        if ($start && $end) {
            return $query->whereBetween('start', [$start, $end]);
        }
        return $query;
    }
}
