<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $modulos = Modulo::all(); // todos os módulos para o <select>
        return view('calendario.calendar', compact('modulos'));
    }
}
