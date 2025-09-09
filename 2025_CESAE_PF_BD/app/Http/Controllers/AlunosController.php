<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Alunos;
use App\Models\Modulo;
use App\Models\AlunoModulo;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlunosController extends Controller
{
    public function index()
    {
        $alunos        = Alunos::with('modulos')->get();
        $instituicoes  = Instituicao::all();
        $cursos        = Curso::all();
        $modulos       = Modulo::all();
        

        $novosAlunos = Alunos::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $listaAlunos = Alunos::orderBy('nome', 'asc')->get();

        return view('alunos.alunos', compact('alunos','instituicoes','novosAlunos','cursos','modulos','listaAlunos'));
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
            'email'             => 'nullable|email|max:255|unique:alunos,email',
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

    public function fichaaluno()
    {
        $alunos        = Alunos::with('modulos')->get();
        $instituicoes  = Instituicao::all();
        $cursos        = Curso::all();
        $modulos       = Modulo::all();

        $novosAlunos = Alunos::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $listaAlunos = Alunos::orderBy('nome', 'asc')->get();

        return view('alunos.infoaluno', compact('alunos','instituicoes','novosAlunos','cursos','modulos','listaAlunos'));
    }
}
