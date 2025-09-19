@extends('layouts.fe_master')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- css interno -->
    <link rel="stylesheet" href="{{ asset('css/dashboard_css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modulos_home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/documentos_home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alunos.css') }}">

    @endsection




@section('content')

    <div class="content">

        <div class="container my-4">

            <!-- Título -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Alunos</h2>
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
                            <p class="card-text fw-bold fs-3">{{$listaAlunos->count()}}</p>
                            <div class="d-flex justify-content-between px-3">
                                <span class="card-text">{{$novosAlunos}} novos</span>
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
                      <th scope="col" colspan="8" id="controlCol">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <button
                            class="btn btn-light btn-sm"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#alunoModal">
                            Adicionar aluno
                          </button>

                          <input type="text" class="form-control form-control-sm" style="max-width:200px"
                                 placeholder="Pesquisar por nome ou email..." id="pesquisaAlunos">

                          <!-- Dropdown: Instituição -->
                          <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fa-solid fa-filter"></i> Instituição
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" id="filterDropdownInst">
                                @foreach ($instituicoes as $inst )
                                <li><a class="dropdown-item " href="#" data-valor="">{{$inst->nomeInstituicao}}</a></li>
                                @endforeach
                            </ul>
                          </div>

                          <!-- Dropdown: Curso -->
                          <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fa-solid fa-filter"></i> Curso
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" id="filterDropdownCurs">
                                @foreach ($cursos as $curso )
                                <li><a class="dropdown-item" href="#" data-valor="">{{$curso->titulo}}</a></li>
                                @endforeach
                            </ul>
                          </div>
                           <!-- Dropdown: Modulos -->
                           <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fa-solid fa-filter"></i> Módulos
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" id="filterDropdownInst">
                                @foreach ($modulos as $modulo )
                                <li><a class="dropdown-item" href="#" data-valor="">{{$modulo->nomeModulo}}</a></li>
                                @endforeach
                            </ul>
                            <button type="button" class="ms-3 btn btn-success">Atualizar</button>
                          </div>
                        </div>
                      </th>
                    </tr>

                    <!-- Cabeçalhos das colunas -->
                    <tr>
                      <th scope="col">Nr</th>
                     <th scope="col">Nome</th>
                      <th scope="col" class="col-avaliacao" data-index="1" >Avaliação 1 </th>
                      <th scope="col" class="col-avaliacao d-none" data-index="2" >Avaliação 2</th>
                      <th scope="col" class="col-avaliacao d-none" data-index="3"  >Avaliação 3</th>
                      <th scope="col" class="col-avaliacao d-none" data-index="4"  >Avaliação 4</th>
                      <th scope="col">Média</th>
                      <th scope="col">Presença</th>
                      <th scope="col">Participação</th>
                      <th scope="col">Pontualidade</th>
                      <th scope="col">Observações</th>
                      <th scope="col">Acções</th>
                    </tr>
                    <tr>
                        <th scope="col"></th>
                       <th scope="col"></th>
                        <th scope="col" class="col-avaliacao" data-index="1" ><button type="button" class=""  id="btnAddAvaliacao"> + </button></th>
                        <th scope="col" class="col-avaliacao d-none" data-index="2" >Avaliação 2</th>
                        <th scope="col" class="col-avaliacao d-none" data-index="3"  >Avaliação 3</th>
                        <th scope="col" class="col-avaliacao d-none" data-index="4"  >Avaliação 4</th>
                        <th scope="col"></th>
                        <th scope="col">smiles</th>
                        <th scope="col">smiles</th>
                        <th scope="col">smiles</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                      </tr>
                  </thead>

                  <tbody>
                    @foreach ($listaAlunos as $listaAluno )
                    <tr data-instituicao="" data-curso="">
                        <th scope="row">{{$listaAluno->id}}</th>
                        <td>{{$listaAluno->nome}}</td>
                        <td class="col-avaliacao" data-idx="1"><input class="form-control form-control-sm input-avaliacao" type="number"></td>
                        <td class="col-avaliacao d-none" data-idx="2" ><input class="form-control form-control-sm input-avaliacao" type="number"></td>
                        <td class="col-avaliacao d-none" data-idx="3" ><input class="form-control form-control-sm input-avaliacao" type="number"></td>
                        <td class="col-avaliacao d-none" data-idx="4" ><input class="form-control form-control-sm input-avaliacao" type="number"></td>
                        <td><input class="mediaAluno form-control form-control-sm" type="number" value="" readonly></td>
                        <td><input class="form-control form-control-sm" type="number" min="0" step="1"></td>
                        <td><input class="form-control form-control-sm" type="number" min="0" step="1"></td>
                        <td><input class="form-control form-control-sm" type="number" min="0" step="1"></td>
                        <td>
                            <textarea class="form-control form-control-sm" rows="3" style="resize: none;"></textarea>
                          </td>
                        <td><button onclick="calculomedia()" type="button" class="btn btn-outline-primary">Ver Aluno</button></td>
                      </tr>
                    @endforeach
                  </tbody>

                </table>

              </div>
            </div>


  @include('componentes.perfil.perfil')
  @include('componentes.alunos.alunos-modal')

  @section('scripts')
  <script src="{{ asset('js/alunos.js') }}"></script>


            @endsection
            @endsection




