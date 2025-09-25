<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Event;
use App\Models\Alunos;
use App\Models\Modulo;
use App\Models\Documento;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use App\Models\DocumentoModulo;
use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    public function index(){
//info de cursos
  $mCurso  = Curso::where('cursos.users_id',Auth::id())->orderBy('titulo')->get();
  $cursosAtivos = Curso::where('cursos.users_id',Auth::id())->where('estado_cursos_id', 1)->get();
  $totalCursosAtivos = $cursosAtivos->count();
  $cursosInativos= Curso::where('cursos.users_id',Auth::id())->where('estado_cursos_id', 2)->get();
  $totalCursosInativos =$cursosInativos->count();


  //info de alunos
  $novosAlunos = Alunos::join('alunos_modulos','alunos.id','alunos_id')
  ->join('modulos','modulos.id','modulos_id')
  ->join('curso_modulo','modulos.id','modulo_id')
  ->join('cursos','cursos.id','curso_id')
  ->where('cursos.users_id',Auth::id())->whereMonth('alunos.created_at', now()->month)
        ->whereYear('alunos.created_at', now()->year)
        ->count();
    $alunos=Alunos::join('alunos_modulos','alunos.id','alunos_id')
  ->join('modulos','modulos.id','modulos_id')
  ->join('curso_modulo','modulos.id','modulo_id')
  ->join('cursos','cursos.id','curso_id')
  ->where('cursos.users_id',Auth::id())->get();

  //info de modulos e instituições
  $modulos = Modulo::orderBy('nomeModulo')->get(); // podes deixar vazio se quiseres forçar o filtro
  $instituicoes = Instituicao::where('users_id',Auth::id())->get();

  //info de agenda
  $apontamentosHoje= Event::where('users_id',Auth::id())->get(); // vou ao event model buscar todos os eventos
  $aulasTotais = Event::where('users_id', Auth::id())
  ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
  ->count();
$aulasSemanaAtual = Event::where('users_id',Auth::id())->whereBetween(
    'start',
    [now()->startOfWeek(), now()->endOfWeek()] // seg→dom
    )->count();

    // info de documentos
    $documentos= Documento::where('users_id',Auth::id())->count();
    $documentosExpirar = Documento::where('users_id', Auth::id())
    ->whereBetween('dataValidade', [now(), now()->addMonth()])
    ->count();

  return view('home', compact('modulos','instituicoes','mCurso','apontamentosHoje','alunos','totalCursosAtivos','totalCursosInativos','novosAlunos','aulasTotais','aulasSemanaAtual','documentos','documentosExpirar'));
    }
}
