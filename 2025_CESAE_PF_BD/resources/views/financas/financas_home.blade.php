@extends('layouts.fe_master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/financas_home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
@endsection

@section('content')

    <div class="content">
        <div class="container my-4">

            <!-- Toast de sucesso -->
            @if (session('success'))
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
                    <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Fechar"></button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Título Gestão Financeira -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Gestão Financeira</h2>
            </div>

            <!-- Container flex responsivo - permite alinhar botão fatura + grupo de filtros + botão calendário -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">


                <!-- Botão Nova Fatura -->
                <div class="mb-2 mb-md-0"> <button class="btn" id="btn-nova-fatura" data-bs-toggle="modal"
                        data-bs-target="#editModalNovaFatura"> + Nova Fatura </button>
                </div>

                <!-- Modal Nova Instituicao -->
                @include('componentes.instituicao.nova-instituicao', ['redirect' => 'financas'])

                <!-- Modal Nova Fatura -->
                <div class="modal fade" id="editModalNovaFatura" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content rounded-0 shadow">
                            <div class="modal-header">
                                <div class="col-12 col-md-8">
                                    <h5 class="modal-title">Adicionar nova fatura</h5> <small
                                        class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                                </div> <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formNovaFatura" action="{{ route('novaFatura_route') }}" method="POST"> @csrf

                                    <input type="hidden" id="valor_total" value="" name="valor_total">
                                    <input type="hidden" id="valor_iva" value="" name="valor_iva">
                                    <input type="hidden" id="valor_irs" value="" name="valor_irs">
                                    <input type="hidden" id="valor_subtotal" value="" name="valor_subtotal">
                                    <input type="hidden" id="valor_liquido" value="" name="valor_liquido">
                                    <div class="row g-3 mb-3">

                                        <!-- Instituição -->
                                        <div class="col-md-12">
                                            <label for="instituicao" class="form-label">Instituição*</label>
                                            <select class="form-control" id="instituicao" name="instituicao" required>
                                                <option value="" selected disabled>Selecione uma instituição</option>
                                                @foreach ($instituicoes as $inst)
                                                    <option value="{{ $inst->id }}">{{ $inst->nomeInstituicao }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="d-flex justify-content-end mt-1">
                                                <button type="button" class="btn btn-sm btn-novo-curso"
                                                    data-bs-toggle="modal" data-bs-target="#novaInstituicaoModal">
                                                    <i class="bi bi-building-fill"></i> Cadastrar Nova Instituição
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Curso -->
                                        <div class="col-md-6"> <label for="curso" class="form-label">Curso*</label>
                                            <select class="form-control" id="curso" name="curso"6>
                                                <option value="" selected disabled>Selecione um curso</option>
                                                @foreach ($cursos as $curso)
                                                    <option value="{{ $curso->id }}"
                                                        data-instituicao="{{ $curso->instituicoes_id }}">
                                                        {{ $curso->titulo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Módulo -->
                                        <div class="col-md-6"> <label for="curso" class="form-label">Módulo</label>
                                            <select class="form-control" id="modulo" name="modulo">
                                                <option value="" selected disabled>Selecione um módulo</option>
                                                @foreach ($modulos as $modulo)
                                                    <option value="{{ $modulo->id }}"
                                                        data-curso="{{ $modulo->curso_id }}">
                                                        {{ $modulo->nomeModulo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Descrição -->
                                        <div class="col-md-12 mb-3"> <label for="descricao"
                                                class="form-label">Descrição*</label>
                                            <input type="text" class="form-control rounded-0" id="descricao"
                                                name="descricao" placeholder="Ex: Formação em Excel - 6h" required>
                                        </div>

                                        <!-- Quantidade e Valor -->
                                        <div class="row mb-3">
                                            <div class="col-4"> <label class="form-label">Quantidade Horas*</label>
                                                <input type="number" class="form-control rounded-0" id="fatura-qtd"
                                                    name="qtd" value="1" required>
                                            </div>
                                            <div class="col-8"> <label class="form-label">Valor unitário (€)*</label>
                                                <input type="number" class="form-control rounded-0" id="fatura-valor"
                                                    name="valor" placeholder="0.00">
                                            </div>
                                        </div>

                                        <!-- IVA & IRS -->
                                        <div class="row mb-3">
                                            <div class="col-6"> <label class="form-label">IVA (%)*</label> <input
                                                    type="number" class="form-control rounded-0" id="fatura-iva"
                                                    name="iva" value="0" required> </div>
                                            <div class="col-6"> <label class="form-label">IRS (%)*</label> <input
                                                    type="number" class="form-control rounded-0" id="fatura-irs"
                                                    name="irs" value="0" required> </div>
                                        </div>

                                        <!-- Totais -->
                                        <div class="border p-3 bg-light rounded-0 mb-2">
                                            <p class="mb-1">Subtotal (sem IVA/IRS) <strong id="subtotal">€0,00</strong>
                                            </p>
                                            <p class="mb-1">IVA: <strong id="iva">€0,00</strong></p>
                                            <p class="mb-1">IRS: <strong id="irs">-€0,00</strong></p>
                                            <hr class="my-2">
                                            <p class="mb-1">Líquido Real (Tu recebes): <strong
                                                    id="liquido">€0,00</strong></p>
                                            <p class="mb-0 fw-bold">Total c/ IVA (Cliente paga): <span
                                                    class="text-success" id="total">€0,00</span></p>
                                        </div>

                                        <!-- Datas -->
                                        <div class="row g-3 mb-2">
                                            <div class="col"> <label for="dataEmissao" class="form-label">Data
                                                    Emissão*</label> <input type="date" class="form-control rounded-0"
                                                    id="dataEmissao" name="dataEmissao" required> </div>
                                            <div class="col"> <label for="dataPagamento" class="form-label">Data
                                                    Pagamento</label> <input type="date" class="form-control rounded-0"
                                                    id="dataPagamento" name="dataPagamento"> </div>
                                        </div>

                                        <!--Estado Faturas-->
                                        <div class="row g-3 mb-2">
                                            <div class="col"> <label for="estadoFatura" class="form-label">Estado da
                                                    Fatura*</label>
                                                <select class="form-control" id="estadoFatura" name="estadoFatura"
                                                    required>
                                                    <option value="" selected disabled>Selecione um estado
                                                    </option>
                                                    @foreach ($estados as $estado)
                                                        <option value="{{ $estado->id }}">
                                                            {{ $estado->nomeEstadoFatura }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <!-- Observações -->
                                        <div class="mb-3"> <label for="observacoes"
                                                class="form-label">Observações</label>
                                            <textarea class="form-control rounded-0" id="observacoes" name="observacoes" rows="3"></textarea>
                                        </div>


                                        <!-- Botão -->
                                        <div class="text-center"> <button type="submit"
                                                class="btn btn-primary rounded-0">Adicionar Fatura</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtros Este Mês/Último Mês/Trimestre -->
                <form action="{{ route('financas') }}" method="GET" class="mb-3">
                    <select name="filtro" onchange="this.form.submit()" class="form-select w-auto d-inline">
                        <option value="">Todos</option>
                        <option value="este_mes" {{ $filtro == 'este_mes' ? 'selected' : '' }}>Este mês</option>
                        <option value="ultimo_mes" {{ $filtro == 'ultimo_mes' ? 'selected' : '' }}>Último mês</option>
                        <option value="trimestre" {{ $filtro == 'trimestre' ? 'selected' : '' }}>Trimestre</option>
                    </select>
                </form>
            </div>


            <!--Grid faturação (total & paga)/ganhos/expectável-->

            <div class="container mt-4">
                <div class="row">

                    <!-- Card 1 - Faturação Válida (faturas emitidas & pagas) -->
                    <div class="col-12 col-md-3 d-flex mb-3 mb-md-0">
                        <div class="card card-financas h-100 w-100">
                            <div class="card-body position-relative">
                                <div class="row">
                                    <!-- Título -->
                                    <div class="col-12 col-md-8">
                                        <h5 class="card-title">Faturação
                                            <span style="border-bottom: 1px dotted #6c757d; cursor: help;"
                                                title="Faturação Válida - Total de Faturas Emitidas & Pagas.">
                                                <i class="bi bi-info-circle fs-6"></i>
                                            </span>
                                        </h5>
                                    </div>
                                </div>

                                <div class="row mt-2 align-items-center">
                                    <!-- Texto à esquerda -->
                                    <div class="col-8">
                                        <!-- Valor em destaque -->
                                        <div class="text-amount mb-1">
                                            <h3 class="text fw-bold mb-0">
                                                {{ number_format($totalFaturacao, 2, ',', '.') }}€</h3>
                                        </div>

                                        <!-- Valor IVA -->
                                        <div class="text-amount mt-2">
                                            <h6 class="text-black-50 small">IVA
                                                {{ number_format($totalIva, 2, ',', '.') }}€</h6>
                                        </div>

                                        <!-- Valor IRS -->
                                        <div class="text-amount mt-1">
                                            <h6 class="text-black-50 small">IRS
                                                {{ number_format($totalIrs, 2, ',', '.') }}€</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Card 2 - Faturação Paga (faturas pagas) -->
                    <div class="col-12 col-md-3 d-flex mb-3 mb-md-0">
                        <div class="card card-financas h-100 w-100">
                            <div class="card-body position-relative">
                                <div class="row">
                                    <!-- Título -->
                                    <div class="col-12 col-md-8">
                                        <h5 class="card-title">Faturas Pagas
                                            <span style="border-bottom: 1px dotted #6c757d; cursor: help;"
                                                title="Faturação Paga - Total de Faturas Pagas.">
                                                <i class="bi bi-info-circle fs-6"></i>
                                            </span>
                                        </h5>
                                    </div>
                                </div>

                                <div class="row mt-2 align-items-center">
                                    <!-- Texto à esquerda -->
                                    <div class="col-8">
                                        <!-- Valor em destaque -->
                                        <div class="text-amount mb-1">
                                            <h3 class="text fw-bold mb-0">
                                                {{ number_format($totalFaturacaoPaga, 2, ',', '.') }}€</h3>
                                        </div>

                                        <!-- Valor IVA -->
                                        <div class="text-amount mt-2">
                                            <h6 class="text-black-50 small">IVA
                                                {{ number_format($totalIvaPago, 2, ',', '.') }}€</h6>
                                        </div>

                                        <!-- Valor IRS -->
                                        <div class="text-amount mt-1">
                                            <h6 class="text-black-50 small">IRS
                                                {{ number_format($totalIrsPago, 2, ',', '.') }}€</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 - Ganhos (valor liquido) -->
                    <div class="col-12 col-md-3 d-flex mb-3 mb-md-0">
                        <div class="card card-financas h-100 w-100">
                            <div class="card-body position-relative">
                                <div class="row">
                                    <!-- Título -->
                                    <div class="col-12 col-md-8">
                                        <h5 class="card-title">Ganhos
                                            <span style="border-bottom: 1px dotted #6c757d; cursor: help;"
                                                title="Valor Ganho - Valor líquido efetivamente recebido depois de entregar o IVA e descontar o IRS. Calculado a partir das Faturas Pagas.">
                                                <i class="bi bi-info-circle fs-6"></i>
                                            </span>
                                        </h5>
                                    </div>
                                </div>

                                <!-- Conteúdo -->
                                <div class="text-amount mt-2 mb-1" id="tituloGanhos">
                                    <h3 class="fw-bold mb-0">{{ number_format($totalGanhos, 2, ',', '.') }}€</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 - Expectável -->
                    <div class="col-12 col-md-3 d-flex mb-3 mb-md-0">
                        <div class="card card-financas h-100 w-100">
                            <div class="card-body position-relative">
                                <div class="row">
                                    <!-- Título -->
                                    <div class="col-12 col-md-8">
                                        <h5 class="card-title">Expectável
                                            <span style="border-bottom: 1px dotted #6c757d; cursor: help;"
                                                title="Valor Expectável -  Com base nas aulas agendadas durante o período atualmente filtrado. Valor sem impostos. Será faturado com IVA adicional.">
                                                <i class="bi bi-info-circle fs-6"></i>
                                            </span>
                                        </h5>
                                    </div>
                                </div>

                                <div class="row mt-2 align-items-center">
                                    <!-- Texto à esquerda -->
                                    <div class="col-8">
                                        <!-- Valor em destaque -->
                                        <div class="text-amount mb-1">
                                            <h3 class="text fw-bold mb-0">
                                                {{ number_format($valorTotalExpectavel, 2, ',', '.') }}€</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <!-- Grid Esquerda/Direita
                                                                Faturação por Instituição/Faturas -->
            <div class="container mt-4">
                <div class="row d-flex align-items-stretch">

                    <!-- Coluna 1: Faturação por Instituição -->
                    <div class="col-12 col-md-4 d-flex justify-content-center mb-3 mb-md-0">
                        <div class="card-ganhos w-100 w-md-auto">
                            <div class="card shadow-sm rounded-0 p-3 h-100 w-100">
                                <div class="card-body">

                                    <!--Título e Icon Filtro-->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="card-title">Faturação por Instituição
                                            <span style="border-bottom: 1px dotted #6c757d; cursor: help;"
                                                title="Faturação Válida - Com base nas Faturas Emitidas & Pagas.">
                                                <i class="bi bi-info-circle fs-6"></i>
                                            </span>
                                        </h5>

                                    </div>

                                    <div class="w-1/2 mx-auto">
                                        <canvas id="donutChart" data-faturacao='@json($faturacaoInstituicoes)'>
                                        </canvas>
                                    </div>


                                    <!-- Legenda -->
                                    <ul class="list-unstyled mt-4 small" id="listaInstituicoes">
                                        @foreach ($faturacaoInstituicoes as $instituicao)
                                            <li class="d-flex align-items-center mb-2">
                                                <span class="badge rounded-circle me-2"
                                                    style="background-color: {{ $instituicao['cor'] }};">&nbsp;</span>
                                                <span class="text-secondary">{{ $instituicao['nome'] }}</span>
                                                <span
                                                    class="ms-auto fw-bold text-dark">{{ $instituicao['percent'] }}%</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Coluna 2: Faturas -->
                    <div class="col-md-8 d-flex mb-3 mb-md-0">
                        <div class="card-faturas">
                            <div class="card shadow-sm rounded-0 p-3 h-100 w-100">
                                <div class="card-body">

                                    <!--Título e Icon Filtro-->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="card-title">Faturas</h5>
                                    </div>

                                    <!-- Tabela Faturas -->
                                    <div class="table-responsive flex-grow-1 overflow-auto" id="faturasTabela">
                                        <table class="table table-hover align-middle text-center mb-0 table-sm">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Instituição</th>
                                                    <th>Valor</th>
                                                    <th>Estado</th>
                                                    <th>Data de Emissão</th>
                                                    <th>Data de Pagamento</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabelaFaturas">
                                                @foreach ($financas as $financa)
                                                    <tr>
                                                        <td class="text-start">
                                                            <span class="badge rounded-circle me-2"
                                                                style="background-color:{{ $financa->instituicao->cor ?? '#ccc' }};">&nbsp;</span>
                                                            </td>
                                                        <td class="text-start">
                                                            {{ $financa->instituicao->nomeInstituicao }}
                                                        </td>
                                                        <td class="">
                                                            {{ number_format($financa->valor, 2, ',', '.') }}€
                                                        </td>
                                                        <!--Para permitir 2 casas decimais-->
                                                        <td class="">
                                                            @if ($financa->estadoFatura->nomeEstadoFatura == 'Paga')
                                                                <span
                                                                    class="text-success">{{ $financa->estadoFatura->nomeEstadoFatura }}</span>
                                                            @elseif ($financa->estadoFatura->nomeEstadoFatura == 'Vencida')
                                                                <span
                                                                    class="text-danger">{{ $financa->estadoFatura->nomeEstadoFatura }}</span>
                                                            @elseif ($financa->estadoFatura->nomeEstadoFatura == 'Emitida')
                                                                <span
                                                                    class="text-primary">{{ $financa->estadoFatura->nomeEstadoFatura }}</span>
                                                            @else
                                                                {{ $financa->estadoFatura->nomeEstadoFatura }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($financa->dataEmissao)->format('d/m/Y') }}
                                                        </td>
                                                        <td>
                                                            @if ($financa->estado_faturas_id == 2 && $financa->recebimento)
                                                                <!--Se a fatura estiver Paga, aparece dataRecebimento (tabela recebimentos) ou dataPagamento (tabela financas). Se não estiver paga, aparece a dataEmissao (tabela financas)-->
                                                                {{ \Carbon\Carbon::parse($financa->recebimento->dataRecebimento)->format('d/m/Y') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-end">
                                                            <!--Retirado da Blade Detalhes-Curso-->

                                                            <!-- Botão Collapse -->
                                                            <button class="btn btn-sm btn-light btn-apagar" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#acoesFatura-{{ $financa->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="acoesFatura-{{ $financa->id }}">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>

                                                            <!-- Lista de estados disponíveis -->
                                                            <div class="collapse mt-2 position-absolute bg-white border rounded shadow"
                                                                id="acoesFatura-{{ $financa->id }}"
                                                                style="z-index:1000; min-width:150px;">

                                                                <!--Botão fechar collapse depois de aberto -->
                                                                <div class="d-flex justify-content-end p-2">
                                                                    <button type="button"
                                                                        class="btn-close js-close-collapse"
                                                                        data-target="#acoesFatura-{{ $financa->id }}"
                                                                        aria-label="Fechar"></button>
                                                                </div>
                                                                <div class="p-2">
                                                                    @foreach ($estados as $estado)
                                                                        @if ($financa->estado_faturas_id !== $estado->id)
                                                                            <!--Só mostra os estados alternativos-->
                                                                            <form
                                                                                action="{{ route('faturaUpdate_route', $financa->id) }}"
                                                                                method="POST" class="mb-1">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <input type="hidden" name="estadoFatura"
                                                                                    value="{{ $estado->id }}">
                                                                                <button type="submit"
                                                                                    id="buttonAlterarEstado"
                                                                                    class="btn btn-sm btn-alterar-estado w-100">
                                                                                    {{ $estado->nomeEstadoFatura }}
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($financa->estado_faturas_id != 2)
                                                                <!-- Botão Editar só aparece se NÃO for paga -->
                                                                <button type="button"
                                                                    class="btn btn-link btn-editar-fatura btn-apagar"
                                                                    data-fatura='@json($financa)'>
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-link text-danger btn-apagar"
                                                                data-bs-toggle="modal" data-bs-target="#confirmarEliminar"
                                                                data-id="{{ $financa->id }}"><i
                                                                    class="bi bi-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Modal Eliminar Fatura -->
                    <div class="modal fade" id="confirmarEliminar" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmar eliminação</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <p>Tem certeza que deseja eliminar esta fatura?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-novo-curso" data-bs-dismiss="modal">
                                        Cancelar
                                    </button>

                                    <form id="formEliminar" method="POST" action="">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-novo-curso">
                                            Eliminar <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Modal Editar Fatura -->
                    <div class="modal fade" id="modalEditarFatura" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content rounded-0 shadow">
                                <div class="modal-header">
                                    <div class="col-12 col-md-8">
                                        <h5 class="modal-title">Editar Fatura</h5>
                                        <small class="card-subtitle fw-light">Campos com * têm que estar preenchidos.</small>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="formEditarFatura" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" id="valor_total_editar" name="valor_total">
                                        <input type="hidden" id="valor_iva_editar" name="valor_iva">
                                        <input type="hidden" id="valor_irs_editar" name="valor_irs">
                                        <input type="hidden" id="valor_subtotal_editar" name="valor_subtotal">
                                        <input type="hidden" id="valor_liquido_editar" name="valor_liquido">


                                        <div class="row g-3 mb-3">
                                            <!-- Instituição -->
                                            <div class="col-md-6">
                                                <label for="instituicaoEditar" class="form-label">Instituição</label>
                                                <select class="form-control" id="instituicaoEditar" name="instituicao"
                                                    disabled>
                                                    <option value="" disabled>Selecione uma instituição</option>
                                                    @foreach ($instituicoes as $inst)
                                                        <option value="{{ $inst->id }}">{{ $inst->nomeInstituicao }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Curso -->
                                            <div class="col-md-6">
                                                <label for="cursoEditar" class="form-label">Curso</label>
                                                <select class="form-control" id="cursoEditar" name="curso" disabled>
                                                    <option value="" disabled>Selecione um curso</option>
                                                    @foreach ($cursos as $curso)
                                                        <option value="{{ $curso->id }}">{{ $curso->titulo }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Módulo -->
                                            <div class="col-md-6">
                                                <label for="moduloEditar" class="form-label">Módulo</label>
                                                <select class="form-control" id="moduloEditar" name="modulo" disabled>
                                                    <option value="" disabled>Selecione um módulo</option>
                                                    @foreach ($modulos as $modulo)
                                                        <option value="{{ $modulo->id }}">{{ $modulo->nomeModulo }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Descrição -->
                                            <div class="col-md-6 mb-3">
                                                <label for="descricaoEditar" class="form-label">Descrição*</label>
                                                <input type="text" class="form-control rounded-0" id="descricaoEditar"
                                                    name="descricao" required>
                                            </div>

                                            <!-- Quantidade e Valor -->
                                            <div class="row mb-3">
                                                <div class="col-4">
                                                    <label class="form-label">Quantidade Horas*</label>
                                                    <input type="number" class="form-control rounded-0" id="qtdEditar"
                                                        name="qtd" value="1" required>
                                                </div>
                                                <div class="col-8">
                                                    <label class="form-label">Valor unitário (€)*</label>
                                                    <input type="number"
                                                        class="form-control rounded-0" id="valorEditar" name="valor">
                                                </div>
                                            </div>

                                            <!-- IVA & IRS -->
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <label class="form-label">IVA (%)*</label>
                                                    <input type="number" class="form-control rounded-0" id="ivaEditar"
                                                        name="iva" value="0" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">IRS (%)*</label>
                                                    <input type="number" class="form-control rounded-0" id="irsEditar"
                                                        name="irs" value="0" required>
                                                </div>
                                            </div>

                                            <!-- Datas -->
                                            <div class="row g-3 mb-2">
                                                <div class="col">
                                                    <label for="dataEmissaoEditar" class="form-label">Data
                                                        Emissão*</label>
                                                    <input type="date" class="form-control rounded-0"
                                                        id="dataEmissaoEditar" name="dataEmissao" required>
                                                </div>
                                                <div class="col">
                                                    <label for="dataPagamentoEditar" class="form-label">Data
                                                        Pagamento</label>
                                                    <input type="date" class="form-control rounded-0"
                                                        id="dataPagamentoEditar" name="dataPagamento">
                                                </div>
                                            </div>

                                            <!-- Estado Fatura -->
                                            <div class="row g-3 mb-2">
                                                <div class="col">
                                                    <label for="estadoFaturaEditar" class="form-label">Estado da
                                                        Fatura*</label>
                                                    <select class="form-control" id="estadoFaturaEditar"
                                                        name="estadoFatura" required>
                                                        <option value="" disabled>Selecione um estado</option>
                                                        @foreach ($estados as $estado)
                                                            <option value="{{ $estado->id }}">
                                                                {{ $estado->nomeEstadoFatura }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Observações -->
                                            <div class="mb-3">
                                                <label for="observacoesEditar" class="form-label">Observações</label>
                                                <textarea class="form-control rounded-0" id="observacoesEditar" name="observacoes" rows="3"></textarea>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary rounded-0"
                                                    id="btn-nova-fatura">Atualizar
                                                    Fatura</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>





                </div>
            </div>

        </div>
    </div>

    @include('componentes.perfil.perfil')
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!--Gráfico donut-->
    <script src="{{ asset('js/financas.js') }}"></script>
@endsection

@endsection
