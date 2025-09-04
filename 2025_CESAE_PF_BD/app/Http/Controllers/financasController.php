<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Instituicao;
use App\Models\Modulo;
use Illuminate\Http\Request;

class financasController extends Controller
{
     public function index(){
        $cursos = Curso::all();
        $modulos = Modulo::all();
        $instituicoes = Instituicao::all();
        return view('financas.financas_home', compact('cursos', 'instituicoes', 'modulos'));
    }

    public function novaFatura(Request $request)
{
    // Validação dos campos

    dd($request->all());
    $validated = $request->validate([
        'numeroFatura'   => 'required|string|max:255', // tenho que fazer drop disto
        'descricao'      => 'required|string|max:255',
        'quantidade_horas' => 'required|numeric|min:0',
        'valor_unitario' => 'required|numeric|min:0',
        'valor_semImposto' => 'required|numeric|min:0', // subtotal
        'IVAPercetagem'  => 'required|numeric|min:0', // % IVA
        'baseCalculoIRS' => 'required|numeric|', // % IRS
        'IRSTaxa'        => 'required|numeric|min:0', // Valor IRS calculado
        'valor_total'    => 'required|numeric|min:0',
        'dataEmissao'    => 'required|date',
        'dataPagamento'  => 'nullable|date|after_or_equal:dataEmissao',
        'observacoes'    => 'nullable|string|max:255',
        'instituicao'    => 'required|exists:instituicoes,id', // ID da instituição já salva
        'curso'          => 'nullable|numeric|min:0',
        'modulo'         => 'nullable|numeric|min:0',
    ]);

    // Criar nova fatura
    $financas = new Financa();
    $financas->numeroFatura      = $validated['numeroFatura']; // tenho que fazer drop disto
    $financas->descricao         = $validated['descricao'];
    $financas->quantidade_horas  = $validated['quantidade_horas'];
    $financas->valor_unitario    = $validated['valor_unitario'];
    $financas->valor_semImposto  = $validated['valor_semImposto'];
    $financas->IVAPercetagem     = $validated['IVAPercetagem'];
    $financas->baseCalculoIRS    = $validated['baseCalculoIRS'];
    $financas->IRSTaxa           = $validated['IRSTaxa'];
    $financas->valor             = $validated['valor_total'];
    $financas->dataEmissao       = $validated['dataEmissao'];
    $financas->dataPagamento     = $validated['dataPagamento'] ?? null;
    $financas->observacoes       = $validated['observacoes'] ?? null;
    $financas->users_id          = 1; // usuário logado
    $financas->instituicoes_id   = $validated['instituicao'];
    $financas->id_curso          = $validated['curso'];
    $financas->id_modulo         = $validated['modulo'];
    $financas->save();

    return redirect()->route('financas')
                     ->with('success', 'Fatura adicionada com sucesso!');
}
}
