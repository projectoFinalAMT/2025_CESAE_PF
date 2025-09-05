<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Financa;
use App\Models\Instituicao;
use App\Models\Recebimento;
use App\Models\EstadoFatura;
use Illuminate\Http\Request;

class financasController extends Controller
{
     public function index(){
        $cursos = Curso::all();
        $modulos = Modulo::all();
        $instituicoes = Instituicao::all();
        $estados = EstadoFatura::all();

        $financas = Financa::with(['recebimento', 'instituicao'])->get();

        return view('financas.financas_home', compact('cursos', 'instituicoes', 'modulos', 'estados', 'financas'));
    }

    /**
     * Função que cria nova Fatura
     * Se nova fatura for criada com estado "Pago", cria novo recebimento.
     */
    public function novaFatura(Request $request)
{
    dd($request->all());

    // Validação dos campos
    $validated = $request->validate([
        'descricao'      => 'required|string|max:255',
        'qtd'            => 'required|numeric|min:0', // quantidade_horas
        'valor'          => 'required|numeric|min:0', // valor_unitario
        'valor_subtotal' => 'required|numeric|min:0', // valor_semImposto
        'iva'            => 'required|numeric|min:0', // % IVA
        'irs'            => 'required|numeric|', // % IRS
        'valor_irs'      => 'required|numeric|min:0', // Valor IRS calculado
        'valor_iva'      => 'required|numeric|min:0', // valor IVA calculado
        'valor_total'    => 'required|numeric|min:0', // valor total ou seja, valor
        'dataEmissao'    => 'required|date', // data de emissão
        'dataPagamento'  => 'nullable|date|after_or_equal:dataEmissao', // data de pagamento
        'observacoes'    => 'nullable|string|max:255', // observaçoes
        'instituicao'    => 'required|exists:instituicoes,id', // ID da instituição já salva
        'curso'          => 'nullable|numeric|min:0', // curso
        'modulo'         => 'nullable|numeric|min:0', // modulo
        'estadoFatura'   => 'required|exists:estado_faturas,id',
    ]);

    // Criar nova fatura
    $financas = new Financa();
    $financas->descricao         = $validated['descricao'];
    $financas->quantidade_horas  = $validated['qtd'];
    $financas->valor_hora        = $validated['valor'];
    $financas->valor_semImposto  = $validated['valor_subtotal'];
    $financas->IVAPercetagem     = $validated['iva'];
    $financas->baseCalculoIRS    = $validated['irs'];
    $financas->IRSTaxa           = $validated['valor_irs'];
    $financas->valor             = $validated['valor_total'];
    $financas->dataEmissao       = $validated['dataEmissao'];
    $financas->dataPagamento     = $validated['dataPagamento'] ?? null;
    $financas->observacoes       = $validated['observacoes'] ?? null;
    $financas->users_id          = 1; // usuário logado
    $financas->instituicoes_id   = $validated['instituicao'];
    $financas->id_curso          = $validated['curso'] ?? null;
    $financas->id_modulo         = $validated['modulo'] ?? null;
    $financas->estado_faturas_id = $validated['estadoFatura'];
    $financas->save();

    // Se a fatura está paga, cria novo recebimento
    if($financas->estado_faturas_id == 2){

        // significa que o estado da fatura está dado como Pago e por isso, pode ser incluída na tabela recebimentos
        Recebimento::create([
                'financas_id'    => $financas->id,
                'valor'          => $financas->valor,
                'dataRecebimento'=> $validated['dataPagamento'] ?? now()->toDateString(),
                'instituicoes_id'=> $financas->instituicoes_id,
            ]);
    }

    return redirect()->route('financas')
                     ->with('success', 'Fatura adicionada com sucesso!');
}


/**
 * Função que controla a atualização do estado da fatura para "Pago" e se sim, cria novo recebimento.
 * Se estado for revertido de "Pago" para outro, apaga o recebimento.
 * */
public function update(Request $request, Financa $financa)
{
    // Validação
    $validated = $request->validate([
        'descricao'      => 'sometimes|string|max:255',
        'qtd'            => 'sometimes|numeric|min:0',
        'valor'          => 'sometimes|numeric|min:0',
        'valor_subtotal' => 'sometimes|numeric|min:0',
        'iva'            => 'sometimes|numeric|min:0',
        'irs'            => 'sometimes|numeric|min:0',
        'valor_irs'      => 'sometimes|numeric|min:0',
        'valor_iva'      => 'sometimes|numeric|min:0',
        'valor_total'    => 'sometimes|numeric|min:0',
        'dataEmissao'    => 'sometimes|date',
        'dataPagamento'  => 'nullable|date|after_or_equal:dataEmissao',
        'observacoes'    => 'nullable|string|max:255',
        'instituicao'    => 'sometimes|exists:instituicoes,id',
        'curso'          => 'nullable|numeric|min:0',
        'modulo'         => 'nullable|numeric|min:0',
        'estadoFatura'   => 'sometimes|exists:estado_faturas,id',
    ]);

    // Guardo estado anterior
    $estadoAnterior = $financa->estado_faturas_id;

    // Atualizo campos (apenas os que vierem no request)
    $financa->descricao         = $validated['descricao']      ?? $financa->descricao;
    $financa->quantidade_horas  = $validated['qtd']            ?? $financa->quantidade_horas;
    $financa->valor_hora        = $validated['valor']          ?? $financa->valor_hora;
    $financa->valor_semImposto  = $validated['valor_subtotal'] ?? $financa->valor_semImposto;
    $financa->IVAPercetagem     = $validated['iva']            ?? $financa->IVAPercetagem;
    $financa->baseCalculoIRS    = $validated['irs']            ?? $financa->baseCalculoIRS;
    $financa->IRSTaxa           = $validated['valor_irs']      ?? $financa->IRSTaxa;
    $financa->valor             = $validated['valor_total']    ?? $financa->valor;
    $financa->dataEmissao       = $validated['dataEmissao']    ?? $financa->dataEmissao;
    $financa->dataPagamento     = $validated['dataPagamento']  ?? $financa->dataPagamento;
    $financa->observacoes       = $validated['observacoes']    ?? $financa->observacoes;
    $financa->instituicoes_id   = $validated['instituicao']    ?? $financa->instituicoes_id;
    $financa->id_curso          = $validated['curso']          ?? $financa->id_curso;
    $financa->id_modulo         = $validated['modulo']         ?? $financa->id_modulo;
    $financa->estado_faturas_id = $validated['estadoFatura']   ?? $financa->estado_faturas_id;
    $financa->save();

    // Se mudou para "pago"
    if ($estadoAnterior != 2 && $financa->estado_faturas_id == 2) {
        Recebimento::create([
            'financas_id'    => $financa->id,
            'valor'          => $financa->valor,
            'dataRecebimento'=> $financa->dataPagamento ?? now()->toDateString(),
            'instituicoes_id'=> $financa->instituicoes_id,
        ]);
    }

    // Se mudou de "pago" para outro estado → apago recebimento
    if ($estadoAnterior == 2 && $financa->estado_faturas_id != 2) {
        $recebimento = Recebimento::where('financas_id', $financa->id)->first();
        if ($recebimento) {
            $recebimento->delete();
        }
    }

    return redirect()->route('financas')
                     ->with('success', 'Fatura atualizada com sucesso!');
}

}
