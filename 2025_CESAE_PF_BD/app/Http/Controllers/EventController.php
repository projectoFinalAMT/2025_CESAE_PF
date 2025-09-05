<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Event;
use App\Models\Modulo;
use Illuminate\Http\Request;
use App\Exports\EventsExport;             
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller
{
    // Retorna todos os eventos em JSON (com relações para o front)
    public function index()
    {
        $events = Event::with('modulo.cursos.instituicao','curso.instituicao')->get();
        $calendarEvents = $events->map(fn($e) => $e->toCalendarArray());

        return response()->json($calendarEvents);
    }

    // Cria um novo evento
    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'nullable|string|max:255',
            'cursos_id'  => 'nullable|exists:cursos,id',
            'modulos_id' => 'nullable|exists:modulos,id',
            'start'      => 'required|date',
            'end'        => 'required|date|after_or_equal:start',
            'nota'       => 'nullable|string|max:255',


        ]);


        if ($request->filled('cursos_id') && $request->filled('modulos_id')) {
            $belongs = Modulo::where('id', $request->modulos_id)
                ->whereHas('cursos', fn($q) => $q->where('cursos.id', $request->cursos_id))
                ->exists();

            if (!$belongs) {
                return response()->json([
                    'message' => 'O módulo selecionado não pertence ao curso escolhido.'
                ], 422);
            }
        }

        $finalTitle = $this->buildTitle($request->title, $request->cursos_id, $request->modulos_id);

        $event = Event::create([
            'title'      => $finalTitle,
            'cursos_id'  => $request->cursos_id,
            'modulos_id' => $request->modulos_id,
            'start'      => $request->start,
            'end'        => $request->end,
            'nota'       => $request->nota,
            'users_id'   => Auth::id() ?? 1, // fallback para demo
        ]);

        return response()->json([
            'success' => true,
            'event'   => $event->toCalendarArray(),
        ]);
    }

    // Atualiza um evento existente
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'      => 'nullable|string|max:255',
            'cursos_id'  => 'nullable|exists:cursos,id',
            'modulos_id' => 'nullable|exists:modulos,id',
            'start'      => 'required|date',
            'end'        => 'required|date|after_or_equal:start',
            'nota'       => 'nullable|string|max:255',
        ]);

        // (opcional) validar consistência curso↔módulo se ambos vierem
        if ($request->filled('cursos_id') && $request->filled('modulos_id')) {
            $belongs = Modulo::where('id', $request->modulos_id)
                ->whereHas('cursos', fn($q) => $q->where('cursos.id', $request->cursos_id))
                ->exists();

            if (!$belongs) {
                return response()->json([
                    'message' => 'O módulo selecionado não pertence ao curso escolhido.'
                ], 422);
            }
        }

        $finalTitle = $this->buildTitle($request->title, $request->cursos_id, $request->modulos_id);

        $event->update([
            'title'      => $finalTitle,
            'cursos_id'  => $request->cursos_id,
            'modulos_id' => $request->modulos_id,
            'start'      => $request->start,
            'end'        => $request->end,
            'nota'       => $request->nota,
        ]);

        return response()->json([
            'success' => true,
            'event'   => $event->toCalendarArray(),
        ]);
    }

    // Apaga um evento
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Regras do título:
     * 1) Título + módulo -> "título nomeDoMódulo"
     * 2) Título + curso  -> "título nomeDoCurso"
     * 3) Sem título + módulo -> "nomeDoMódulo"
     * 4) Sem título + curso  -> "nomeDoCurso"
     * 5) Só título -> "título"
     * 6) Nada -> "Evento"
     */
    private function buildTitle(?string $title, ?int $cursoId, ?int $moduloId): string
    {
        $cursoNome  = null;
        $instNome   = null;
        $moduloNome = null;

        if ($moduloId) {
            $mod = \App\Models\Modulo::with(['cursos.instituicao'])->find($moduloId);
            if ($mod) {
                $moduloNome = $mod->nomeModulo ?? null;

                $curso = $mod->cursos->first();
                if ($curso) {
                    $cursoNome = $curso->titulo ?? $curso->nomeCurso ?? null;

                    $inst = $curso->instituicao;
                    if ($inst) {
                        $instNome = $inst->nomeInstituicao ?? null; // <- usa a coluna certa
                    }
                }
            }
        } elseif ($cursoId) {
            $curso = \App\Models\Curso::with('instituicao')->find($cursoId);
            if ($curso) {
                $cursoNome = $curso->titulo ?? $curso->nomeCurso ?? null;

                $inst = $curso->instituicao;
                if ($inst) {
                    $instNome = $inst->nomeInstituicao ?? null; // <- usa a coluna certa
                }
            }
        }

        // Regras de título
        if ($title && $moduloNome)       { $base = "{$title} {$moduloNome}"; }
        elseif ($title && $cursoNome)    { $base = "{$title} {$cursoNome}"; }
        elseif (!$title && $moduloNome)  { $base = $moduloNome; }
        elseif (!$title && $cursoNome)   { $base = $cursoNome; }
        else                             { $base = $title ?: 'Evento'; }

        // Sufixo (Instituição) se existir
        if ($instNome) {
            $base .= " ({$instNome})";
        }

        return $base;
    }

    //exportar excell
    public function exportExcel(Request $request)
    {
        // podes filtrar por range se quiseres (exemplo: week, month)
        $range = $request->get('range', 'all');

        return Excel::download(new EventsExport($range), 'agenda.xlsx');
    }


}
