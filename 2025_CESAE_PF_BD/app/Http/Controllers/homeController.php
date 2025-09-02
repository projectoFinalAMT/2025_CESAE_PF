<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Event;
use App\Models\Modulo;
use App\Models\Instituicao;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index(){
  // Calendario dashboard para o <select>
  $mCurso  = Curso::orderBy('titulo')->get();
  $modulos = Modulo::orderBy('nomeModulo')->get(); // podes deixar vazio se quiseres forçar o filtro
  $apontamentosHoje= Event::get(); // vou ao event model buscar todos os eventos


  $instituicoes = Instituicao::all();
  // ajusta o nome da view para o que usas no dashboard
  return view('home', compact('modulos','instituicoes','mCurso','apontamentosHoje'));
    }
}
