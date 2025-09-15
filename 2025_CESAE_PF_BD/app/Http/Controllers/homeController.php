<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Event;
use App\Models\Alunos;
use App\Models\Modulo;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    public function index(){
//cursos todos
  $mCurso  = Curso::orderBy('titulo')->get();

  $cursosAtivos = Curso::where('cursos.users_id',Auth::id())->where('estado_cursos_id', 1)->get();// contagem de cursos ativos para a blade
  $totalCursosAtivos = $cursosAtivos->count();
  $cursosInativos= Curso::where('cursos.users_id',Auth::id())->where('estado_cursos_id', 2)->get();
  $totalCursosInativos =$cursosInativos->count();
  $novosAlunos = Alunos::join('alunos_modulos','alunos.id','alunos_id')
  ->join('modulos','modulos.id','modulos_id')
  ->join('curso_modulo','modulos.id','modulo_id')
  ->join('cursos','cursos.id','curso_id')
  ->where('cursos.users_id',Auth::id())->whereMonth('alunos.created_at', now()->month)
        ->whereYear('alunos.created_at', now()->year)
        ->count();

  $modulos = Modulo::orderBy('nomeModulo')->get(); // podes deixar vazio se quiseres forçar o filtro
  $apontamentosHoje= Event::get(); // vou ao event model buscar todos os eventos
  $alunos=Alunos::join('alunos_modulos','alunos.id','alunos_id')
  ->join('modulos','modulos.id','modulos_id')
  ->join('curso_modulo','modulos.id','modulo_id')
  ->join('cursos','cursos.id','curso_id')
  ->where('cursos.users_id',Auth::id())->get();// puxa os alunos todos

  $aulasTotais=Event::where('users_id',Auth::id())->where('modulos_id')->whereMonth('created_at',now())->count();

  $aulasSemanaAtual = Event::where('users_id',Auth::id())->whereBetween(
    'start',
    [now()->startOfWeek(), now()->endOfWeek()] // seg→dom
)
->count();




  $instituicoes = Instituicao::all();
  // ajusta o nome da view para o que usas no dashboard
  return view('home', compact('modulos','instituicoes','mCurso','apontamentosHoje','alunos','totalCursosAtivos','totalCursosInativos','novosAlunos','aulasTotais','aulasSemanaAtual'));
    }
}
