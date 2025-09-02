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
        'numeroFatura'   => 'required|string|max:255',
        'valor_total'    => 'required|numeric|min:0',
        'IRSTaxa'        => 'required|numeric|min:0',
        'IVAPercetagem'  => 'required|numeric|min:0',
        'dataEmissao'    => 'required|date',
        'dataPagamento'  => 'nullable|date|after_or_equal:dataEmissao',
        'observacoes'    => 'nullable|string',
        'instituicao'    => 'required|exists:instituicoes,id', // ID da instituição já salva
        'curso'          => 'nullable|numeric|min:0',
        'modulo'         => 'nullable|numeric|min:0',
        'observacoes'    => 'nullable|string',
    ]);

    // Criar nova fatura
    $financas = new Financa();
    $financas->numeroFatura      = $validated['numeroFatura'];
    $financas->valor             = $validated['valor_total'];
    $financas->IRSTaxa           = $validated['irs'];
    $financas->IVAPercetagem     = $validated['iva'];
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
