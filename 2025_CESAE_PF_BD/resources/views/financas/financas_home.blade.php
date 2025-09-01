@extends('layouts.fe_master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/financas_home.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/financas.js') }}" defer></script>
@endsection

@section('content')
    <div class="content">
        <div class="container my-4">

            <!-- Título -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Gestão Financeira</h2>
                <input type="text" class="form-control  w-auto ms-auto" placeholder="Pesquisar Fatura..."
                    id="pesquisa-fatura">
                {{-- ms-auto → margem à esquerda automática, empurra o input para o final da linha.
    w-auto → limita a largura da barra de pesquisa, não ocupando todo o espaço. --}}
            </div>

            <!-- Container flex responsivo - permite alinhar botão fatura + grupo de filtros + botão calendário -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

                <!-- Botão Nova Fatura -->
                <div class="mb-2 mb-md-0">
                    <button class="btn" id="btn-nova-fatura" data-bs-toggle="modal"
                        data-bs-target="#editModalNovaFatura">
                        + Nova Fatura
                    </button>
                </div>

                <!-- Modal Nova Fatura -->
                <div class="modal fade" id="editModalNovaFatura" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content rounded-0 shadow">
                            <div class="modal-header">
                                <div class="col-12 col-md-8">
                                    <h5 class="modal-title">Adicionar nova fatura</h5>
                                    <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formNovaFatura" action="{{ route('novaFatura_route') }}" method="POST">
                                    @csrf

                                    <div class="row g-3 mb-3">

                                        <!-- Instituição -->
                                        <div class="col-md-6">
                                            <label for="instituicao" class="form-label">Instituição*</label>
                                            <select class="form-control" id="instituicao" name="instituicao" required>
                                                <option value="" selected disabled>Selecione uma instituição</option>
                                                @foreach ($instituicoes as $inst)
                                                    <option value="{{ $inst->id }}">{{ $inst->nomeInstituicao }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Curso -->
                                        <div class="col-md-6">
                                            <label for="curso" class="form-label">Curso*</label>
                                            <select class="form-control" id="curso" name="curso" required>
                                                <option value="" selected disabled>Selecione um curso</option>
                                                @foreach ($cursos as $curso)
                                                    <option value="{{ $curso->id }}">{{ $curso->titulo }}</option>
                                                @endforeach
                                            </select>
                                        </div>



                                        <!-- Descrição -->
                                        <div class="mb-3">
                                            <label for="descricao" class="form-label">Descrição*</label>
                                            <input type="text" class="form-control rounded-0" id="descricao"
                                                name="descricao" placeholder="Ex: Formação em Excel - 6h" required>
                                        </div>

                                        <!-- Quantidade e Valor -->
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label class="form-label">Quantidade Horas</label>
                                                <input type="number" class="form-control rounded-0" id="fatura-qtd"
                                                    name="qtd" value="1">
                                            </div>
                                            <div class="col-8">
                                                <label class="form-label">Valor unitário (€)</label>
                                                <input type="number" class="form-control rounded-0" id="fatura-valor"
                                                    name="valor" placeholder="0.00">
                                            </div>
                                        </div>

                                        <!-- IVA & IRS -->
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label">IVA (%)</label>
                                                <input type="number" class="form-control rounded-0" id="fatura-iva"
                                                    name="iva" value="0">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">IRS (%)</label>
                                                <input type="number" class="form-control rounded-0" id="fatura-irs"
                                                    name="irs" value="0">
                                            </div>
                                        </div>

                                        <!-- Totais -->
                                        <div class="border p-3 bg-light rounded-0 mb-3">
                                            <p class="mb-1">Subtotal: <strong id="subtotal">€0,00</strong></p>
                                            <p class="mb-1">IVA: <strong id="iva">€0,00</strong></p>
                                            <p class="mb-1">IRS: <strong id="irs">-€0,00</strong></p>
                                            <hr class="my-2">
                                            <p class="mb-0 fw-bold"> Total líquido: <span class="text-primary"
                                                    id="total">€0,00</span></p>
                                        </div>

                                        <!-- Datas -->
                                        <div class="row g-3 mb-3">
                                            <div class="col">
                                                <label for="dataEmissao" class="form-label">Data Emissão*</label>
                                                <input type="date" class="form-control rounded-0" id="dataEmissao"
                                                    name="dataEmissao" required>
                                            </div>
                                            <div class="col">
                                                <label for="dataPagamento" class="form-label">Data Pagamento</label>
                                                <input type="date" class="form-control rounded-0" id="dataPagamento"
                                                    name="dataPagamento">
                                            </div>
                                        </div>

                                        <!-- Observações -->
                                        <div class="mb-3">
                                            <label for="observacoes" class="form-label">Observações</label>
                                            <textarea class="form-control rounded-0" id="observacoes" name="observacoes" rows="3"></textarea>
                                        </div>

                                        <!-- Botão -->
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary rounded-0">Adicionar
                                                Fatura</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!--CONFIRMAR COM SARA QUESTÃO MODAL NOVA FATURA - apagar os outros quando estiver resolvido -->

                <!--Modal Nova Fatura-->
                {{-- <div class="modal fade" id="editModalNovaFatura" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-0 shadow">
      <div class="modal-header">
        <h5 class="modal-title">Nova Fatura</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <!-- Instituição já pré-selecionada -->
        <div class="mb-3">
          <label class="form-label fw-bold">Instituição</label>
          <input type="text" class="form-control rounded-0" value="Instituto XPTO - Curso de Excel" readonly>
        </div>

        <!-- Serviço -->
        <div class="mb-3">
          <label class="form-label fw-bold">Descrição</label>
          <input type="text" class="form-control rounded-0" placeholder="Ex: Formação em Excel - 6h">
        </div>

        <div class="row mb-3">
          <div class="col-4">
            <label class="form-label fw-bold">Qtd</label>
            <input type="number" class="form-control rounded-0" id="fatura-qtd" value="1">
          </div>
          <div class="col-8">
            <label class="form-label fw-bold">Valor unitário (€)</label>
            <input type="number" class="form-control rounded-0" id="fatura-valor" placeholder="0.00">
          </div>
        </div>

        <!-- Impostos -->
        <div class="row mb-3">
          <div class="col-6">
            <label class="form-label fw-bold">IVA (%)</label>
            <input type="number" class="form-control rounded-0" id="fatura-iva" value="0">
          </div>
          <div class="col-6">
            <label class="form-label fw-bold">IRS (%)</label>
            <input type="number" class="form-control rounded-0" id="fatura-irs" value="0">
          </div>
        </div>

        <!-- Totais -->
        <div class="border p-3 bg-light rounded-0">
          <p class="mb-1">Subtotal: <strong id="subtotal">€0,00</strong></p>
          <p class="mb-1">IVA: <strong id="iva">€0,00</strong></p>
          <p class="mb-1">IRS: <strong id="irs">-€0,00</strong></p>
          <hr class="my-2">
          <p class="mb-0 fw-bold">💰 Total líquido: <span class="text-primary" id="total">€0,00</span></p>
        </div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary rounded-0">Guardar Fatura</button>
      </div>
    </div>
  </div>
</div> --}}
                {{-- <!-- Modal Nova Fatura Curso -->
                <div class="modal fade" id="editModalNovaFatura" tabindex="-1" aria-labelledby="editModalNovaFatura"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="col-12 col-md-8">
                                    <h5 class="modal-title" id="editModalNovaFatura">Adicionar nova fatura</h5>
                                    <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                                </div>
                                <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
                                    data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('novaFatura_route') }}" method="POST">
                                    @csrf

                                    <!-- Nº Fatura -->
                                    <div class="mb-3">
                                        <label for="numeroFatura" class="form-label">Nº Fatura*</label>
                                        <input type="text" class="form-control" id="numeroFatura" name="numeroFatura"
                                            required>
                                    </div>

                                    <!-- Instituição -->
                                    <div class="mb-3">
                                        <label for="instituicao" class="form-label">Instituição*</label>
                                        <select class="form-control" id="instituicao" name="instituicao" required>
                                            <option value="" selected disabled>Selecione uma instituição</option>
                                            @foreach ($instituicoes as $inst)
                                                <option value="{{ $inst->id }}">{{ $inst->nomeInstituicao }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Curso -->
                                    <div class="mb-3">
                                        <label for="curso" class="form-label">Curso*</label>
                                        <select class="form-control" id="curso" name="curso" required>
                                            <option value="" selected disabled>Selecione um curso</option>
                                            @foreach ($cursos as $curso)
                                                <option value="{{ $curso->id }}">{{ $curso->titulo }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Valor -->
                                    <div class="row g-3 mb-3">
                                        <div class="col">
                                            <label for="valorFatura" class="form-label">Valor*</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="valorFatura"
                                                    name="valorFatura" required>
                                                <span class="input-group-text">€</span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="valorIVA" class="form-label">IVA*</label>
                                            <input type="number" class="form-control" id="valorIVA" name="valorIVA"
                                                required>
                                        </div>
                                        <div class="col">
                                            <label for="valorIRS" class="form-label">IRS*</label>
                                            <input type="number" class="form-control" id="valorIRS" name="valorIRS"
                                                required>
                                        </div>
                                    </div>

                                    <!-- Datas -->
                                    <div class="row g-3 mb-3">
                                        <div class="col">
                                            <label for="dataEmissao" class="form-label">Data Emissão*</label>
                                            <input type="date" class="form-control" id="dataEmissao" name="dataEmissao"
                                                required>
                                        </div>
                                        <div class="col">
                                            <label for="dataPagamento" class="form-label">Data Pagamento</label>
                                            <input type="date" class="form-control" id="dataPagamento"
                                                name="dataPagamento">
                                        </div>
                                    </div>


                                    <!-- Observações -->
                                    <div class="mb-3">
                                        <label for="observacoes" class="form-label">Observações</label>
                                        <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
                                    </div>

                                    <!-- Botão submit -->
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-novo-curso">
                                            Adicionar Fatura<i class="bi bi-check-lg text-success"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> --}}



                <!-- Filtros à direita -->
                <div class="d-flex flex-wrap align-items-center">
                    <!-- Grupo de filtros -->
                    <div class="btn-group me-2 mb-2 mb-md-0" role="group" aria-label="Filtros de período">
                        <input type="radio" class="btn-check" name="periodo" id="btnEsteMes" autocomplete="off"
                            checked>
                        <label class="btn btn-filtro active" for="btnEsteMes">Este mês</label>

                        <input type="radio" class="btn-check" name="periodo" id="btnUltimoMes" autocomplete="off">
                        <label class="btn btn-filtro" for="btnUltimoMes">Último mês</label>

                        <input type="radio" class="btn-check" name="periodo" id="btnTrimestral" autocomplete="off">
                        <label class="btn btn-filtro" for="btnTrimestral">Trimestral</label>
                    </div>

                    <!-- Botão de calendário -->
                    <div class="col">
                        <input type="date" class="form-control rounded-0" id="dataInicio" name="dataInicio" required>
                    </div>
                    <div class="col">
                        <input type="date" class="form-control rounded-0" id="dataFim" name="dataFim" required>
                    </div>

                </div>
            </div>


            <!--Grid ganhos/expectável/objetivo-->

            <div class="container mt-4">
                <div class="row">

                    <!-- Card 1 -->
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card card-financas h-100 w-100">
                            <div class="card-body position-relative">
                                <div class="row">
                                    <!-- Título -->
                                    <div class="col-12 col-md-8">
                                        <h5 class="card-title">Ganhos até agora</h5>
                                    </div>
                                </div>

                                <div class="row mt-2 align-items-center">
                                    <!-- Texto à esquerda -->
                                    <div class="col-8">
                                        <!-- Valor em destaque -->
                                        <div class="text-amount mb-1">
                                            <h3 class="text-info fw-bold mb-0">1200€</h3>
                                        </div>

                                        <!-- Valor IVA -->
                                        <div class="text-amount mt-2">
                                            <h6 class="text-black-50">Valor IVA </h6>
                                        </div>

                                        <!-- Valor IRS -->
                                        <div class="text-amount mt-1">
                                            <h6 class="text-black-50">Valor IRS</h6>
                                        </div>
                                    </div>

                                    <!-- Progresso circular à direita -->
                                    <div class="col-4 d-flex justify-content-center">
                                        <div class="circular-progress" style="--value:60">
                                            <span>60%</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card card-financas h-100 w-100">
                            <div class="card-body position-relative">
                                <div class="row">
                                    <!-- Título -->
                                    <div class="col-12 col-md-8">
                                        <h5 class="card-title">Expectável</h5>
                                    </div>
                                </div>

                                <!-- Conteúdo -->
                                <div class="text-amount mt-2 mb-1" id="tituloValorExpectavel">
                                    <h3 class="fw-bold mb-0">2000€</h3>
                                </div>

                                <div class="text-amount mt-2">
                                    <h6 class="text-black-50">Valor IVA </h6>
                                </div>

                                <div class="text-amount mt-1">
                                    <h6 class="text-black-50">Valor IRS</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <!-- Grid Ganhos por Instituição & Recibos -->
            <div class="container mt-4">
                <div class="row">

                    <!-- Coluna 1: Ganhos por Instituição -->
                    <div class="col-md-4">
                        <div class="card-ganhos">
                            <div class="card shadow-sm rounded-0 p-3">
                                <div class="card-body">

                                    <!--Título e Icon Filtro-->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="card-title">Ganhos por Instituição</h5>
                                        <i class="material-icons-outlined" id="icon-filter" data-bs-toggle="modal"
                                            data-bs-target="#modalFiltroInstituicao">
                                            filter_alt</i>
                                    </div>


                                    <!-- Modal Filtro Ganhos por Instituição -->
                                    <div class="modal fade" id="modalFiltroInstituicao" tabindex="-1"
                                        aria-labelledby="modalFiltroInstituicaoLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-0">
                                                <div class="modal-header border-0">
                                                    <h6 class="modal-title fw-bold" id="modalFiltroInstituicaoLabel">
                                                        Ganhos por instituição</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fechar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Botão Selecionar tudo -->
                                                    <button type="button" class="btn btn-light mb-3"
                                                        id="btnSelecionarTudo">
                                                        Selecionar tudo
                                                    </button>

                                                    <!-- Lista de instituições -->
                                                    <ul id="checkInstituicoes" class="list-group">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            CESAE <input type="checkbox" class="form-check-input"
                                                                value="CESAE" checked>
                                                        </li>
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            LSD <input type="checkbox" class="form-check-input"
                                                                value="LSD" checked>
                                                        </li>
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            ISTEC <input type="checkbox" class="form-check-input"
                                                                value="ISTEC" checked>
                                                        </li>
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            ISLA <input type="checkbox" class="form-check-input"
                                                                value="ISLA" checked>
                                                        </li>
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            ESTEL <input type="checkbox" class="form-check-input"
                                                                value="ESTEL" checked>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="btnAplicarFiltro">Aplicar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Gráfico donut visual -->
                                    <div class="d-flex justify-content-center align-items-center" style="height: 180px;">
                                        <canvas id="donutInstituicoes"></canvas>
                                    </div>


                                    <!-- Legenda -->
                                    <ul class="list-unstyled mt-3 small" id="listaInstituicoes">
                                        <li class="d-flex align-items-center mb-2">
                                            <span class="badge rounded-circle me-2"
                                                style="background-color:#a78bfa;">&nbsp;</span>
                                            <span class="text-secondary">CESAE</span>
                                            <span class="ms-auto fw-bold text-dark">41,35%</span>
                                        </li>
                                        <li class="d-flex align-items-center mb-2">
                                            <span class="badge rounded-circle me-2"
                                                style="background-color:#ef4444;">&nbsp;</span>
                                            <span class="text-secondary">LSD</span>
                                            <span class="ms-auto fw-bold text-dark">21,51%</span>
                                        </li>
                                        <li class="d-flex align-items-center mb-2">
                                            <span class="badge rounded-circle me-2"
                                                style="background-color:#3b82f6;">&nbsp;</span>
                                            <span class="text-secondary">ISTEC</span>
                                            <span class="ms-auto fw-bold text-dark">13,47%</span>
                                        </li>
                                        <li class="d-flex align-items-center mb-2">
                                            <span class="badge rounded-circle me-2"
                                                style="background-color:#22c55e;">&nbsp;</span>
                                            <span class="text-secondary">ISLA</span>
                                            <span class="ms-auto fw-bold text-dark">9,97%</span>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <span class="badge rounded-circle me-2"
                                                style="background-color:#4338ca;">&nbsp;</span>
                                            <span class="text-secondary">ESTEL</span>
                                            <span class="ms-auto fw-bold text-dark">3,35%</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Coluna 2: Recibos -->
                    <div class="col-md-8">
                        <div class="card-recibos">
                            <div class="card shadow-sm rounded-0 p-3">
                                <div class="card-body">

                                    <!--Título e Icon Filtro-->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title">Recibos</h5>
                                        <i class="material-icons-outlined" id="icon-filter" data-bs-toggle="modal"
                                            data-bs-target="#modalFiltroRecibos">filter_alt</i>
                                    </div>

                                    <!-- Tabela Recibos -->
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Instituição</th>
                                                    <th class="text-end">Estado</th>
                                                    <th class="text-end">Data</th>
                                                    <th class="text-end">Valor</th>
                                                    <th class="text-end"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabelaRecibos">
                                                <tr data-instituicao="CESAE" data-estado="Recibo Enviado"
                                                    data-data="2024-04-01" data-valor="500">
                                                    <td><span class="badge rounded-circle me-2"
                                                            style="background-color:#a78bfa;">&nbsp;</span>CESAE</td>
                                                    <td class="text-end text-success fw-bold">Recibo Enviado</td>
                                                    <td class="text-end text-secondary">2024/04/01</td>
                                                    <td class="text-end fw-bold text-dark">500€</td>
                                                    <td class="text-end"><i class="bi bi-three-dots-vertical"></i></td>
                                                </tr>
                                                <tr data-instituicao="LSD" data-estado="Recibo por Enviar"
                                                    data-data="2024-04-01" data-valor="500">
                                                    <td><span class="badge rounded-circle me-2"
                                                            style="background-color:#ef4444;">&nbsp;</span>LSD</td>
                                                    <td class="text-end text-danger fw-bold">Recibo por Enviar</td>
                                                    <td class="text-end text-secondary">2024/04/01</td>
                                                    <td class="text-end fw-bold text-dark">500€</td>
                                                    <td class="text-end"><i class="bi bi-three-dots-vertical"></i></td>
                                                </tr>
                                                <tr data-instituicao="ISTEC" data-estado="Recibo Enviado"
                                                    data-data="2024-04-01" data-valor="500">
                                                    <td><span class="badge rounded-circle me-2"
                                                            style="background-color:#3b82f6;">&nbsp;</span>ISTEC</td>
                                                    <td class="text-end text-success fw-bold">Recibo Enviado</td>
                                                    <td class="text-end text-secondary">2024/04/01</td>
                                                    <td class="text-end fw-bold text-dark">500€</td>
                                                    <td class="text-end"><i class="bi bi-three-dots-vertical"></i></td>
                                                </tr>
                                                <tr data-instituicao="ISLA" data-estado="Recibo por Enviar"
                                                    data-data="2024-04-01" data-valor="500">
                                                    <td><span class="badge rounded-circle me-2"
                                                            style="background-color:#22c55e;">&nbsp;</span>ISTEC</td>
                                                    <td class="text-end text-success fw-bold">Recibo Enviado</td>
                                                    <td class="text-end text-secondary">2024/04/01</td>
                                                    <td class="text-end fw-bold text-dark">500€</td>
                                                    <td class="text-end"><i class="bi bi-three-dots-vertical"></i></td>
                                                </tr>
                                                <tr data-instituicao="ESTEL" data-estado="Recibo Enviado"
                                                    data-data="2024-04-01" data-valor="500">
                                                    <td><span class="badge rounded-circle me-2"
                                                            style="background-color:#4338ca;">&nbsp;</span>ISTEC</td>
                                                    <td class="text-end text-success fw-bold">Recibo Enviado</td>
                                                    <td class="text-end text-secondary">2024/04/01</td>
                                                    <td class="text-end fw-bold text-dark">500€</td>
                                                    <td class="text-end"><i class="bi bi-three-dots-vertical"></i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Filtro Recibos (fora do card) -->
                    <div class="modal fade" id="modalFiltroRecibos" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-0">
                                <div class="modal-header border-0">
                                    <h6 class="modal-title fw-bold">Filtrar Recibos</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">

                                    <!-- Instituição -->
                                    <h6 class="fw-bold small">Instituição</h6>
                                    <ul id="filtroInstituicao" class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between">CESAE <input
                                                type="checkbox" value="CESAE" checked></li>
                                        <li class="list-group-item d-flex justify-content-between">LSD <input
                                                type="checkbox" value="LSD" checked></li>
                                        <li class="list-group-item d-flex justify-content-between">ISTEC <input
                                                type="checkbox" value="ISTEC" checked></li>
                                        <li class="list-group-item d-flex justify-content-between">ISTA <input
                                                type="checkbox" value="ISLA" checked></li>
                                        <li class="list-group-item d-flex justify-content-between">ESTEL <input
                                                type="checkbox" value="ESTEL" checked></li>
                                    </ul>

                                    <!-- Estado -->
                                    <h6 class="fw-bold small">Estado</h6>
                                    <ul id="filtroEstado" class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between">Recibo Enviado <input
                                                type="checkbox" value="Recibo Enviado" checked></li>
                                        <li class="list-group-item d-flex justify-content-between">Recibo por Enviar <input
                                                type="checkbox" value="Recibo por Enviar" checked></li>
                                    </ul>

                                    <!-- Data -->
                                    <h6 class="fw-bold small">Data</h6>
                                    <input type="date" id="filtroDataInicio" class="form-control mb-2">
                                    <input type="date" id="filtroDataFim" class="form-control mb-3">

                                    <!-- Valor -->
                                    <h6 class="fw-bold small">Valor (€)</h6>
                                    <input type="number" id="filtroValorMin" class="form-control mb-2"
                                        placeholder="Mínimo">
                                    <input type="number" id="filtroValorMax" class="form-control mb-3"
                                        placeholder="Máximo">

                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary"
                                        id="btnAplicarFiltroRecibos">Aplicar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!--Garante que o modal funciona nesta página-->
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
@endsection
