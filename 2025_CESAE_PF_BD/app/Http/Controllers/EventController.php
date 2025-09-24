<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Event;
use App\Models\Modulo;
use Illuminate\Http\Request;
use App\Exports\EventsExport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller
{
    // Retorna todos os eventos em JSON (com relações para o front)
    public function index()
    {
        $events = Event::where('users_id',Auth::id())->with('modulo.cursos.instituicao','curso.instituicao')->get();
        $calendarEvents = $events->map(fn($e) => $e->toCalendarArray());

        return response()->json($calendarEvents);
    }

    // Cria um novo evento
    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'nullable|string|max:255',
           'cursos_id'  => ['nullable',Rule::exists('cursos', 'id')->where('users_id', Auth::id())
        ,
    ],
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
            'users_id'   => Auth::id()
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
           'cursos_id'  => ['nullable',Rule::exists('cursos', 'id')->where('users_id', Auth::id())],
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
     * 1) Título + módulo -> "título nomeDoMódulo Instituição"
     * 2) Título + curso  -> "título nomeDoCurso Instituição"
     * 3) Sem título + módulo -> "nomeDoMódulo Instituição"
     * 4) Sem título + curso  -> "nomeDoCurso Instituição"
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
                    $instNome = $inst->nomeInstituicao ?? null;
                }
            }
        }
    } elseif ($cursoId) {
        $curso = \App\Models\Curso::with('instituicao')->find($cursoId);
        if ($curso) {
            $cursoNome = $curso->titulo ?? $curso->nomeCurso ?? null;

            $inst = $curso->instituicao;
            if ($inst) {
                $instNome = $inst->nomeInstituicao ?? null;
            }
        }
    }

    // ===== regras 1–6 com proteção a duplicação =====
    $hasText = isset($title) && trim($title) !== '';
    $base = $hasText ? trim($title) : null;

    if ($hasText) {
        // 1) Título + módulo -> "título nomeDoMódulo" (só se ainda não contiver)
        if ($moduloNome && stripos($base, $moduloNome) === false) {
            $base .= " {$moduloNome}";
        }
        // 2) Título + curso -> "título nomeDoCurso" (só se não houve módulo e ainda não contiver)
        elseif ($cursoNome && stripos($base, $cursoNome) === false) {
            $base .= " {$cursoNome}";
        }
        // 5) Só título -> fica como está
    } else {
        // 3) Sem título + módulo -> "nomeDoMódulo"
        if ($moduloNome) {
            $base = $moduloNome;
        }
        // 4) Sem título + curso -> "nomeDoCurso"
        elseif ($cursoNome) {
            $base = $cursoNome;
        }
        // 6) Nada -> "Evento"
        else {
            $base = 'Evento';
        }
    }

    // Sufixo da instituição — só se ainda não existir (case-insensitive)
    if ($instNome && stripos($base, "({$instNome})") === false) {
        $base .= " ({$instNome})";
    }

    return $base;
}


    //exportar excell

    public function exportExcel(Request $request)
    {
        $start = $request->query('start'); // pode ser string ISO
        $end   = $request->query('end');
        $userId = Auth::id();

        $filename = 'agenda_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new EventsExport($start, $end, $userId), $filename);
    }


}
