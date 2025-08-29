@extends('layouts.fe_master')

@section('css')
<link rel="stylesheet" href="{{ asset('css/financas_home.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="container my-4">

  <!-- Título -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Gestão Financeira</h2>
    <input type="text" class="form-control  w-auto ms-auto" placeholder="Pesquisar Fatura..." id="pesquisa-fatura">
    {{-- ms-auto → margem à esquerda automática, empurra o input para o final da linha.
    w-auto → limita a largura da barra de pesquisa, não ocupando todo o espaço. --}}
</div>
<!-- Botão Nova Fatura -->
<div class="mb-4">
     <a href="{{ route('financas_adicionar') }}" class="btn" id="btn-nova-fatura">+ Nova Fatura</a></button>
</div>

<!--Grid ganhos/expectável/objetivo-->

<div class="container mt-4">
  <div class="row">

<!-- Card 1 -->
<div class="col-12 col-md-6 col-lg-4">
  <div class="card card-financas">
    <div class="card-body">
      <div class="row d-flex justify-content-between">
        <!-- Título -->
        <div class="col-12 col-md-8">
          <h5 class="card-title">Ganhos até agora</h5>
        </div>

        <!-- Percentagem no canto superior direito -->
        <div class="col-12 col-md-4 d-flex align-items-center">
          <span class="d-inline-flex align-items-center px-2 py-1 border rounded-pill bg-white position-absolute top-0 end-0 m-3">
            <i class="bi bi-arrow-up text-success me-1"></i>
            <span class="text-dark">12,5%</span>
          </span>
        </div>
      </div>

      <!-- Valor em destaque -->
      <h3 class="text-primary fw-bold mb-0">1200€</h3>
    </div>
  </div>
</div>


   <!-- Card 2 -->
<div class="col-12 col-md-6 col-lg-4">
  <div class="card card-financas">
    <div class="card-body">
      <div class="row d-flex justify-content-between">
        <!-- Título -->
        <div class="col-12 col-md-8">
          <h5 class="card-title">Expectável</h5>
        </div>

        <!-- Percentagem no canto superior direito -->
        <div class="col-12 col-md-4 d-flex align-items-center">
          <span class="d-inline-flex align-items-center px-2 py-1 border rounded-pill bg-white position-absolute top-0 end-0 m-3">
            <i class="bi bi-arrow-down text-danger me-1"></i>
            <span class="text-dark">12,5%</span>
          </span>
        </div>
      </div>

      <!-- Valor em destaque -->
      <h3 class="text-danger fw-bold mb-0">1300€</h3>
    </div>
  </div>
</div>




    <!-- Card 2 -->
    <!--<div class="col-md-4">
      <div class="card shadow-sm p-3">
        <div class="card-body">
          <h5 class="text-muted mb-2">Expectável</h5>
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="text-danger fw-bold mb-0">1300€</h3>
            <span class="d-inline-flex align-items-center px-2 py-1 border rounded-pill bg-white">
              <i class="bi bi-arrow-down text-danger me-1"></i>
              <span class="text-dark">12,5%</span>
            </span>
          </div>
        </div>
      </div>
    </div>-->

    <!-- Card 3 -->
    <div class="col-md-4">
  <div class="card shadow-sm p-3 position-relative">
    <div class="card-body">

      <!-- Botão editar minimalista no canto superior direito -->
      <button type="button" class="edit-btn position-absolute top-0 end-0 m-2"
              data-bs-toggle="modal" data-bs-target="#editModal">
        <i class="bi bi-pencil-fill"></i>
      </button>

      <h5 class="text-muted mb-2">Objetivo</h5>
      <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-success fw-bold mb-0">2000€</h3>

        <!-- Barra circular -->
        <div class="circular-progress" style="--value:40;">
          <span>40%</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Estático -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Editar Objetivo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="valorObjetivo" class="form-label">Valor do objetivo (€)</label>
            <input type="number" class="form-control" id="valorObjetivo" value="2000">
          </div>
          <div class="mb-3">
            <label for="percentagem" class="form-label">Percentagem (%)</label>
            <input type="number" class="form-control" id="percentagem" value="40">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Guardar</button>
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
      <div class="card shadow-sm p-3">
        <div class="card-body">
          <h5 class="text-muted mb-2">Ganhos por Instituição</h5>

          <!-- Placeholder do gráfico -->
          <div class="d-flex justify-content-center align-items-center" style="height: 180px;">
            <div class="text-muted small">[Gráfico aqui futuramente]</div>
          </div>

          <!-- Legenda -->
          <ul class="list-unstyled mt-3 small">
            <li class="d-flex align-items-center mb-2">
              <span class="badge rounded-circle me-2" style="background-color:#a78bfa;">&nbsp;</span>
              <span class="text-secondary">CESAE</span>
              <span class="ms-auto fw-bold text-dark">41,35%</span>
            </li>
            <li class="d-flex align-items-center mb-2">
              <span class="badge rounded-circle me-2" style="background-color:#ef4444;">&nbsp;</span>
              <span class="text-secondary">LSD</span>
              <span class="ms-auto fw-bold text-dark">21,51%</span>
            </li>
            <li class="d-flex align-items-center mb-2">
              <span class="badge rounded-circle me-2" style="background-color:#3b82f6;">&nbsp;</span>
              <span class="text-secondary">ISTEC</span>
              <span class="ms-auto fw-bold text-dark">13,47%</span>
            </li>
            <li class="d-flex align-items-center mb-2">
              <span class="badge rounded-circle me-2" style="background-color:#22c55e;">&nbsp;</span>
              <span class="text-secondary">ISLA</span>
              <span class="ms-auto fw-bold text-dark">9,97%</span>
            </li>
            <li class="d-flex align-items-center">
              <span class="badge rounded-circle me-2" style="background-color:#4338ca;">&nbsp;</span>
              <span class="text-secondary">ESTEL</span>
              <span class="ms-auto fw-bold text-dark">3,35%</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Coluna 2: Recibos -->
    <div class="col-md-8">
      <div class="card shadow-sm p-3">
        <div class="card-body">
          <h5 class="text-muted mb-3">Recibos</h5>
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
              <tbody>
                <tr>
                  <td><span class="badge rounded-circle me-2" style="background-color:#a78bfa;">&nbsp;</span>CESAE</td>
                  <td class="text-end text-success fw-bold">Recibo Enviado</td>
                  <td class="text-end text-secondary">2024/04/01</td>
                  <td class="text-end fw-bold text-dark">500€</td>
                  <td class="text-end"><i class="bi bi-three-dots-vertical"></i></td>
                </tr>
                <tr>
                  <td><span class="badge rounded-circle me-2" style="background-color:#ef4444;">&nbsp;</span>LSD</td>
                  <td class="text-end text-danger fw-bold">Recibo por Enviar</td>
                  <td class="text-end text-secondary">2024/04/01</td>
                  <td class="text-end fw-bold text-dark">500€</td>
                  <td class="text-end"><i class="bi bi-three-dots-vertical"></i></td>
                </tr>
                <tr>
                  <td><span class="badge rounded-circle me-2" style="background-color:#3b82f6;">&nbsp;</span>ISTEC</td>
                  <td class="text-end text-success fw-bold">Recibo Enviado</td>
                  <td class="text-end text-secondary">2024/04/01</td>
                  <td class="text-end fw-bold text-dark">500€</td>
                  <td class="text-end"><i class="bi bi-three-dots-vertical"></i></td>
                </tr>
                <tr>
                  <td><span class="badge rounded-circle me-2" style="background-color:#22c55e;">&nbsp;</span>ISLA</td>
                  <td class="text-end text-success fw-bold">Recibo Enviado</td>
                  <td class="text-end text-secondary">2024/04/01</td>
                  <td class="text-end fw-bold text-dark">500€</td>
                  <td class="text-end"><i class="bi bi-three-dots-vertical"></i></td>
                </tr>
                <tr>
                  <td><span class="badge rounded-circle me-2" style="background-color:#4338ca;">&nbsp;</span>ESTEL</td>
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
</div>


</div>
</div>
@endsection
