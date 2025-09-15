<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
    $mCurso  = Curso::where('users_id',Auth::id())->orderBy('titulo')->get();
    $modulos = Modulo::orderBy('nomeModulo')->get();

    return view('calendario.calendar', compact('mCurso', 'modulos'));
    }
}
