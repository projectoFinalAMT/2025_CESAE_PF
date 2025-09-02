<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Modulo;
use Illuminate\Http\Request;

class moduloController extends Controller
{
    public function index(){

        $cursos = Curso::all();

        // Carrega módulos com o curso e a instituição relacionada
        $modulos = Modulo::with('cursos.instituicao')->get();

        return view('modulos.modulos_home', compact('cursos', 'modulos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'           => 'required|string|max:255',
            'descricao'      => 'nullable|string',
            'duracao_horas'  => 'required|numeric|min:0',
            'cursos'         => 'required|array',
            'cursos.*'       => 'exists:cursos,id',
        ]);

        $modulo = \App\Models\Modulo::create([
            'nomeModulo'   => $validated['nome'],
            'descricao'    => $validated['descricao'] ?? null,
            'duracaoHoras' => $validated['duracao_horas'],
        ]);

        $modulo->cursos()->sync($validated['cursos']);

        return back()->with('success', 'Módulo criado com sucesso!');
    }

     public function deletar(Request $request)
{
    $ids = explode(',', $request->ids);
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
