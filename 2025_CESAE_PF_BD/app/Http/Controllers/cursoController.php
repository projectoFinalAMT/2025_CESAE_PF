<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class cursoController extends Controller
{
public function index()
{


    $instituicoes = Instituicao::where('users_id',Auth::id())->get();


    $modulos = Modulo::query()
    ->whereHas('cursos', function ($q) {
        $q->where('users_id', Auth::id());   // só cursos do user autenticado
    })
    ->with([
        // também limita o eager load aos cursos do user e carrega a instituição
        'cursos' => fn ($q) => $q->where('users_id', Auth::id())
                                 ->with('instituicao'),
    ])
    ->orderBy('nomeModulo')
    ->get(['modulos.id', 'modulos.nomeModulo']); // qualifica para evitar ambiguidade


    $cursos = Curso::where('users_id',Auth::id())->withCount('modulos')->get();

    // Obter os IDs dos módulos associados a cada curso
  $cursoModulos = DB::table('curso_modulo')
  ->join('cursos','cursos.id','curso_id')
  ->where('users_id', Auth::id())
    ->select('curso_id', 'modulo_id')
    ->get()
    ->groupBy('curso_id')
    ->map(function($modulos) {
        return $modulos->pluck('modulo_id')->toArray();
    });


    return view('cursos.cursos_home', compact('cursos', 'instituicoes', 'modulos', 'cursoModulos'));
}

    public function store(Request $request)
    {
        // Validação dos campos
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'instituicao' => 'required|exists:instituicoes,id', // ID da instituição já salva
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'total_horas' => 'required|numeric|min:0',
            'preco_hora' => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'modulos' => 'nullable|array',
            'modulos.*' => 'exists:modulos,id',

        ]);

        // Criar curso
        $curso = new Curso();
        $curso->titulo = $validated['nome'];
        $curso->descricao = $validated['descricao'] ?? null;
        $curso->duracaoTotal = $validated['total_horas'];
        $curso->precoHora = $validated['preco_hora'];
        $curso->dataInicio = $validated['data_inicio'];
        $curso->dataFim = $validated['data_fim'] ?? null;
        $curso->instituicoes_id = $validated['instituicao']; // liga à instituição já existente
        $curso->users_id =  Auth::id(); // usuário logado
        $curso->estado_cursos_id = 1; // por exemplo, estado "ativo" padrão

        $curso->save();

        // Associa módulos selecionados
        $curso->modulos()->sync($validated['modulos'] ?? []);



        return redirect()->route('cursos')
            ->with('success', 'Curso criado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'instituicao' => 'required|exists:instituicoes,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'total_horas' => 'required|numeric|min:0',
            'preco_hora' => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'modulos' => 'nullable|array',
            'modulos.*' => 'exists:modulos,id',

        ]);

        $curso->update([
            'titulo' => $validated['nome'],
            'instituicoes_id' => $validated['instituicao'],
            'dataInicio' => $validated['data_inicio'],
            'dataFim' => $validated['data_fim'],
            'duracaoTotal' => $validated['total_horas'],
            'precoHora' => $validated['preco_hora'],
            'descricao' => $validated['descricao'] ?? null,
            'cor' => $validated['cor'] ?? $curso->cor, // mantém cor antiga se não mudar
        ]);


        // Atualiza módulos
        $curso->modulos()->sync($validated['modulos'] ?? []);


        return redirect()->route('cursos')->with('success', 'Curso atualizado com sucesso!');
    }


    public function deletar(Request $request)
    {
        $ids = explode(',', $request->ids);
        Curso::whereIn('id', $ids)->delete();
        return redirect()->route('cursos')->with('success', 'Curso eliminado com sucesso!');
    }

    public function buscar(Request $request)
    {
        $query = $request->input('q');

        $cursos = Curso::where('users_id', Auth::id())->where('titulo', 'like', "%{$query}%")->get();

        return response()->json($cursos);
    }

   public function modulosComAssociacao()
{
    return $this->modulos->map(function ($modulo) {
        $modulo->associado = true;
        return $modulo;
    });
}


//pagina alunos
public function byInstituicao($instituicaoId) {
    $cursos = Curso::where('users_id', Auth::id())->where('instituicoes_id', $instituicaoId)
        ->select('id','titulo')
        ->orderBy('titulo')
        ->get();

    return response()->json($cursos);
}

//alterar status curso
public function toggleEstado(Request $request, Curso $curso)
{
    $request->validate([
        'estado' => 'required|in:1,2',
    ]);

    $curso->estado_cursos_id = $request->estado;
    $curso->save();

    return response()->json(['success' => true]);
}



}
