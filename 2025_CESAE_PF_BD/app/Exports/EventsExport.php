<?php

namespace App\Exports;

use App\Models\Event;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventsExport implements FromCollection, WithHeadings
{
    protected string $range;

    public function __construct(string $range = 'all')
    {
        $this->range = $range;
    }

    public function collection()
    {
        // Eager load para ambos os caminhos: curso direto e módulo->curso
        $q = Event::with(['curso.instituicao', 'modulo.cursos.instituicao'])
            ->orderBy('start');

        // Filtros simples (podes adaptar)
        if ($this->range === 'today') {
            $q->whereDate('start', Carbon::today());
        } elseif ($this->range === 'week') {
            $q->whereBetween('start', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }

        return $q->get()->map(function ($e) {
            // curso direto OU via módulo
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
