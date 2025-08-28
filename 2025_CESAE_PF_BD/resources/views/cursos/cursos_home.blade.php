@extends('layouts.fe_master')
@section('css')
<link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
@endsection
@section('content')
<div class="content">
<div class="container my-4">
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
        <form action="" method="">
          @csrf
          <div class="mb-3">
            <label for="nome" class="form-label">Nome do Curso*</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
          </div>
          <div class="mb-3">
            <label for="instituicao" class="form-label">Instituição*</label>
            <input type="text" class="form-control" id="instituicao" name="instituicao" required>
          </div>
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
          <div class="row g-3 mb-3">
            <div class="col-8">
              <label for="descricao" class="form-label">Descrição</label>
              <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
            </div>
            <div class="col-4 d-flex flex-column gap-2 justify-content-center btn-adicionar">
              <button type="button" class="btn btn-novo-curso"><i class="bi bi-people-fill"></i> Adicionar Alunos</button>
              <button type="button" class="btn btn-novo-curso"><i class="bi bi-journal-bookmark-fill"></i> Adicionar Módulos</button>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-novo-curso">Gravar Curso <i class="bi bi-check-lg text-success"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ver Detalhes Curso -->
<div class="modal fade" id="verDetalhesModal" tabindex="-1" aria-labelledby="verDetalhesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="verDetalhesModalLabel">Detalhes Curso</h5>
          <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form>
          @csrf
          <div class="mb-3">
            <label for="nome" class="form-label">Nome do Curso*</label>
            <input type="text" class="form-control" id="nome" name="nome" value="Curso Exemplo" readonly>
          </div>
          <div class="mb-3">
            <label for="instituicao" class="form-label">Instituição*</label>
            <input type="text" class="form-control" id="instituicao" name="instituicao" value="Instituição Exemplo" readonly>
          </div>
          <div class="row g-3 mb-3">
            <div class="col">
              <label for="data_inicio" class="form-label">Data início*</label>
              <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="2025-01-01" readonly>
            </div>
            <div class="col">
              <label for="data_fim" class="form-label">Data fim</label>
              <input type="date" class="form-control" id="data_fim" name="data_fim" value="2025-06-30" readonly>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col">
              <label for="total_horas" class="form-label">Total horas*</label>
              <input type="number" step="0.01" class="form-control" id="total_horas" name="total_horas" value="120" readonly>
            </div>
            <div class="col">
              <label for="preco_hora" class="form-label">Preço hora*</label>
              <div class="input-group">
                <input type="number" step="0.01" class="form-control" id="preco_hora" name="preco_hora" value="15" readonly>
                <span class="input-group-text">€</span>
              </div>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-8">
              <label for="descricao" class="form-label">Descrição</label>
              <textarea class="form-control" id="descricao" name="descricao" rows="3" readonly>Este é um curso de exemplo apenas para visualização.</textarea>
            </div>
            <div class="col-4 d-flex flex-column gap-2 justify-content-center btn-adicionar">
              <a href="" class="btn btn-novo-curso"><i class="bi bi-people-fill"></i> Ver Alunos</a>
              <a href="" class="btn btn-novo-curso"><i class="bi bi-journal-bookmark-fill"></i> Ver Módulos</a>
            </div>
          </div>
          <div class="text-center">
            <button type="button" class="btn btn-novo-curso" data-bs-target="#editarCursoModal" data-bs-toggle="modal" data-bs-dismiss="modal">
              <i class="bi bi-pencil-fill"></i> Editar Curso
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Curso -->
<div class="modal fade" id="editarCursoModal" tabindex="-1" aria-labelledby="editarCursoModalLabel" aria-hidden="true">
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
        <form action="" method="">
          @csrf
          <div class="mb-3">
            <label for="nome_edit" class="form-label">Nome do Curso*</label>
            <input type="text" class="form-control" id="nome_edit" name="nome" value="Curso Exemplo" required>
          </div>
          <div class="mb-3">
            <label for="instituicao_edit" class="form-label">Instituição*</label>
            <input type="text" class="form-control" id="instituicao_edit" name="instituicao" value="Instituição Exemplo" required>
          </div>
          <div class="row g-3 mb-3">
            <div class="col">
              <label for="data_inicio_edit" class="form-label">Data início*</label>
              <input type="date" class="form-control" id="data_inicio_edit" name="data_inicio" value="2025-01-01" required>
            </div>
            <div class="col">
              <label for="data_fim_edit" class="form-label">Data fim</label>
              <input type="date" class="form-control" id="data_fim_edit" name="data_fim" value="2025-06-30">
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col">
              <label for="total_horas_edit" class="form-label">Total horas*</label>
              <input type="number" step="0.01" class="form-control" id="total_horas_edit" name="total_horas" value="120" required>
            </div>
            <div class="col">
              <label for="preco_hora_edit" class="form-label">Preço hora*</label>
              <div class="input-group">
                <input type="number" step="0.01" class="form-control" id="preco_hora_edit" name="preco_hora" value="15" required>
                <span class="input-group-text">€</span>
              </div>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-8">
              <label for="descricao_edit" class="form-label">Descrição</label>
              <textarea class="form-control" id="descricao_edit" name="descricao" rows="3">Este é um curso de exemplo que agora pode ser editado.</textarea>
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
            <button type="button" class="btn btn-novo-curso" data-bs-toggle="modal" data-bs-target="#confirmarEliminar">
              Eliminar Curso <i class="bi bi-x-lg text-danger"></i>
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
        <p>Tem certeza que deseja eliminar este curso?</p>
      </div>
      <div class="modal-footer">
        <a href="{{ route('cursos') }}" type="button" class="btn btn-novo-curso">Cancelar <i class="bi bi-check-lg text-success"></i></a>
        <button type="submit" class="btn btn-novo-curso">Eliminar  <i class="bi bi-x-lg text-danger"></i></button>
      </div>
    </div>
  </div>
</div>



  <!-- Grid de cursos -->
  <div class="row g-4">
    <!-- Card 1 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card card-cursos">
        <div class="card-body">
            <div class="row d-flex justify-content-between" >
                <div class="col-12 col-md-8">
                <h5 class="card-title">Desenvolvimento Web</h5>
                <h6 class="card-subtitle fw-light mb-4">CESAE</h6>
                </div>
                <div class="col-12 col-md-4 d-flex align-items-center">
                    <span class="status ativo position-absolute top-0 end-0 m-3 btn-novo-curso">ativo</span>
                    {{-- <span class="status inativo position-absolute top-0 end-0 m-3" id="btn-novo-curso">inativo</span> --}}
                </div>
            </div>
                <p class="card-text fw-light">Descrição curta do curso...</p>
            <div class="d-flex justify-content-between px-3">
               <span class="card-text"><i class="bi bi-journal-bookmark-fill"></i>  Módulos</span>
               <span class="card-text"><i class="bi bi-clock"></i>  120h</span>
               <span class="card-text"><i class="bi bi-people-fill"></i>  Alunos</span>
            </div>
          <div class="d-flex justify-content-between mt-4">
            <button class="btn btn-sm ms-auto btn-novo-curso" data-bs-toggle="modal" data-bs-target="#verDetalhesModal">Ver detalhes</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">JavaScript Avançado</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <h6 class="card-subtitle">Cesae</h6>
          <p class="card-text">Descrição curta do curso...</p>

          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

{{-- <div class="container my-4">
    <!-- Linha 1: Título e barra de pesquisa -->
    <div class="d-flex align-items-center mb-3">
        <h2 class="fw-bold">Cursos</h2>
        <input type="text" class="form-control w-auto ms-auto" placeholder="Pesquisar Curso..." id="pesquisa-cursos" style="width: 200px;">
    </div>

    <!-- Linha 2: Botão Novo Curso -->
    <div class="mb-4">
        <a href="{{ route('cursos.create') }}" class="btn btn-primary">+ Novo Curso</a>
    </div>

   <!-- Linha 3: Grid de cursos -->
@if($cursos->count() > 0)
    <div class="row g-4">
        @foreach($cursos as $curso)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-cursos shadow-sm h-100 position-relative">

                    <!-- Status ativo/inativo no canto superior direito -->
                    <span class="status {{ $curso->ativo ? 'ativo' : 'inativo' }} position-absolute top-0 end-0 m-3">
                        {{ $curso->ativo ? 'ativo' : 'inativo' }}
                    </span>

                    <div class="card-body">
                        <h5 class="card-title">{{ $curso->nome }}</h5>

                        @if($curso->subtitulo)
                            <h6 class="card-subtitle fw-light mb-4">{{ $curso->subtitulo }}</h6>
                        @endif

                        <p class="card-text fw-light">{{ $curso->descricao }}</p>

                        @if($curso->modulos || $curso->horas || $curso->alunos)
                            <div class="d-flex justify-content-between px-3">
                                <span class="card-text"><i class="bi bi-journal-bookmark-fill"></i> {{ $curso->modulos_count ?? 0 }}</span>
                                <span class="card-text"><i class="bi bi-clock"></i> {{ $curso->horas ?? '-' }}</span>
                                <span class="card-text"><i class="bi bi-people-fill"></i> {{ $curso->alunos_count ?? 0 }}</span>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-sm btn-outline-primary">Ver mais</a>
                            <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="text-muted">Nenhum curso cadastrado ainda.</p>
@endif--}}

</div>
@endsection
