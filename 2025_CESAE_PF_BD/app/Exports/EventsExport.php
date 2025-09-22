<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventsExport implements FromCollection, WithHeadings
{
    protected ?string $start;
    protected ?string $end;

    public function __construct(?string $start = null, ?string $end = null)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    public function collection()
    {
        $q = Event::with(['curso.instituicao', 'modulo.cursos.instituicao'])
            ->orderBy('start');

        if ($this->start && $this->end) {
            $q->whereBetween('start', [$this->start, $this->end]);
        }

        return $q->get()->map(function ($e) {
            $curso = $e->curso ?: $e->modulo?->cursos?->first();
            $inst  = $curso?->instituicao;

            return [
                'ID'           => $e->id,
                'Título'       => $e->title,
                'Curso'        => $curso?->titulo ?? $curso?->nomeCurso ?? '-',
                'Módulo'       => $e->modulo?->nomeModulo ?? '-',
                'Instituição'  => $inst?->nomeInstituicao ?? '-',
                'Início'       => (string) $e->start,
                'Fim'          => (string) $e->end,
                'Nota'         => $e->nota ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Título',
            'Curso',
            'Módulo',
            'Instituição',
            'Início',
            'Fim',
            'Nota',
        ];
    }
}
