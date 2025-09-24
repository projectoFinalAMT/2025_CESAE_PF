<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Alunos;
use App\Models\Modulo;
use App\Models\AlunoModulo;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AlunosController extends Controller
{
    public function index()
    {
        $alunos= Alunos::where('alunos.users_id',Auth::id())-> with('modulos')
        ->get();
        $instituicoes  = Instituicao::where('users_id',Auth::id())->get();
        $cursos        = Curso::where('users_id',Auth::id())->get();

        $modulos       = Modulo::join('curso_modulo','modulos.id','modulo_id')
        ->join('cursos','cursos.id','curso_id')
        ->join('instituicoes','cursos.instituicoes_id','instituicoes.id')
        ->where('cursos.users_id',Auth::id())
        ->select('modulos.nomeModulo',
          'modulos.id',
          'cursos.titulo',
          'instituicoes.nomeInstituicao')
        ->get();





        $novosAlunos = Alunos::
        join('alunos_modulos','alunos.id','alunos_id')
        ->join('modulos','modulos.id','modulos_id')
        ->join('curso_modulo','modulos.id','modulo_id')
        ->join('cursos','cursos.id','curso_id')->whereMonth('alunos.created_at', now()->month)->where('cursos.users_id',Auth::id())
            ->whereYear('alunos.created_at', now()->year)
            ->count();


        $listaAlunos = Alunos:: join('alunos_modulos','alunos.id','alunos_id')
        ->join('modulos','modulos.id','modulos_id')
        ->join('curso_modulo','modulos.id','modulo_id')
        ->join('cursos','cursos.id','curso_id')
        ->where('cursos.users_id',Auth::id())->orderBy('nome', 'asc')->get();





        //modal alunos
        $infoAluno= Curso::where('cursos.users_id',Auth::id())
        ->join('instituicoes', 'cursos.instituicoes_id','instituicoes.id')
        ->join('curso_modulo','cursos.id','curso_id')
        ->join('modulos','curso_modulo.modulo_id','modulos.id')
        ->join('alunos_modulos','modulos.id','modulos_id')
        ->join('alunos','alunos_modulos.alunos_id','alunos.id')
        ->select(
            'alunos.*',
            'modulos.id as modulo_id',
            'alunos_modulos.notaAluno as notaAluno'
        )

        ->get() ;


        //medias alunos
        $maiorMedia= Alunos::where('alunos.users_id',Auth::id())
        ->join('alunos_modulos', 'alunos.id', 'alunos_id')
        ->max('alunos_modulos.notaAluno');
        $piorMedia=Alunos::where('alunos.users_id',Auth::id())
        ->join('alunos_modulos', 'alunos.id', 'alunos_id')
        ->min('alunos_modulos.notaAluno');
        $mediasPorAluno = Alunos::where('alunos.users_id', Auth::id())
    ->join('alunos_modulos', 'alunos.id','alunos_id')
    ->groupBy('alunos.id')
    ->pluck(DB::raw('AVG(alunos_modulos.notaAluno) as media'));
    $mediaDasMedias = $mediasPorAluno->avg();













        $search=request()->query('search')?request()->query('search'):false;
        $alunosPesquisa=$this->getAlunosFromDB($search);



        return view('alunos.alunos', compact('alunos','instituicoes','novosAlunos','cursos','modulos','listaAlunos','infoAluno','alunosPesquisa','maiorMedia','piorMedia','mediaDasMedias'));
    }

    public function alunoinfo()
    {
        $alunos        = Alunos::with('modulos')->get();
        $instituicoes  = Instituicao::all();
        return view('alunos.infoalunos', compact('alunos','instituicoes'));
    }

    // criar um aluno
    public function store(Request $request)
    {
        $request->validate([
            'nome'              => 'required|string|max:255',
            'email'             => 'nullable|email|max:255',
            'telefone'          => 'nullable|string|max:50',
            'observacoes'       => 'nullable|string|max:2000',

            'instituicao_ids'   => ['required','array','min:1'],
            'instituicao_ids.*' => ['integer','exists:instituicoes,id'],

            'curso_ids'         => ['required','array','min:1'],
            'curso_ids.*'       => ['integer','exists:cursos,id'],

            'modulo_ids'        => 'required|array|min:1',
            'modulo_ids.*'      => ['integer','exists:modulos,id'],
            'notaAluno'         => 'nullable|numeric',
        ]);

        // inserir na tabela alunos
        $alunoId = DB::table('alunos')->insertGetId([
            'nome'        => $request->nome,
            'email'       => $request->email ?? null,
            'telefone'    => $request->telefone ?? null,
            'observacoes' => $request->observacoes ?? null,
            'created_at'  => now(),
            'updated_at'  => now(),
            'users_id'    => Auth::id(),
        ]);

        // inserir na tabela alunos_modulos
        foreach ($request->modulo_ids as $id) {
            DB::table('alunos_modulos')->insert([
                'alunos_id'        => $alunoId,
                'modulos_id'       => $id,
                'notaAluno'        => $request->notaAluno ?? 0, // confira o nome da coluna no DB
                'estado_alunos_id' => 1,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        return redirect()
            ->route('alunos_view')
            ->with('success', 'Aluno criado e ligado aos módulos selecionados.');
    }


    public function updateAluno(Request $request)
    {

        // dd($request->all());


        // Validação dos dados
        $validated = $request->validate([
            'nome'        => 'required|string|max:255',
            'email'       => 'nullable|email|max:255',
            'telefone'    => 'nullable|string|max:20',
            'observacoes' => 'nullable|string',
        ]);

        // Atualização dos dados
        Alunos::where('id',$request->aluno_id)
        ->update([
            'nome'        => $validated['nome'],
            'email'       => $validated['email'] ?? null,
            'telefone'    => $validated['telefone'] ?? null,
            'observacoes' => $validated['observacoes'] ?? null,
            'users_id'    => Auth::id(),
        ]);


        return redirect()->route('alunos_view')->with('message', 'Aluno actualizado com sucesso!');
    }




    //barra pesquisa alunos

    private function getAlunosFromDB($search){


        $query = DB::table('alunos')->where('alunos.users_id',Auth::id());

        if($search){
            $query->where('nome','LIKE',"%$search%")
            ->orwhere('email',$search);
        }

        $pesquisaAluno=$query->get();

        return $pesquisaAluno;


      }



      public function delete(Request $request )
{
    // garante que só apagas alunos do utilizador autenticado
    $aluno = Alunos::where('id', $request->id)
        ->where('users_id', Auth::id())
        ->first();

    if (!$aluno) {
        return redirect()
            ->route('alunos_view')
            ->with('error', 'Aluno não encontrado ou não pertence ao seu utilizador.');
    }

    try {
        DB::transaction(function () use ($aluno) {
            // Se tiveres a relação definida no Model (belongsToMany), podes detach:
            // $aluno->modulos()->detach();

            // Como usas tabela 'alunos_modulos', dá para garantir limpando manualmente:
            DB::table('alunos_modulos')->where('alunos_id', $aluno->id)->delete();

            // Apaga o próprio aluno
            $aluno->delete();
        });

        return redirect()
            ->route('alunos_view')
            ->with('success', 'Aluno apagado com sucesso!');
    } catch (\Throwable $e) {
        return redirect()
            ->route('alunos_view')
            ->with('error', 'Erro ao apagar aluno. ' . $e->getMessage());
    }
}







}
