<?php

namespace App\Http\Controllers;

use App\Models\Alunos;
use Illuminate\Http\Request;

class AlunosController extends Controller
{
    public function index(){
        $alunos = Alunos::all();

        return view('alunos.alunos', compact('alunos'));
}
}
