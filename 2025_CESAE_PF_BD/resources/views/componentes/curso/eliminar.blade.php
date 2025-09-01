<div class="modal fade" id="confirmarEliminar" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmar eliminação</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fechar"></button>
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
