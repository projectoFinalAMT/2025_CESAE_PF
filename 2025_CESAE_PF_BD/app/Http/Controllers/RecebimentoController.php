<?php

namespace App\Http\Controllers;

use App\Models\Instituicao;
use App\Models\Recebimento;
use Illuminate\Http\Request;


class RecebimentoController extends Controller
{

    /**
     * Função que retorna todas as instituições para preencher o filtro no modal
     */
    public function listarInstituicoes(){

        $instituicoes = Instituicao::select('id', 'nomeInstituicao')
            ->orderBy('nomeInstituicao') // para aparecerem por ordem alfabética
            ->get();

        return response()->json([
            'instituicoes' => $instituicoes
        ]);
    }

    /**
     * Função que retorna totais agregados de recebimentos por instituição, aplicando filtros de data e instituições, e calcula o total geral
     */
    public function ganhosPorInstituicao(Request $request){

        $filtros = $request->only(['dataInicio', 'dataFim', 'instituicoes']); // apenas os filtros relevantes

        $query = Recebimento::with('instituicao');

        if (!empty($filtros['dataInicio']) && !empty($filtros['dataFim'])) {
        $query->whereBetween('dataRecebimento', [$filtros['dataInicio'], $filtros['dataFim']]);
        }

        if (!empty($filtros['instituicoes']) && is_array($filtros['instituicoes'])) {
        $query->whereIn('instituicoes_id', $filtros['instituicoes']);
        }

        $recebimentos = $query->get();

        $dados = []; // Array associativo: ['NomeInstituicao' => total]

        foreach ($recebimentos as $recebimento) {
        $nomeInstituicao = $recebimento->instituicao->nomeInstituicao;

        // Se ainda não existir, inicializa
        if (!isset($dados[$nomeInstituicao])) {
            $dados[$nomeInstituicao] = 0;
        }

        // Soma o valor do recebimento ao total da instituição
        $dados[$nomeInstituicao] += $recebimento->valor;
        }

        // Transformo o array associativo em array sequencial para JSON
        $resultado = [];

        foreach ($dados as $nome => $total) {
        $resultado[] = [
            'instituicao' => $nome,
            'total' => $total
        ];
        }

        // Calcular total geral
        $totalGeral = array_sum(array_column($resultado, 'total'));

        // Retornar JSON
        return response()->json([
            'data' => $resultado,
            'totalGeral' => $totalGeral
        ]);
    }

}
