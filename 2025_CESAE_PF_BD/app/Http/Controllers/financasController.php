<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Instituicao;
use Illuminate\Http\Request;

class financasController extends Controller
{
     public function index(){
        $cursos = Curso::all();
        $instituicoes = Instituicao::all();
        return view('financas.financas_home', compact('cursos', 'instituicoes'));
    }

    public function novaFatura(Request $request)
{
    // Validação dos campos

    // dd($request->all());
    $validated = $request->validate([
        'numeroFatura'   => 'required|string|max:255',
        'valor'          => 'required|numeric|min:0',
        'IRSTaxa'        => 'required|numeric|min:0',
        'IVAPercentagem' => 'required|numeric|min:0',
        'dataEmissao'    => 'required|date',
        'dataPagamento'  => 'nullable|date|after_or_equal:dataEmissao',
        'observacoes'    => 'nullable|string',
        'instituicao'    => 'required|exists:instituicoes,id', // ID da instituição já salva
        'curso'          => 'required|exists:cursos,id', // ID do Curso já salva
        'modulo'         => 'nullable|exists:modulos,id', // ID do Modulo já salva
        'observacoes'    => 'nullable|string',
    ]);

    // Criar nova fatura
    $financas = new Financa();
    $financas->numeroFatura      = $validated['numeroFatura'];
    $financas->valor             = $validated['valor'];
    $financas->IRSTaxa           = $validated['IRSTaxa'];
    $financas->IVAPercentagem    = $validated['IVAPercentagem'];
    $financas->dataEmissao       = $validated['dataEmissao'];
    $financas->dataPagamento     = $validated['dataPagamento'] ?? null;
    $financas->observacoes       = $validated['observacoes'] ?? null;
    $financas->users_id          = 1; // usuário logado
    $financas->instituicoes_id   = $validated['instituicao'];
    $financas->cursos_id         = $validated['curso'];
    $financas->modulos_id        = $validated['modulo'];
    $financas->save();

    return redirect()->route('financas')
                     ->with('success', 'Fatura adicionada com sucesso!');
}
}
