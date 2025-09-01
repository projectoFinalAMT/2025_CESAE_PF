@extends('layouts.fe_master')

@section('css')
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
        <!-- FullCalendar CSS PROPRIO -->
    <link rel="stylesheet" href="{{ asset('css/calendario/bladeCalendario.css') }}">



@endsection

@section('content')
<div class="content">

<div class="container mt-4">
    <h2>Calendário</h2>
    <div id="calendar"></div>
</div>
{{-- MODAL: Criar/Editar Evento --}}
<div class="modal fade" id="eventoModal" tabindex="-1" aria-labelledby="eventoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="eventoForm" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventoModalLabel">Novo evento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="event_id">
          <div class="mb-3">
            <label class="form-label">Título (opcional)</label>
            <input type="text" id="event_title" class="form-control" placeholder="Ex.: Reunião com coordenação">
          </div>

          <div class="mb-3">
            <label class="form-label">Módulo (opcional)</label>
            <select id="event_modulo" class="form-select">
              <option value="">— Sem módulo —</option>

              @foreach($modulos as $m)
                <option value="{{ $m->id }}">{{ $m->nomeModulo }}</option>
              @endforeach

            </select>
          </div>

          <div class="row g-2">
            <div class="col-6">
              <label class="form-label">Início</label>
              <input type="datetime-local" id="event_inicio" class="form-control">
            </div>
            <div class="col-6">
              <label class="form-label">Fim</label>
              <input type="datetime-local" id="event_fim" class="form-control">
            </div>
          </div>

          <div class="mt-3">
            <label class="form-label">Nota (opcional)</label>
            <textarea id="event_nota" class="form-control" rows="2" placeholder="Ex.: trazer projector"></textarea>
          </div>

          <div id="eventoErro" class="text-danger mt-2" style="display:none;"></div>
        </div>

        <div class="modal-footer">
          <button type="button" id="btnApagar" class="btn btn-outline-danger me-auto" style="display:none;">Apagar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection

@section('scripts')
    <!-- IMPORTANTE: JS do FullCalendar (usa o bundle global) -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<!-- Passar CSRF token para o JS -->
<script>
    window.csrfToken = "{{ csrf_token() }}";
</script>
<!-- Nosso JS -->
<script src="{{ asset('js/calendario.js') }}"></script>
<script src="{{ asset('assets/bootstrap.js')}}" ></script> <!--Script bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" ></script>

@endsection

