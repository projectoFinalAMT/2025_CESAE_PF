<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Instituicao;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index(){
  // Calendario dashboard para o <select>
  $modulos = Modulo::orderBy('nomeModulo')->get(['id','nomeModulo']);

  $instituicoes = Instituicao::all();
  // ajusta o nome da view para o que usas no dashboard
  return view('home', compact('modulos','instituicoes'));
    }
}
