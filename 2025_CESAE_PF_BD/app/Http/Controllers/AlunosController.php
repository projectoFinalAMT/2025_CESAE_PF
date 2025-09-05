<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Alunos;
use App\Models\Modulo;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlunosController extends Controller
{
    public function index()
    {
        $alunos        = Alunos::with('modulos')->get();
        $instituicoes  = Instituicao::all();

        return view('alunos.alunos', compact('alunos','instituicoes'));
    }

    public function store(Request $request)

    {
        dd($request)->all();
        
        $validated = $request->validate([
            'nome'              => ['required','string','max:255'],
            'email'             => ['nullable','email','max:255','unique:alunos,email'],
            'telefone'          => ['nullable','string','max:50'],

            'instituicao_ids'   => ['required','array','min:1'],
            'instituicao_ids.*' => ['integer','exists:instituicoes,id'],

            'curso_ids'         => ['required','array','min:1'],
            'curso_ids.*'       => ['integer','exists:cursos,id'],

            'modulo_ids'        => ['required','array','min:1'],
            'modulo_ids.*'      => ['integer','exists:modulos,id'],

            'observacoes'       => ['nullable','string','max:2000'],
        ]);

        return DB::transaction(function () use ($validated) {

            // 1) Cursos pertencem às instituições selecionadas?
            $cursos  = Curso::whereIn('id', $validated['curso_ids'])->get(['id','instituicoes_ids']);
            $instSet = collect($validated['instituicao_ids'])->map(fn ($i) => (int)$i)->unique()->values();

            foreach ($cursos as $c) {
                if (!$instSet->contains((int)$c->instituicoes_id)) {
                    throw ValidationException::withMessages([
                        'curso_ids' => "O curso {$c->id} não pertence a nenhuma das instituições selecionadas.",
                    ]);
                }
            }

            // 2) Módulos pertencem aos cursos selecionados?
            $modulos  = Modulo::whereIn('id', $validated['modulo_id'])->get(['id','cursos_id']);
            $cursoSet = collect($validated['curso_ids'])->map(fn ($i) => (int)$i)->unique()->values();

            foreach ($modulos as $m) {
                if (!$cursoSet->contains((int)$m->cursos_id)) {
                    throw ValidationException::withMessages([
                        'modulo_ids' => "O módulo {$m->id} não pertence a nenhum dos cursos selecionados.",
                    ]);
                }
            }

            // 3) Criar aluno
            $aluno = Alunos::create([
                'nome'        => $validated['nome'],
                'email'       => $validated['email'] ?? null,
                'telefone'    => $validated['telefone'] ?? null,
                'observacoes' => $validated['observacoes'] ?? null,
            ]);

            // 4) Ligar TODOS os módulos à pivot (tabela alunos_modulos)
            $aluno->modulos()->syncWithoutDetaching($modulos->pluck('id')->all());

            return redirect()
                ->route('alunos_view')  // ou ->back()
                ->with('success', 'Aluno criado e ligado aos módulos selecionados.');
        });
    }

}
