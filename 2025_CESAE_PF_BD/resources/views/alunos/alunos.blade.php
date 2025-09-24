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
                  Alunos Totais <i class="fa-solid fa-user " style="color:#324c45;"></i>
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
                  Média notas alunos <i class="fa-solid fa-scale-balanced" style="color:#324c45;"></i>
                </h5>
              </div>
            </div>
            <p class="card-text fw-bold fs-3">{{$mediaDasMedias}}</p>
            <div class="d-flex justify-content-between px-3">
              <span class="card-text"></span>
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
                  Melhor média <i class="fa-solid fa-arrow-up text-success"></i>
                </h5>
              </div>
            </div>
            <p class="card-text fw-bold fs-3">{{$maiorMedia}}</p>
            <div class="d-flex justify-content-between px-3">
              <span class="card-text"></span>
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
                  Pior média <i class="fa-solid fa-arrow-down text-danger"></i>
                </h5>
              </div>
            </div>
            <p class="card-text fw-bold fs-3">{{$piorMedia}}</p>
            <div class="d-flex justify-content-between px-3">
              <span class="card-text"></span>
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

                <input id="pesquisaAluno" type="text" class="form-control form-control-sm input" style="max-width:200px"
                       placeholder="Pesquisar por nome aluno...">

                <!-- Dropdown: Módulos -->
                <div class="dropdown">
                    <button id="btnFilterModulos" class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa-solid fa-filter"></i> Módulos
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" id="filterDropdownModulos">
                      <li>
                        <a class="dropdown-item fw-semibold" href="#" data-clear="1">Limpar filtros</a> <!-- opcional -->
                      </li>
                      @foreach ($modulos as $modulo)
                        <li>
                          <a class="dropdown-item" href="#" data-modulo-id="{{ $modulo->id }}">
                            {{ $modulo->nomeModulo.' ('.$modulo->titulo.' - '.$modulo->nomeInstituicao.')' }}
                          </a>
                        </li>

                      @endforeach
                    </ul>
                  </div>



    <button id="btnAtualizar" type="button" class="btn btn-light btn-sm text-success">Atualizar</button>

              </div>
            </th>
          </tr>

          <!-- Cabeçalhos das colunas -->
          <tr>
            <th scope="col">Nr</th>
            <th scope="col">Nome</th>

            <!-- Avaliação 1 fixa + botões -->
            <th scope="col" class="th-avaliacao" id="eval1-th">
                <button id="addEval" type="button" class="btn btn-light btn-sm" style="margin-left:6px;">+</button>
              <button id="removeEval" type="button" class="btn btn-light btn-sm" style="margin-right:6px;">−</button>
              Avaliação 1

            </th>

            <!-- As novas colunas entram ANTES da Média -->
            <th scope="col" id="th-media">Média</th>
            <th scope="col">Email</th>
            <th scope="col">Observações</th>
            <th scope="col">Acções</th>
          </tr>
        </thead>

        <tbody id="gridAlunos">
          @foreach ($infoAluno as $aluno)
          <tr data-instituicao="" data-curso="" data-modulo-id="{{ $aluno->modulo_id }}" data-aluno-id="{{ $aluno->id }}">
            <th scope="row">{{ $aluno->id }}</th>
              <td class="card-title aluno-nome">{{ $aluno->nome }}</td>

              <!-- Avaliação 1 já com input -->
              <td class="td-avaliacao" style="text-align:center;">
                <input class="form-control form-control-sm input-avaliacao"
                       type="number"
                       name="avaliacoes[{{ $aluno->id }}][]">
              </td>

              <!-- TDs dinâmicas serão inseridas aqui (antes da td-media) -->

              <td class="td-media" style="text-align:center;">{{ $aluno->notaAluno }}</td>
              <td class="aluno-email">{{ $aluno->email }}</td>

              <td>
                <textarea class="form-control form-control-sm" rows="3" style="resize:none;" readonly placeholder="{{$aluno->observacoes}}"></textarea>
              </td>

              <td>


                <button
                  class="btn btn-light btn-sm"
                  data-bs-toggle="modal"
                  data-bs-target="#infoAlunoModal"
                  data-id="{{ $aluno->id }}"
                  data-nome="{{ e($aluno->nome) }}"
                  data-email="{{ e($aluno->email) }}"
                  data-telefone="{{ e($aluno->telefone) }}"
                  data-observacoes="{{ e($aluno->observacoes) }}"
                >Ver/Editar</button>


                  <button type="submit" class="btn btn-light btn-sm" data-bs-toggle="modal"
                  data-bs-target="#confirmarEliminarAluno" data-id="{{ $aluno->id }}"><i class="fa-solid fa-trash " ></i></button>
                  @include('componentes.alunos.eliminar-alunos')

           </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <!-- Templates para gerar colunas dinâmicas -->
      <template id="tpl-eval-th">
        <th class="th-avaliacao th-avaliacao-dyn">Avaliação <span class="eval-index"></span></th>
      </template>

      <template id="tpl-eval-td">
        <td class="td-avaliacao td-avaliacao-dyn" style="text-align:center;">
          <input class="form-control form-control-sm input-avaliacao" type="number">
        </td>
      </template>

    </div>
  </div>

  @include('componentes.perfil.perfil')
  @include('componentes.alunos.alunos-modal')
  @include('componentes.alunos.infoalunos-modal')



  @endsection

  @section('scripts')
    <script src="{{ asset('js/alunos.js') }}"></script>
  @endsection
