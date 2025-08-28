<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cursoController extends Controller
{
     public function index(){
        return view('cursos.cursos_home');
    }
    public function curso_adicionar(){
        return view('cursos.curso_adicionar');
    }
}
