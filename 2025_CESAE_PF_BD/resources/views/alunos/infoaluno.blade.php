


    @extends('layouts.fe_master')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- css bootstrap -->
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
        <div class="card shadow rounded-0">
          <div class="card-header">
            <h5 class="card-title mb-0">Informação do Aluno</h5>
            <small class="card-subtitle fw-light">nome aluno</small>
          </div>

          <form id="alunoForm" method="GET" action="">
            @csrf
            <div class="card-body">
              <div class="row g-3 mb-3">
                <!-- Nome -->
                <div class="col-md-6">
                  <label for="nome" class="form-label">Nome aluno*</label>
                  <input type="text" class="form-control rounded-0" id="nome" name="nome" >
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
                          size="4"
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
                          size="4"
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
                          size="4"
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


               

            <div class="card-footer text-end">
              <button type="reset" class="btn btn-secondary rounded-0">Cancelar</button>
              <button type="submit" class="btn btn-primary rounded-0">Guardar</button>
            </div>
          </form>

        </div>
      </div>







  <div class="informacaoAluno">
    <div class="nomeAluno"></div>
    <div class="emailAluno"></div>
    <div class="telefone"></div>
    <div class="tabelaNotas"></div>
  </div>

    @include('componentes.perfil.perfil')
  @section('scripts')
  <script src="{{ asset('js/alunos.js') }}"></script>


            @endsection
            @endsection

