<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Curso;
use App\Models\Event;
use App\Models\Modulo;
use App\Models\Financa;
use App\Models\EstadoCurso;
use App\Models\Instituicao;
use App\Models\Recebimento;
use App\Models\EstadoFatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class financasController extends Controller
{

public function index(Request $request)
{
    // ======================
    // 1. DADOS BÁSICOS PARA FORMULÁRIOS
    // ======================

    $cursos = Curso::where('users_id', Auth::id())->get();
    $modulos = Modulo::join('curso_modulo', 'modulos.id', 'modulo_id')
    ->join('cursos', 'cursos.id', 'curso_id')
    ->where('cursos.users_id', Auth::id())->get();
    $instituicoes = Instituicao::where('users_id', Auth::id())->get();
    $estados = EstadoFatura::all();
    $recebimentos = Financa::join('recebimentos', 'financas.id', 'financas_id')
    ->where('financas.users_id', Auth::id())->get();
    $filtro = $request->input('filtro', 'este_mes'); // recebe o filtro via GET e estabelece como pré-definido este mês

    // ======================
    // 2. DEFINIR PERÍODO DO FILTRO
    // ======================

    $inicio = null;
    $fim = null;

    // Define datas para o filtro
    switch ($filtro) {
        case 'este_mes':
            $inicio = Carbon::now()->startOfMonth();
            // Carbon::now() - cria um objeto Carbon com a data e hora atual.
            // ->startOfMonth() - modifica o objeto Carbon atual para o primeiro dia do mês
            $fim = Carbon::now()->endOfMonth();
            break;

        case 'ultimo_mes':
            $inicio = Carbon::now()->subMonth()->startOfMonth();
            $fim = Carbon::now()->subMonth()->endOfMonth();
            break;

        case 'trimestre':
            $inicio = Carbon::now()->firstOfQuarter();
            $fim = Carbon::now()->lastOfQuarter();
            break;

        default:
            $inicio = null;
            $fim = null;
            break;
    }

    // ======================
    // 3. CONSULTAR DADOS COM FILTROS
    // ======================

    // Query base para filtrar valores Faturação, Ganhos (valor líquido), Faturação por Instituição & Faturas
    $query = Financa::where('users_id', Auth::id())
                    ->with(['recebimento', 'instituicao', 'curso']);

    // Query para aplicar o mesmo filtro de datas ao valor expectável
    // Ligo a tabela Cursos à tabela de Eventos através do id do curso.
    $queryAulas = Curso::join('events', 'cursos.id', 'events.cursos_id')
    ->where('events.users_id', Auth::id());

    // Aplica o filtro de datas se definido
    if ($inicio && $fim) {
        $query->whereBetween('dataEmissao', [$inicio, $fim]);
        $queryAulas->whereBetween('events.start', [$inicio, $fim]);
    }

    $financas = $query->get();
    $aulasCurso = $queryAulas->get([
        'cursos.id as curso_id',
        'cursos.titulo',
        'cursos.precoHora',
        'events.start',
        'events.end',
    ]);

    //dd($aulasCurso);

    // ======================
    // 4. CÁLCULOS DE FATURAÇÃO
    // ======================

    // Faturação válida (emitidas e pagas)
    $totalFaturacao = $financas->whereIn('estado_faturas_id', [1, 2])
                               ->sum('valor');
    $totalIva = $financas->whereIn('estado_faturas_id', [1, 2])
                         ->sum('IVATaxa');
    $totalIrs = $financas->whereIn('estado_faturas_id', [1, 2])
                         ->sum('IRSTaxa');

    // Faturação paga
    $totalFaturacaoPaga = $financas->sum(function ($financa) {
        return $financa->recebimento->valor ?? 0;
    });
    $totalIvaPago = $financas->where('estado_faturas_id', 2)
                             ->sum('IVATaxa');
    $totalIrsPago = $financas->where('estado_faturas_id', 2)
                             ->sum('IRSTaxa');

    // Ganhos (valor líquido das faturas pagas)
    $totalGanhos = $financas->where('estado_faturas_id', 2)
                            ->sum('valor_liquido');

    // ======================
    // 5. CÁLCULO DO VALOR EXPECTÁVEL (COM FILTRO APLICADO)
    // ======================

    $cursosComValor = [];
    $valorTotalExpectavel = 0;


    foreach ($aulasCurso as $aula) {
        $start = new DateTime($aula->start);
        $end = new DateTime($aula->end);

        // calcula a diferença entre duas datas/horas.
        // h->horas; i->minutos; s->segundos; d->dias; etc
        $diferenca = $start->diff($end);

        // Converto os minutos (i) para horas
        $horas = $diferenca->h + ($diferenca->i / 60);

        // Calcula valor desta aula
        $valorAula = $horas * $aula->precoHora;

        // Agrupa por curso
        if (!isset($cursosComValor[$aula->curso_id])) {
        // Se o curso ainda não foi adicionado, entra no if e cria uma nova entrada no $cursosComValor[].
        // Caso contrário, passa à frente e incrementa apenas o número de horas e valor por aula

            $cursosComValor[$aula->curso_id] = [
                'titulo' => $aula->titulo, // Nome do curso
                'total_horas' => 0,
                'total_valor' => 0
            ];
        }

        $cursosComValor[$aula->curso_id]['total_horas'] += $horas;
        $cursosComValor[$aula->curso_id]['total_valor'] += $valorAula;
        $valorTotalExpectavel += $valorAula; // Soma total expectável
    }

    //dd($cursosComValor);

    // ======================
    // 6. AGRUPAMENTO POR INSTITUIÇÃO
    // ======================

    $agrupado = [];   // Vai armazenar os dados agrupados
    $somaTotal = 0;   // Guarda o total de todas as faturas (para calcular percentagem)

    foreach ($financas as $financa) {

        // Apenas faturas válidas (emitidas ou pagas)
        if (!in_array($financa->estado_faturas_id, [1, 2])) {
            continue;
        }

        $nome = $financa->instituicao->nomeInstituicao ?? 'Sem Instituição';
        $cor = $financa->instituicao->cor ?? '#ccc';
        $valor = $financa->valor;

        // Se ainda não existe essa instituição no array, inicializa
        if (!isset($agrupado[$nome])) {
            $agrupado[$nome] = [
                'nome' => $nome,
                'valor' => 0,
                'cor' => $cor,
            ];
        }

        // Soma o valor da fatura à instituição correspondente
        $agrupado[$nome]['valor'] += $valor;
        // Adiciona ao total geral
        $somaTotal += $valor;
    }

    // Calcula percentagem de cada instituição
    foreach ($agrupado as &$item) { // & significa passagem por referência - aponta diretamente para o elemento original do array

        // Se soma total > 0, calcula a percentagem; caso contrário 0
        $item['percent'] = $somaTotal > 0 ? number_format(($item['valor'] / $somaTotal) * 100, 2) : 0;
    }

    // Reindexa o array para evitar chaves associativas (opcional para a Blade)
    $faturacaoInstituicoes = array_values($agrupado);


    return view('financas.financas_home', compact(
        'cursos',
        'instituicoes',
        'modulos',
        'estados',
        'financas',
        'recebimentos',
        'filtro',
        'totalFaturacao',
        'totalGanhos',
        'totalIva',
        'totalIrs',
        'totalFaturacaoPaga',
        'totalIvaPago',
        'totalIrsPago',
        'faturacaoInstituicoes',
        'cursosComValor',
        'valorTotalExpectavel'
    ));
}


    /**
     * Função que cria nova Fatura
     * Se nova fatura for criada com estado "Pago", cria novo recebimento.
     */
    public function novaFatura(Request $request)
{
   // dd($request->all());

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
        'valor_liquido'  => 'required|numeric|min:0', // valor liquido real
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
    $financas->IVATaxa           = $validated['valor_iva'];
    $financas->baseCalculoIRS    = $validated['irs'];
    $financas->IRSTaxa           = $validated['valor_irs'];
    $financas->valor             = $validated['valor_total'];
    $financas->dataEmissao       = $validated['dataEmissao'];
    $financas->dataPagamento     = $validated['dataPagamento'] ?? null;
    $financas->valor_liquido     = $validated['valor_liquido'];
    $financas->observacoes       = $validated['observacoes'] ?? null;
    $financas->users_id          = Auth::id();
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
                'dataRecebimento'=> $validated['dataPagamento'] ?? now()->toDateString(), // se tiver data de pagamento, fica essa, caso contrário fica a data no momento da mudança de estado
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
        'descricao'      => 'sometimes|string|max:255', /*Sometimes - Se existir no request, aplica estas regras, se não existir, ignora*/
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
        'valor_liquido'  => 'sometimes|numeric|min:0',
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
    $financa->IVATaxa           = $validated['valor_iva']      ?? $financa->IVATaxa;
    $financa->baseCalculoIRS    = $validated['irs']            ?? $financa->baseCalculoIRS;
    $financa->IRSTaxa           = $validated['valor_irs']      ?? $financa->IRSTaxa;
    $financa->valor             = $validated['valor_total']    ?? $financa->valor;
    $financa->dataEmissao       = $validated['dataEmissao']    ?? $financa->dataEmissao;
    $financa->dataPagamento     = $validated['dataPagamento']  ?? $financa->dataPagamento;
    $financa->valor_liquido     = $validated['valor_liquido']  ?? $financa->valor_liquido;
    $financa->observacoes       = $validated['observacoes']    ?? $financa->observacoes;
    $financa->instituicoes_id   = $validated['instituicao']    ?? $financa->instituicoes_id;
    $financa->id_curso          = $validated['curso']          ?? $financa->id_curso;
    $financa->id_modulo         = $validated['modulo']         ?? $financa->id_modulo;
    $financa->estado_faturas_id = $validated['estadoFatura']   ?? $financa->estado_faturas_id;
    $financa->save();

    // Se mudou para "pago", cria um novo recebimento e atualiza a data de recebimento para a data atual
    if ($estadoAnterior != 2 && $financa->estado_faturas_id == 2) {
        Recebimento::create([
            'financas_id'    => $financa->id,
            'valor'          => $financa->valor,
            'dataRecebimento'=> $financa->dataPagamento ?? now()->toDateString(),
            'instituicoes_id'=> $financa->instituicoes_id,
        ]);
    }

    // Se mudou de "pago" para outro estado, apago recebimento
    if ($estadoAnterior == 2 && $financa->estado_faturas_id != 2) {
        $recebimento = Recebimento::where('financas_id', $financa->id)->first();
        if ($recebimento) {
            $recebimento->delete();
        }
    }

    return redirect()->route('financas')
                     ->with('success', 'Fatura atualizada com sucesso!');
}


public function apagar(Request $request, Financa $financa){
// Apaga o recebimento relacionado
    if ($financa->recebimento) {
        $financa->recebimento->delete();
    }

    // Apaga a fatura
    $financa->delete();

    return redirect()->route('financas')
                     ->with('success', 'Fatura eliminada com sucesso!');
}
}




