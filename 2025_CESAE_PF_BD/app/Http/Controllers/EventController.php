<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Event;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Retorna todos os eventos em JSON (com relações para o front)
    public function index()
    {
        $events = Event::with('modulo.cursos')->get();
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

        $event = Event::create([
            'title'      => $finalTitle,
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
            'title'      => $requset->title,
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
        $cursoNome  = $cursoId  ? (Curso::find($cursoId)->titulo ?? null) : null;
        $moduloNome = $moduloId ? (Modulo::find($moduloId)->nomeModulo ?? null) : null;

        if ($title && $moduloNome) return "{$title} {$moduloNome}";
        if ($title && $cursoNome)  return "{$title} {$cursoNome}";
        if (!$title && $moduloNome) return $moduloNome;
        if (!$title && $cursoNome)  return $cursoNome;
        if (!$title && $cursoNome && $moduloNome) return $moduloNome;

        return $title ?: 'Evento';
    }
}
