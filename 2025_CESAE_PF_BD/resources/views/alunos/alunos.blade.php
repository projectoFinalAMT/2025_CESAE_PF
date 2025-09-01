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
                          <button class="btn btn-light btn-sm" type="button">Adicionar aluno</button>

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

                          <button class="btn btn-link btn-sm" id="btnLimpar">Limpar</button>
                        </div>
                      </th>
                    </tr>

                    <!-- Cabeçalhos das colunas (ficam no THEAD, não no TBODY) -->
                    <tr>
                      <th scope="col">id</th>
                      <th scope="col">Nome</th>
                      <th scope="col">email</th>
                      <th scope="col">Notas</th>
                      <th scope="col">Média</th>
                      <th scope="col">Acções</th>
                    </tr>
                  </thead>

                  <tbody>
                    <!-- EXEMPLOS com data-instituicao e data-curso -->
                    <tr data-instituicao="Cesae" data-curso="SD">
                      <th scope="row">1</th>
                      <td>Mark</td>
                      <td>mark@exemplo.com</td>
                      <td>14</td>
                      <td>14,0</td>
                      <td>@mdo</td>
                    </tr>
                    <tr data-instituicao="ISAG" data-curso="AU">
                      <th scope="row">2</th>
                      <td>Jacob</td>
                      <td>jacob@exemplo.com</td>
                      <td>16</td>
                      <td>15,2</td>
                      <td>@mdo</td>
                    </tr>
                    <tr data-instituicao="ISTAC" data-curso="ASF">
                      <th scope="row">3</th>
                      <td>John</td>
                      <td>john@exemplo.com</td>
                      <td>12</td>
                      <td>12,3</td>
                      <td>@mdo</td>
                    </tr>
                    <tr data-instituicao="POLS" data-curso="SAF">
                      <th scope="row">4</th>
                      <td>Ana</td>
                      <td>ana@exemplo.com</td>
                      <td>17</td>
                      <td>16,8</td>
                      <td>@mdo</td>
                    </tr>
                  </tbody>
                </table>

              </div>
            </div>
            @endsection




