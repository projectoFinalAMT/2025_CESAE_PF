@extends('layouts.fe_master')
@section('css')
<link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
@endsection
@section('scripts')
<script src="{{ asset('js/cursos.js') }}" defer></script>
<script src="{{ asset('js/documentos.js') }}" defer></script>
@endsection
@section('content')
<div class="content">
<div class="container my-4">
    <!-- Toast de sucesso -->
@if(session('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
    <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
        </div>
    </div>
</div>
@endif
  <!-- Título -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Cursos</h2>
    <input type="text" class="form-control w-auto ms-auto" placeholder="Pesquisar Curso..." id="pesquisa-cursos">
</div>
<!-- Botão Novo Curso -->
<div class="mb-4">
     <button class="btn btn-novo-curso" data-bs-toggle="modal" data-bs-target="#novoCursoModal">+ Novo Curso</button>
</div>

<!-- Modal Novo Curso -->
<div class="modal fade" id="novoCursoModal" tabindex="-1" aria-labelledby="novoCursoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-12 col-md-8">
            <h5 class="modal-title" id="novoCursoModalLabel">Adicionar novo Curso</h5>
            <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
        </div>
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('curso.store') }}" method="POST">
          @csrf

          <!-- Nome do Curso -->
          <div class="mb-3">
            <label for="nome" class="form-label">Nome do Curso*</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
          </div>

          <!-- Instituição -->
          <div class="mb-3">
            <label for="instituicao" class="form-label">Instituição*</label>
            <select class="form-control" id="instituicao" name="instituicao" required>
                <option value="" selected disabled>Selecione uma instituição</option>
                @foreach($instituicoes as $inst)
                    <option value="{{ $inst->id }}">{{ $inst->nomeInstituicao }}</option>
                @endforeach
            </select>
            <div class="d-flex justify-content-end mt-1">
                <button type="button" class="btn btn-sm btn-novo-curso" data-bs-toggle="modal" data-bs-target="#novaInstituicaoModal">
                    <i class="bi bi-building-fill"></i> Cadastrar Nova Instituição
                </button>
            </div>
          </div>

          <!-- Datas -->
          <div class="row g-3 mb-3">
            <div class="col">
              <label for="data_inicio" class="form-label">Data início*</label>
              <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
            </div>
            <div class="col">
              <label for="data_fim" class="form-label">Data fim</label>
              <input type="date" class="form-control" id="data_fim" name="data_fim">
            </div>
          </div>

          <!-- Total horas e Preço por hora -->
          <div class="row g-3 mb-3">
            <div class="col">
              <label for="total_horas" class="form-label">Total horas*</label>
              <input type="number" step="0.01" class="form-control" id="total_horas" name="total_horas" required>
            </div>
            <div class="col">
              <label for="preco_hora" class="form-label">Preço hora*</label>
              <div class="input-group">
                <input type="number" step="0.01" class="form-control" id="preco_hora" name="preco_hora" required>
                <span class="input-group-text">€</span>
              </div>
            </div>
          </div>

          <!-- Descrição -->
          <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descrição" name="descrição" rows="3"></textarea>
          </div>

          <!-- Botões adicionais -->
          <div class="d-flex gap-2 mb-3">
            <button type="button" class="btn btn-novo-curso"><i class="bi bi-people-fill"></i> Adicionar Alunos</button>
            <button type="button" class="btn btn-novo-curso"><i class="bi bi-journal-bookmark-fill"></i> Adicionar Módulos</button>
          </div>

          <!-- Botão submit -->
          <div class="text-center">
            <button type="submit" class="btn btn-novo-curso">
                Gravar Curso <i class="bi bi-check-lg text-success"></i>
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Nova Instituicao -->
<div class="modal fade" id="novaInstituicaoModal" tabindex="-1" aria-labelledby="novaInstituicaoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-12 col-md-8">
          <h5 class="modal-title" id="novaInstituicaoModalLabel">Cadastrar Nova Instituição</h5>
          <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>

      <div class="modal-body">
        <!-- Ajustado -->
        <form id="formInstituicao" method="POST" action="{{ route('instituicoes.store') }}">
          @csrf
         <input type="hidden" name="redirect_to" value="cursos">
          <!-- Nome da Instituição -->
          <div class="mb-3">
            <label for="nome_instituicao" class="form-label">Nome da Instituição*</label>
            <input type="text" class="form-control" id="nome_instituicao" name="nomeInstituicao" required>
          </div>

          <!-- Morada -->
          <div class="mb-3">
            <label for="morada" class="form-label">Morada</label>
            <input type="text" class="form-control" id="morada" name="morada">
          </div>

          <!-- NIF e Telefone -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="nif" class="form-label">NIF</label>
              <input type="text" class="form-control" id="nif" name="NIF">
            </div>
            <div class="col-md-6">
              <label for="telefone" class="form-label">Telefone</label>
              <input type="tel" class="form-control" id="telefone" name="telefoneResponsavel">
            </div>
          </div>

          <!-- Email e Nome do Responsável -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="email" class="form-label">Email*</label>
              <input type="email" class="form-control" id="email" name="emailResponsavel" required>
            </div>
            <div class="col-md-6">
              <label for="nome_responsavel" class="form-label">Nome do Responsável</label>
              <input type="text" class="form-control" id="nome_responsavel" name="nomeResponsavel">
            </div>
          </div>

          <!-- Botão -->
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-novo-curso">
              Gravar Instituição <i class="bi bi-check-lg text-success"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- Modal de confirmação -->
<div class="modal fade" id="confirmarEliminar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminação</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body text-center">
        <p>Tem certeza que deseja eliminar este Curso?</p>
      </div>
      <div class="modal-footer">
        <a href="{{ route('cursos') }}" type="button" class="btn btn-novo-curso">
          Cancelar <i class="bi bi-check-lg text-success"></i>
        </a>

        <form id="formEliminar" method="POST" action="{{ route('curso.deletar') }}">
    @csrf
    <input type="hidden" name="ids" id="idsSelecionados" value="">
     <button type="submit" class="btn btn-novo-curso">
        Eliminar <i class="bi bi-x-lg text-danger"></i>
    </button>
</form>

      </div>
    </div>
  </div>
</div>




  <!-- Grid de cursos -->
@if($cursos->count() > 0)
<div class="row g-4">
    @foreach($cursos as $curso)
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card card-cursos h-100 position-relative">

            <!-- Status ativo/inativo no canto superior direito -->
            <span
    class="status-btn {{ $curso->estado_cursos_id == 1 ? 'ativo' : 'inativo' }} position-absolute top-0 end-0 m-3 btn-novo-curso"
    data-curso-id="{{ $curso->id }}"
    data-estado="{{ $curso->estado_cursos_id }}"
>
    {{ $curso->estado_cursos_id == 1 ? 'ativo' : 'inativo' }}
</span>

            <div class="card-body">
                <div class="row d-flex justify-content-between">
                    <div class="col-12 col-md-8">
                        <h5 class="card-title text-truncate" style="white-space: nowrap; overflow: hidden;">
                        {{ $curso->titulo }}
                        </h5>
                        <h6 class="card-subtitle fw-light mb-4 text-truncate" style="white-space: nowrap; overflow: hidden;">
                        {{ $curso->instituicao->nomeInstituicao ?? 'Sem Instituição' }}
                        </h6>
                    </div>
                </div>

                <p class="card-text fw-light">{{ $curso->descrição ?? 'Descrição não informada' }}</p>

                    @php
                    $totalHoras = $curso->duracaoTotal ?? 0;
                    $horas = floor($totalHoras);
                    $minutos = round(($totalHoras - $horas) * 60);
                    $duracaoFormatada = $horas . 'h' . ($minutos > 0 ? '&nbsp;' . $minutos . 'M' : '');
                    @endphp

                    <div class="d-flex justify-content-between px-2 align-items-center" style="white-space: nowrap; font-size: 0.9rem;">
                        <span class="card-text flex-shrink-1 text-truncate">
                            <i class="bi bi-journal-bookmark-fill"></i> {{ $curso->modulos_count ?? 0 }} Módulos
                        </span>
                        <span class="card-text flex-shrink-1 text-truncate">
                            <i class="bi bi-clock"></i> {!! $duracaoFormatada !!}
                        </span>
                        <span class="card-text flex-shrink-1 text-truncate">
                            <i class="bi bi-people-fill"></i> {{ $curso->alunos_count ?? 0 }} Alunos
                        </span>
            </div>


                <div class="d-flex justify-content-end mt-4">
                    <button class="btn btn-sm btn-novo-curso" data-bs-toggle="modal" data-bs-target="#verDetalhesModal-{{ $curso->id }}">
                        Ver detalhes
                    </button>
                </div>
            </div>
        </div>
    </div>

<!-- Modal de detalhes do curso -->
<div class="modal fade" id="verDetalhesModal-{{ $curso->id }}" tabindex="-1" aria-labelledby="verDetalhesModalLabel-{{ $curso->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verDetalhesModalLabel-{{ $curso->id }}">Detalhes Curso</h5>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Curso*</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="{{ $curso->titulo }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="instituicao" class="form-label">Instituição*</label>
                        <input type="text" class="form-control" id="instituicao" name="instituicao" value="{{ $curso->instituicao->nomeInstituicao ?? 'Sem Instituição' }}" readonly>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="data_inicio" class="form-label">Data início*</label>
                            <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="{{ $curso->dataInicio }}" readonly>
                        </div>
                        <div class="col">
                            <label for="data_fim" class="form-label">Data fim</label>
                            <input type="date" class="form-control" id="data_fim" name="data_fim" value="{{ $curso->dataFim }}" readonly>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="total_horas" class="form-label">Total horas*</label>
                            <input type="text" class="form-control" id="total_horas" name="total_horas" value="{{ $duracaoFormatada }}" readonly>
                        </div>
                        <div class="col">
                            <label for="preco_hora" class="form-label">Preço hora*</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="preco_hora" name="preco_hora" value="{{ $curso->precoHora }}" readonly>
                                <span class="input-group-text">€</span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-8">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3" readonly>{{ $curso->descricao ?? 'Descrição não informada' }}</textarea>
                        </div>
                        <div class="col-4 d-flex flex-column gap-2 justify-content-center btn-adicionar">
                            <a href="" class="btn btn-novo-curso"><i class="bi bi-people-fill"></i> Ver Alunos</a>
                            <a href="" class="btn btn-novo-curso"><i class="bi bi-journal-bookmark-fill"></i> Ver Módulos</a>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-novo-curso" data-bs-target="#editarCursoModal-{{ $curso->id }}" data-bs-toggle="modal" data-bs-dismiss="modal">
                            <i class="bi bi-pencil-fill"></i> Editar Curso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Curso -->
<div class="modal fade" id="editarCursoModal-{{ $curso->id }}" tabindex="-1" aria-labelledby="editarCursoModalLabel-{{ $curso->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-12 col-md-8">
          <h5 class="modal-title" id="editarCursoModalLabel">Editar Curso</h5>
          <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
        </div>
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
        <div class="modal-body">
                <form>
                    @csrf
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Curso*</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="{{ $curso->titulo }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="instituicao" class="form-label">Instituição*</label>
                        <input type="text" class="form-control" id="instituicao" name="instituicao" value="{{ $curso->instituicao->nomeInstituicao ?? 'Sem Instituição' }}" readonly>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="data_inicio" class="form-label">Data início*</label>
                            <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="{{ $curso->dataInicio }}" readonly>
                        </div>
                        <div class="col">
                            <label for="data_fim" class="form-label">Data fim</label>
                            <input type="date" class="form-control" id="data_fim" name="data_fim" value="{{ $curso->dataFim }}" readonly>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="total_horas" class="form-label">Total horas*</label>
                            <input type="text" class="form-control" id="total_horas" name="total_horas" value="{{ $duracaoFormatada }}">
                        </div>
                        <div class="col">
                            <label for="preco_hora" class="form-label">Preço hora*</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="preco_hora" name="preco_hora" value="{{ $curso->precoHora }}">
                                <span class="input-group-text">€</span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-8">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ $curso->descricao ?? 'Descrição não informada' }}</textarea>
                        </div>
                        <div class="col-4 d-flex flex-column gap-2 justify-content-center btn-adicionar">
                            <a href="" class="btn btn-novo-curso"><i class="bi bi-people-fill"></i> Adicionar Alunos</a>
                            <a href="" class="btn btn-novo-curso"><i class="bi bi-journal-bookmark-fill"></i> Adicionar Módulos</a>
                        </div>
                    </div>
          <div class="text-center">
            <button type="submit" class="btn btn-novo-curso">
              Gravar Alterações <i class="bi bi-check-lg text-success"></i>
            </button>
            <button type="button"
        class="btn btn-novo-curso"
        data-id="{{ $curso->id }}"
        data-bs-toggle="modal"
        data-bs-target="#confirmarEliminar">
    Eliminar Curso <i class="bi bi-x-lg text-danger"></i>
</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
</div>
@else
<p class="text-muted">Nenhum curso cadastrado ainda.</p>
@endif





<!-- Modal Perfil -->
<div class="modal fade" id="novoUserModal" tabindex="-1" aria-labelledby="novouserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabeçalho -->
      <div class="modal-header d-flex align-items-center">
        <!-- Foto e nome do perfil à esquerda -->
        <div class="profile text-center me-3">
          <img src="" alt="Foto de perfil" class="rounded-circle mb-2" width="90" height="90">
          <h6 class="mb-0">Nome</h6>
        </div>

        <!-- Título e subtítulo -->
        <div class="flex-grow-1">
          <h5 class="modal-title" id="novoUserModalLabel">O meu Perfil</h5>
          <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
        </div>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>

      <!-- Corpo do modal -->
      <div class="modal-body">
        <form id="formUser">
          @csrf

          <!-- Botões adicionar foto e alterar password lado a lado -->
            <div class="row g-3 mb-3">
                <div class="col d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-novo-curso"><i class="bi bi-people"></i> Adicionar Foto</button>
                    <button type="button" class="btn btn-novo-curso"><i class="bi bi-shield-lock"></i> Alterar Password</button>
                </div>
            </div>

          <!-- Linha 1: Nome -->
          <div class="mb-3">
            <label for="nome_user" class="form-label">Nome Completo*</label>
            <input type="text" class="form-control" id="nome_user" name="nome_user" required>
          </div>

          <!-- Linha 2: Morada -->
          <div class="mb-3">
            <label for="morada" class="form-label">Morada</label>
            <input type="text" class="form-control" id="morada" name="morada">
          </div>

          <!-- Linha 3: Email e Telefone -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="col-md-6">
              <label for="telefone" class="form-label">Telefone</label>
              <input type="tel" class="form-control" id="telefone" name="telefone">
            </div>
          </div>

          <!-- Botão Gravar centralizado -->
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-novo-curso">
              Gravar <i class="bi bi-check-lg text-success"></i>
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>






</div>
@endsection
