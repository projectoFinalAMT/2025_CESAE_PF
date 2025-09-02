<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Modulo;
use Illuminate\Http\Request;

class moduloController extends Controller
{
    /**
     * Exibe a lista de módulos com cursos associados.
     */
    public function index()
{
    // Carrega todos os cursos com a instituição
    $cursos = Curso::with('instituicao')->get();

    // Carrega todos os módulos com os cursos e a instituição de cada curso
    $modulos = Modulo::with('cursos.instituicao', 'cursoModulos')->get();

    // Cria um array de IDs de curso_modulo por módulo e curso
    $cursoModuloIds = [];
    foreach ($modulos as $modulo) {
        foreach ($modulo->cursos as $curso) {
            $cursoModulo = $modulo->cursoModulos->where('curso_id', $curso->id)->first();
            $cursoModuloIds[$modulo->id][$curso->id] = $cursoModulo ? $cursoModulo->id : null;
        }
    }

    // Adiciona propriedades personalizadas se necessário
    foreach ($modulos as $modulo) {
        if (method_exists($modulo, 'todosCursosComAssociacao')) {
            $modulo->todosCursos = $modulo->todosCursosComAssociacao();
        }
        if (method_exists($modulo, 'todosCursosPorInstituicao')) {
            $modulo->todosCursosPorInstituicao = $modulo->todosCursosPorInstituicao();
        }
    }

    return view('modulos.modulos_home', compact('cursos', 'modulos', 'cursoModuloIds'));
}


    /**
     * Armazena um novo módulo e associa aos cursos selecionados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'duracao_horas' => 'required|numeric|min:0',
            'cursos' => 'required|array',
            'cursos.*' => 'exists:cursos,id',
        ]);

        // Cria o módulo
        $modulo = Modulo::create([
            'nomeModulo' => $validated['nome'],
            'descricao' => $validated['descricao'] ?? null,
            'duracaoHoras' => $validated['duracao_horas'],
        ]);

        // Associa aos cursos selecionados (pivot)
        $modulo->cursos()->sync($validated['cursos']);

        return back()->with('success', 'Módulo criado com sucesso!');
    }

    /**
     * Atualiza um módulo existente e sincroniza os cursos.
     */
    public function update(Request $request, $id)
    {
        $modulo = Modulo::findOrFail($id);

        $validated = $request->validate([
            'nomeModulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'duracaoHoras' => 'required|numeric|min:0',
            'cursos' => 'required|array',
            'cursos.*' => 'exists:cursos,id',
        ]);

        // Atualiza dados do módulo
        $modulo->update([
            'nomeModulo' => $validated['nomeModulo'],
            'descricao' => $validated['descricao'] ?? null,
            'duracaoHoras' => $validated['duracaoHoras'],
        ]);

        // Sincroniza os cursos associados
        $modulo->cursos()->sync($validated['cursos']);

        return redirect()->back()->with('success', 'Módulo atualizado com sucesso!');
    }

    /**
     * Deleta um ou mais módulos, considerando IDs separados por vírgula.
     */
    public function deletar(Request $request)
{
    $ids = explode(',', $request->ids);
    $cursoId = $request->curso_id; // do hidden input

    if($cursoId){
        // Remove só a associação módulo-curso
        \DB::table('curso_modulo')
            ->where('modulo_id', $ids[0])
            ->where('curso_id', $cursoId)
            ->delete();

        return redirect()->route('modulos')->with('success', 'Associação módulo-curso removida com sucesso!');
    }

    // Caso queira deletar o módulo globalmente
    Modulo::whereIn('id', $ids)->delete();
    return redirect()->route('modulos')->with('success', 'Módulo eliminado com sucesso!');
}

//função para o calendario para filtrar modulos por curso
public function byCurso($cursoId)
{
    // N↔N: filtra módulos que estejam ligados ao curso via pivot
    $mods = \App\Models\Modulo::whereHas('cursos', function ($q) use ($cursoId) {
        $q->where('cursos.id', $cursoId);
    })
    ->orderBy('nomeModulo')
    ->get(['id', 'nomeModulo']); // cursos_id já não interessa

// devolve JSON no formato esperado pelo teu JS
return response()->json($mods);
}


}
