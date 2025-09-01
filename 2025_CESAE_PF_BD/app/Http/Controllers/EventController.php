<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Retorna todos os eventos em JSON
    public function index()
    {
        // Se quiseres filtrar por utilizador, descomenta:
        // $events = Event::where('users_id', Auth::id())->get();

        $events = Event::all(); // todos os eventos (sem filtro de utilizador)
        $calendarEvents = $events->map(function ($event) {
            return $event->toCalendarArray();
        });

        return response()->json($calendarEvents);
    }

    // Cria um novo evento
    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'nullable|string|max:255',
            'modulos_id' => 'nullable|exists:modulos,id',
            'start'      => 'required|date',
            'end'        => 'required|date|after_or_equal:start',
            'nota'       => 'nullable|string|max:255',
        ]);

        $event = Event::create([
            'title'      => $request->title,
            'modulos_id' => $request->modulos_id,
            'start'      => $request->start,
            'end'        => $request->end,
            'nota'       => $request->nota,
            'users_id'   => Auth::id(), // atenção: precisa de utilizador autenticado
        ]);

        return response()->json([
            'success' => true,
            'event'   => $event->toCalendarArray(),
        ]);
    }

    // Atualiza um evento existente
    public function update(Request $request, Event $event)
    {
        // Só se tiveres policies criadas
        // $this->authorize('update', $event);

        $request->validate([
            'title'      => 'nullable|string|max:255',
            'modulos_id' => 'nullable|exists:modulos,id',
            'start'      => 'required|date',
            'end'        => 'required|date|after_or_equal:start',
            'nota'       => 'nullable|string|max:255',
        ]);

        $event->update($request->only('title', 'modulos_id', 'start', 'end', 'nota'));

        return response()->json([
            'success' => true,
            'event'   => $event->toCalendarArray(),
        ]);
    }

    // Apaga um evento
    public function destroy(Event $event)
    {
        // Só se tiveres policies criadas
        // $this->authorize('delete', $event);

        $event->delete();

        return response()->json(['success' => true]);
    }
}
