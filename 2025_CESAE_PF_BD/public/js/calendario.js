
document.addEventListener('DOMContentLoaded', function () {
  const el = document.getElementById('calendar');

  // refs do modal/inputs
  const modalEl = document.getElementById('eventoModal');
  const bsModal = new bootstrap.Modal(modalEl, { backdrop: 'static' });
  const form = document.getElementById('eventoForm');
  const inpId = document.getElementById('event_id');
  const inpTitle = document.getElementById('event_title');
  const selModulo = document.getElementById('event_modulo');
  const inpInicio = document.getElementById('event_inicio');
  const inpFim = document.getElementById('event_fim');
  const inpNota = document.getElementById('event_nota');
  const divErro = document.getElementById('eventoErro');
  const btnApagar = document.getElementById('btnApagar');
  const btnGuardar = document.getElementById('btnGuardar');
  const tituloModal = document.getElementById('eventoModalLabel');

  // helpers
  const pad = (n) => String(n).padStart(2, '0');
  const toLocalInput = (dateOrIso) => {
    const d = new Date(dateOrIso);
    return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
  };
  const toMysql = (localDt) => localDt ? localDt.replace('T',' ') + ':00' : null;

  const clearForm = () => {
    inpId.value = '';
    inpTitle.value = '';
    selModulo.value = '';
    inpInicio.value = '';
    inpFim.value = '';
    inpNota.value = '';
    divErro.style.display = 'none';
    btnApagar.style.display = 'none';
    btnGuardar.textContent = 'Guardar';
    tituloModal.textContent = 'Novo evento';
  };

  const openCreate = (startStr, endStr) => {
    clearForm();
    inpInicio.value = toLocalInput(startStr);
    inpFim.value = toLocalInput(endStr || startStr);
    bsModal.show();
  };

  const openEdit = (fcEvent) => {
    clearForm();
    inpId.value = fcEvent.id;
    inpTitle.value = fcEvent.title || '';
    // extra props que podes devolver no toCalendarArray()
    selModulo.value = fcEvent.extendedProps?.modulos_id || '';
    inpNota.value = fcEvent.extendedProps?.nota || '';
    inpInicio.value = toLocalInput(fcEvent.start);
    inpFim.value = toLocalInput(fcEvent.end || fcEvent.start);
    btnApagar.style.display = 'inline-flex';
    btnGuardar.textContent = 'Atualizar';
    tituloModal.textContent = 'Editar evento';
    bsModal.show();
  };

  const calendar = new FullCalendar.Calendar(el, {
    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    themeSystem: 'bootstrap5',
    selectable: true,
    editable: true,
    events: '/events',
    locale: 'pt',
    buttonText: {
      today: 'Hoje',
      month: 'Mês',
      week: 'Semana',
      day: 'Dia'
    },

    select(info) {
      openCreate(info.startStr, info.endStr);
    },

    eventClick(info) {
      openEdit(info.event);
    }
  });

  calendar.render();

  // submit (create/update)
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    divErro.style.display = 'none';

    const payload = {
      title: inpTitle.value || null,
      modulos_id: selModulo.value || null,
      nota: inpNota.value || null,
      start: toMysql(inpInicio.value),
      end: toMysql(inpFim.value)
    };

    const id = inpId.value || null;
    const url = id ? `/events/${id}` : '/events';
    const method = id ? 'PUT' : 'POST';

    try {
      const res = await fetch(url, {
        method,
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload)
      });

      if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.message || 'Erro ao guardar o evento.');
      }

      bsModal.hide();
      calendar.refetchEvents();
    } catch (err) {
      divErro.textContent = err.message;
      divErro.style.display = 'block';
    }
  });

  // apagar
  btnApagar.addEventListener('click', async () => {
    const id = inpId.value;
    if (!id) return;
    if (!confirm('Tem a certeza que deseja apagar este evento?')) return;

    try {
      const res = await fetch(`/events/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
      });
      if (!res.ok) throw new Error('Não foi possível apagar.');
      bsModal.hide();
      calendar.refetchEvents();
    } catch (err) {
      divErro.textContent = err.message;
      divErro.style.display = 'block';
    }
  });
});

