


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
 <!-- TABELA ALUNOS -->
 <table class="table table-hover mt-5" id="tabelaAlunos">
    <thead>
      <!-- Linha de controlos -->
      <tr>
        <th scope="col" colspan="6">
          <div class="d-flex flex-wrap gap-2 align-items-center">
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

      <!-- Cabeçalhos das colunas -->
      <tr>
        <th scope="col">Nr</th>
        <th scope="col">Nome</th>
        <th scope="col">Momentos Avaliação 1</th>
        <th scope="col">Momentos Avaliação 2</th>
        <th scope="col">Momentos Avaliação 3</th>
        <th scope="col">Momentos Avaliação 4</th>
        <th scope="col">Média</th>
        <th scope="col">Observações</th>
        <th scope="col">Acções</th>
      </tr>


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
          <td>@mdo</td>
          <td></td>
          <td><button class="btn btn-sm btn-primary">Editar</button></td>



        </tr>
      @endforeach


    </tbody>
  </table>

  @section('scripts')
  <script src="{{ asset('js/alunos.js') }}"></script>


            @endsection
            @endsection

