<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Instituicao;
use Illuminate\Http\Request;

class cursoController extends Controller
{
     public function index(){
        $cursos = Curso::all();
         $instituicoes = Instituicao::all();
        return view('cursos.cursos_home', compact('cursos', 'instituicoes'));
    }

    public function store(Request $request)
{
    // Validação dos campos
    $validated = $request->validate([
        'nome'           => 'required|string|max:255',
        'instituicao'    => 'required|exists:instituicoes,id', // ID da instituição já salva
        'data_inicio'    => 'required|date',
        'data_fim'       => 'nullable|date|after_or_equal:data_inicio',
        'total_horas'    => 'required|numeric|min:0',
        'preco_hora'     => 'required|numeric|min:0',
        'descricao'      => 'nullable|string',
    ]);

    // Criar curso
    $curso = new Curso();
    $curso->titulo            = $validated['nome'];
    $curso->descricao         = $validated['descricao'] ?? null;
    $curso->duracaoTotal      = $validated['total_horas'];
    $curso->precoHora         = $validated['preco_hora'];
    $curso->dataInicio        = $validated['data_inicio'];
    $curso->dataFim           = $validated['data_fim'] ?? null;
    $curso->instituicoes_id   = $validated['instituicao']; // liga à instituição já existente
    $curso->users_id          = 1; // usuário logado
    $curso->estado_cursos_id  = 1; // por exemplo, estado "ativo" padrão
    $curso->save();

    return redirect()->route('cursos')
                     ->with('success', 'Curso criado com sucesso!');
}

 public function deletar(Request $request)
{
    $ids = explode(',', $request->ids);
    Curso::whereIn('id', $ids)->delete();
    return redirect()->route('cursos')->with('success', 'Instituições eliminadas com sucesso!');
}




}
