@extends('layouts.fe_master')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- css bootstrap -->
    <!-- css interno -->
    <link rel="stylesheet" href="{{ asset('css/dashboard_css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modulos_home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/documentos_home.css') }}">
    @endsection




@section('content')

    <div class="content">

        <div class="container my-4">

            <!-- Título -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Alunos</h2>
                <input type="text" class="form-control  w-auto ms-auto" placeholder="Pesquisar em alunos..."
                    id="pesquisa-dashboard">
                {{-- ms-auto → margem à esquerda automática, empurra o input para o final da linha.
w-auto → limita a largura da barra de pesquisa, não ocupando todo o espaço. --}}
            </div>

            <!-- Grid dos card -->
            <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="row d-flex justify-content-between">
                                <div class="col d-flex align-items-center">
                                    <h5 class="titlecard mb-0">
                                        Alunos Totais <i class="fa-solid fa-user"></i>
                                    </h5>
                                </div>
                            </div>
                            <p class="card-text fw-bold fs-3">0</p>
                            <div class="d-flex justify-content-between px-3">
                                <span class="card-text">0 novos</span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="row d-flex justify-content-between">
                                <div class="col d-flex align-items-center">
                                    <h5 class="titlecard mb-0">
                                        Média notas alunos <i class="fa-solid fa-scale-balanced"></i>
                                    </h5>
                                </div>
                            </div>
                            <p class="card-text fw-bold fs-3">0</p>
                            <div class="d-flex justify-content-between px-3">
                                <span class="card-text">0 novos</span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="row d-flex justify-content-between">
                                <div class="col d-flex align-items-center">
                                    <h5 class="titlecard mb-0">
                                        Melhor média <i class="fa-solid fa-arrow-up"></i>
                                    </h5>
                                </div>
                            </div>
                            <p class="card-text fw-bold fs-3">0</p>
                            <div class="d-flex justify-content-between px-3">
                                <span class="card-text">0% melhor vs mês passado</span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-12 col-md-6 col-lg-3 ">
                    <div class="card card-info ">
                        <div class="card-body ">
                            <div class="row d-flex justify-content-between">
                                <div class="col d-flex align-items-center">
                                    <h5 class="titlecard mb-0">
                                        Pior média <i class="fa-solid fa-arrow-down"></i>
                                    </h5>
                                </div>
                            </div>
                            <p class="card-text fw-bold fs-3">0</p>
                            <div class="d-flex justify-content-between px-3">
                                <span class="card-text">0% melhor vs mês passado</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="container my-4">





                <!-- TABELA ALUNOS -->
                <table class="table table-hover mt-5" id="tabelaAlunos">
                  <thead>
                    <!-- Linha de controlos -->
                    <tr>
                      <th scope="col" colspan="6">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <button
                            class="btn btn-light btn-sm"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#alunoModal">
                            Adicionar aluno
                          </button>


                          <input type="text" class="form-control form-control-sm" style="max-width:280px"
                                 placeholder="Pesquisar por nome ou email..." id="pesquisaAlunos">

                          <!-- Dropdown: Instituição -->
                          <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fa-solid fa-filter"></i> Instituição
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" id="filterDropdownInst">
                              <li><a class="dropdown-item active" href="#" data-valor="">Todas</a></li>
                              <li><a class="dropdown-item" href="#" data-valor="Cesae">Cesae</a></li>
                              <li><a class="dropdown-item" href="#" data-valor="ISAG">ISAG</a></li>
                              <li><a class="dropdown-item" href="#" data-valor="ISTAC">ISTAC</a></li>
                              <li><a class="dropdown-item" href="#" data-valor="POLS">POLS</a></li>
                            </ul>
                          </div>

                          <!-- Dropdown: Curso -->
                          <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fa-solid fa-filter"></i> Curso
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" id="filterDropdownCurs">
                              <li><a class="dropdown-item active" href="#" data-valor="">Todos</a></li>
                              <li><a class="dropdown-item" href="#" data-valor="SD">SD</a></li>
                              <li><a class="dropdown-item" href="#" data-valor="AU">AU</a></li>
                              <li><a class="dropdown-item" href="#" data-valor="ASF">ASF</a></li>
                              <li><a class="dropdown-item" href="#" data-valor="SAF">SAF</a></li>
                            </ul>
                          </div>

                           <!-- Dropdown: Instituição -->
                           <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fa-solid fa-filter"></i> Módulos
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" id="filterDropdownInst">
                              <li><a class="dropdown-item active" href="#" data-valor="">Todas</a></li>
                              <li><a class="dropdown-item" href="#" data-valor="Cesae">Cesae</a></li>
                              <li><a class="dropdown-item" href="#" data-valor="ISAG">ISAG</a></li>
                              <li><a class="dropdown-item" href="#" data-valor="ISTAC">ISTAC</a></li>
                              <li><a class="dropdown-item" href="#" data-valor="POLS">POLS</a></li>
                            </ul>
                          </div>

                        </div>
                      </th>
                    </tr>

                    <!-- Cabeçalhos das colunas (ficam no THEAD, não no TBODY) -->
                    <tr>
                      <th scope="col">Nr</th>
                      <th scope="col">Nome</th>
                      <th scope="col">Momentos Avaliação</th>
                      <th scope="col">Notas</th>
                      <th scope="col">Média</th>
                      <th scope="col">Acções</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach ($alunos as $aluno )
                    <tr data-instituicao="" data-curso="">
                        <th scope="row">{{$aluno->id}}</th>
                        <td>{{$aluno->nome}}</td>
                        <td>{{$aluno->email}}</td>
                        <td>{{$aluno->observacoes}}</td>
                        <td></td>
                        <td>@mdo</td>
                      </tr>
                    @endforeach


                  </tbody>
                </table>

              </div>
            </div>

<!-- Modal: Adicionar Aluno -->
<div class="modal fade" id="alunoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content rounded-0 shadow">
        <div class="modal-header">
          <div class="col-12 col-md-8">
            <h5 class="modal-title">Adicionar novo aluno</h5>
            <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form id="alunoForm" method="POST" action="{{ route('alunos.store') }}">
          @csrf
          <div class="modal-body">
            <div class="row g-3 mb-3">
              <!-- Nome -->
              <div class="col-md-6">
                <label for="nome" class="form-label">Nome aluno*</label>
                <input type="text" class="form-control rounded-0" id="nome" name="nome" required>
              </div>

              <!-- Email -->
              <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control rounded-0" id="email" name="email">
              </div>

              <!-- Telemóvel -->
              <div class="col-md-6">
                <label for="telefone" class="form-label">Telemóvel</label>
                <input type="text" class="form-control rounded-0" id="telefone" name="telefone">
              </div>

              <!-- Instituições (multi) -->
              <div class="col-md-6">
                <label for="instituicao_ids" class="form-label">Instituições*</label>
                <select class="form-control"
                        id="instituicao_ids"
                        name="instituicao_ids[]"
                        multiple
                        size="6"
                        required>
                  @foreach($instituicoes ?? [] as $inst)
                    <option value="{{ $inst->id }}">{{ $inst->nomeInstituicao }}</option>
                  @endforeach
                </select>
                <small class="text-muted">Segura Ctrl/⌘ para escolher várias.</small>
              </div>

              <!-- Cursos (multi, dependente das instituições) -->
              <div class="col-md-6">
                <label for="curso_ids" class="form-label">Cursos*</label>
                <select class="form-control"
                        id="curso_ids"
                        name="curso_ids[]"
                        multiple
                        size="6"
                        required
                        disabled>
                </select>
                <small class="text-muted">Escolhe primeiro as instituições.</small>
              </div>

              <!-- Módulos (multi, dependente dos cursos) -->
              <div class="col-md-6">
                <label for="modulo_ids" class="form-label">Módulos*</label>
                <select class="form-control"
                        id="modulo_ids"
                        name="modulo_ids[]"
                        multiple
                        size="6"
                        required
                        disabled>
                </select>
                <small class="text-muted">Escolhe primeiro os cursos.</small>
              </div>

              <!-- Observações -->
              <div class="col-12">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control rounded-0" id="observacoes" name="observacoes" rows="3"></textarea>
              </div>
            </div>

            <div id="alunoErro" class="text-danger" style="display:none;"></div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary rounded-0">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  @section('scripts')
  <script src="{{ asset('js/alunos.js') }}"></script>


            @endsection
            @endsection




