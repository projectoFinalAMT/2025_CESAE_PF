<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
      // Retorna todos os eventos do formador logado em JSON
      public function index()
      {
        //   $events = Event::where('users_id', Auth::id())->get();

        //   // Formata os eventos para o FullCalendar
        //   $calendarEvents = $events->map(function($event) {
        //       return $event->toCalendarArray();
        //   });

        //   return response()->json($calendarEvents);

          $events = Event::all(); // pega todos os eventos, sem filtrar por user
    $calendarEvents = $events->map(function($event) {
        return $event->toCalendarArray();
    });

    return response()->json($calendarEvents);
      }



      // Cria um novo evento
      public function store(Request $request)
      {

          $request->validate([
            'title' => 'nullable|string|max:255',
            'modulos_id' => 'nullable|exists:modulos,id',
            'start' => 'required|date',
            'end'   => 'required|date|after_or_equal:start',
            'nota'  => 'nullable|string',
          ]);


          $event = Event::create([
              'title' => $request->title,
              'modulos_id' => $request->modulos_id,
              'start' => $request->start,
              'end' => $request->end,
              'users_id' => Auth::id(),
          ]);

          return response()->json([
              'success' => true,
              'event' => $event->toCalendarArray(),
          ]);
      }

      // Opcional: atualizar um evento
      public function update(Request $request, Event $event)
      {
          $this->authorize('update', $event); // se tiver policies

          $request->validate([
            'title' => 'nullable|string|max:255',
            'modulos_id' => 'nullable|exists:modulos,id',
            'start' => 'required|date',
            'end'   => 'required|date|after_or_equal:start',
            'nota'  => 'nullable|string',
          ]);


          $event->update($request->only('title', 'modulos_id', 'start', 'end'));

          return response()->json([
              'success' => true,
              'event' => $event->toCalendarArray(),
          ]);
      }

      // Opcional: deletar um evento
      public function destroy(Event $event)
      {
          $this->authorize('delete', $event); // se tiver policies
          $event->delete();

          return response()->json(['success' => true]);
      }
}
