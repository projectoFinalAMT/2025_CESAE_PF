<div class="modal fade" id="editarModuloModal-{{ $modulo->id }}" tabindex="-1"
    aria-labelledby="editarModuloModalLabel-{{ $modulo->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Cabeçalho -->
            <div class="modal-header">
                <div class="col-12 col-md-8">
                    <h5 class="modal-title" id="editarModuloModalLabel-{{ $modulo->id }}">Editar Módulo</h5>
                    <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"
                    aria-label="Fechar"></button>
            </div>

            <!-- Corpo -->
            <div class="modal-body">
                <form method="POST" action="{{ route('modulo.update', $modulo->id) }}">
                    @csrf
                    @method('PUT')
                    <!-- Nome do módulo e Cursos -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nome do Módulo*</label>
                            <input type="text" class="form-control" name="nomeModulo"
                                value="{{ $modulo->nomeModulo }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cursos*</label>
                            <div class="form-check-container w-100 p-2"
                                style="max-height:105px; overflow-y:auto; border:1px solid #ccc; border-radius:0.25rem;">
                                @foreach ($modulo->todosCursos as $curso)
                                <div class="form-check d-flex justify-content-between align-items-center">
                                    <label class="form-check-label" for="curso{{ $curso->id }}">
                                        {{ $curso->titulo }}
                                        ({{ $curso->instituicao->nomeInstituicao ?? 'Instituição não disponível' }})
                                    </label>
                                    <input
                                        class="form-check-input ms-auto"
                                        type="checkbox"
                                        value="{{ $curso->id }}"
                                        id="curso{{ $curso->id }}"
                                        name="cursos[]"
                                        {{ $curso->associado ? 'checked' : '' }}
                                        {{ $loop->first ? 'required' : '' }}  {{-- required apenas no primeiro --}}
                                    >
                                </div>
                            @endforeach
                            </div>
                        </div>

                    </div>

                    <!-- Total horas -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Total horas*</label>
                            <input type="number" class="form-control" name="duracaoHoras"
                                value="{{ $modulo->duracaoHoras }}">
                        </div>
                    </div>

                    <!-- Descrição e documento -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Descrição</label>
                            <textarea class="form-control" name="descricao" rows="3"> {{ $modulo->descricao ?? '' }}</textarea>
                        </div>
                        <div class="col-md-4 d-flex flex-column gap-2 btn-adicionar ms-5">
                            <!-- Botão add modulos -->
                            <button type="button" class="btn btn-novo-curso" data-bs-toggle="collapse"
                                data-bs-target="#modulosCollapse">
                                <i class="bi bi-file-earmark-text-fill"></i> Adicionar Documentos
                            </button>
                            <!-- Collapse do botão "Adicionar Módulos" -->
                            <div class="collapse mt-2" id="modulosCollapse">
                                <div class="card card-body modulo-bloco">
                                    @foreach ($documentos as $doc)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $doc->id }}"
                                                id="documento{{ $doc->id }}" name="documentos[]"
                                                {{ $doc->modulos->contains($modulo->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="documento{{ $doc->id }}">
                                                {{ $doc->nome }}
                                            </label>
                                        </div>
                                    @endforeach



                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-novo-curso">
                            Gravar Alterações <i class="bi bi-check-lg text-success"></i>
                        </button>

                        <button type="button" class="btn btn-novo-curso" data-bs-toggle="modal"
                            data-bs-target="#confirmarEliminar" data-id="{{ $modulo->id }}">
                            Eliminar Módulo <i class="bi bi-x-lg text-danger"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
