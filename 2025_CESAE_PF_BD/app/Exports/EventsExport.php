<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth; // <- acrescento

class EventsExport implements FromCollection, WithHeadings
{
    protected ?string $start;
    protected ?string $end;
    protected ?int $userId; // <- acrescento

    public function __construct(?string $start = null, ?string $end = null, ?int $userId = null) // <- acrescento $userId opcional
    {
        $this->start  = $start;
        $this->end    = $end;
        $this->userId = $userId;
    }

    public function collection()
    {
        $q = Event::with(['curso.instituicao', 'modulo.cursos.instituicao'])
            ->ownedBy($this->userId ?? Auth::id())        
            ->between($this->start, $this->end)
            ->orderBy('start');

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
