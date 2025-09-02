<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Modulo;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $mCurso  = Curso::orderBy('titulo')->get();
    $modulos = Modulo::orderBy('nomeModulo')->get(); // podes deixar vazio se quiseres forçar o filtro

    return view('calendario.calendar', compact('mCurso', 'modulos'));
    }
}
