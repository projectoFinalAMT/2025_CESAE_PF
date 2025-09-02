document.addEventListener('DOMContentLoaded', function () {
    // container único
    const el = document.getElementById('calendar');
    if (!el) return;

    // === REFS E HELPERS (mantém os teus) ===
    const modalEl = document.getElementById('eventoModal');
    const bsModal = new bootstrap.Modal(modalEl, { backdrop: 'static' });
    const form = document.getElementById('eventoForm');
    const inpId = document.getElementById('event_id');
    const inpTitle = document.getElementById('event_title');
    const selModulo = document.getElementById('event_modulo');
    const selCurso  = document.getElementById('event_curso'); // novo
    const inpInicio = document.getElementById('event_inicio');
    const inpFim = document.getElementById('event_fim');
    const inpNota = document.getElementById('event_nota');
    const divErro = document.getElementById('eventoErro');
    const btnApagar = document.getElementById('btnApagar');
    const btnGuardar = document.getElementById('btnGuardar');
    const tituloModal = document.getElementById('eventoModalLabel');

    const pad = (n) => String(n).padStart(2, '0');
    const toLocalInput = (dateOrIso) => {
      const d = new Date(dateOrIso);
      return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
    };
    const toMysql = (localDt) => (localDt ? localDt.replace('T', ' ') + ':00' : null);

    // --- util: carregar módulos por curso ---
    async function loadModulosByCurso(cursoId, selectedModuloId = null) {
      // limpa o select de módulos
      selModulo.innerHTML = '<option value="">— Sem módulo —</option>';

      if (!cursoId) return; // sem curso, fica vazio

      try {
        const res = await fetch(`/cursos/${cursoId}/modulos`, {
          headers: { 'Accept': 'application/json' }
        });
        if (!res.ok) throw new Error('Falha ao carregar módulos.');
        const mods = await res.json();

        mods.forEach(m => {
          const opt = document.createElement('option');
          opt.value = m.id;
          opt.textContent = m.nomeModulo;
          opt.dataset.curso = m.cursos_id;
          if (selectedModuloId && Number(selectedModuloId) === Number(m.id)) {
            opt.selected = true;
          }
          selModulo.appendChild(opt);
        });
      } catch (e) {
        console.error(e);
      }
    }

    // quando muda o curso no modal, recarrega módulos
    if (selCurso) {
      selCurso.addEventListener('change', () => {
        const cursoId = selCurso.value || null;
        loadModulosByCurso(cursoId);
      });
    }

    const clearForm = () => {
      inpId.value = '';
      inpTitle.value = '';
      if (selCurso) selCurso.value = '';
      // limpa módulos visualmente
      selModulo.innerHTML = '<option value="">— Sem módulo —</option>';
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

    const openEdit = async (fcEvent) => {
      clearForm();
      inpId.value = fcEvent.id;
      inpTitle.value = fcEvent.title || '';
      inpNota.value = fcEvent.extendedProps?.nota || '';

      // infere curso a partir do evento (enviado pelo backend)
      const cursoId = fcEvent.extendedProps?.curso_id || '';
      const moduloId = fcEvent.extendedProps?.modulos_id || '';

      if (selCurso) selCurso.value = cursoId || '';

      // carrega módulos desse curso e pré-seleciona o módulo do evento
      if (cursoId) {
        await loadModulosByCurso(cursoId, moduloId);
      } else {
        // se não veio curso_id, tenta deixar o módulo atual selecionado apenas se já existir na lista
        const opt = selModulo.querySelector(`option[value="${moduloId}"]`);
        if (opt) opt.selected = true;
      }

      inpInicio.value = toLocalInput(fcEvent.start);
      inpFim.value = toLocalInput(fcEvent.end || fcEvent.start);
      btnApagar.style.display = 'inline-flex';
      btnGuardar.textContent = 'Atualizar';
      tituloModal.textContent = 'Editar evento';
      bsModal.show();
    };





    // === Responsividade sem media queries CSS ===
    const isMobile = () => window.matchMedia('(max-width: 767.98px)').matches;
    const mobileHeader = { left: 'prev,next', center: 'title', right: 'today' };
    const desktopHeader = { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' };

    const calendar = new FullCalendar.Calendar(el, {
      initialView: isMobile() ? 'listWeek' : 'dayGridMonth',
      headerToolbar: isMobile() ? mobileHeader : desktopHeader,
      themeSystem: 'bootstrap5',
      locale: 'pt',
      buttonText: { today: 'Hoje', month: 'Mês', week: 'Semana', day: 'Dia' },
      height: 'auto',
      expandRows: true,
      nowIndicator: true,

      selectable: true,
      editable: true,
      events: '/events',

    //   eventContent(arg) {
    //     const t = arg.event.title || ''; // o que o user escreveu (ou o que veio salvo)
    //     const m = arg.event.extendedProps?.modulo_nome || '';
    //     const c = arg.event.extendedProps?.curso_titulo || '';

    //     // Regras:
    //     // - Se escreveu título e escolheu módulo/curso -> "título — nome"
    //     // - Se não escreveu título -> usa módulo, senão curso, senão "Evento"
    //     let display = t;
    //     const extra = m || c;

    //     if (t && extra) {
    //       display = `${t} — ${extra}`;
    //     } else if (!t) {
    //       display = extra || 'Evento';
    //     }

    //     return { html: `<div class="fc-event-title">${display}</div>` };
    //   },

      select(info) { openCreate(info.startStr, info.endStr); },
      eventClick(info) { openEdit(info.event); },

      windowResize() {
        const mobile = isMobile();
        calendar.setOption('headerToolbar', mobile ? mobileHeader : desktopHeader);
        const target = mobile ? 'listWeek' : 'dayGridMonth';
        if (calendar.view.type !== target) {
          calendar.changeView(target);
        }
      }
    });

    calendar.render();

    // === Submissão (create/update) ===
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      divErro.style.display = 'none';
      divErro.innerHTML = '';

      const payload = {
        title: inpTitle.value || null,
        cursos_id: selCurso.value || null,
        modulos_id: selModulo.value || null,
        nota: inpNota.value || null,
        start: toMysql(inpInicio.value),
        end: toMysql(inpFim.value),
        // cursos_id NÃO é enviado/gravado — serve só para filtrar módulos
      };

      const id = inpId.value || null;
      const url = id ? `/events/${id}` : '/events';
      const method = id ? 'PUT' : 'POST';

      try {
        const res = await fetch(url, {
          method,
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': window.csrfToken
          },
          body: JSON.stringify(payload)
        });

        if (!res.ok) {
          let msg = 'Erro ao guardar o evento.';
          try {
            const data = await res.json();
            if (data?.errors) {
              msg = Object.values(data.errors).flat().join('<br>');
            } else if (data?.message) {
              msg = data.message;
            }
          } catch (_) {}
          throw new Error(msg);
        }

        bsModal.hide();
        calendar.refetchEvents();
      } catch (err) {
        divErro.innerHTML = err.message;
        divErro.style.display = 'block';
      }
    });

    // === Apagar ===
    btnApagar.addEventListener('click', async () => {
      const id = inpId.value;
      if (!id) return;
      if (!confirm('Tem a certeza que deseja apagar este evento?')) return;

      try {
        const res = await fetch(`/events/${id}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': window.csrfToken
          }
        });

        if (!res.ok) {
          let msg = 'Não foi possível apagar.';
          try {
            const data = await res.json();
            if (data?.errors) {
              msg = Object.values(data.errors).flat().join('<br>');
            } else if (data?.message) {
              msg = data.message;
            }
          } catch (_) {}
          throw new Error(msg);
        }

        bsModal.hide();
        calendar.refetchEvents();
      } catch (err) {
        divErro.innerHTML = err.message;
        divErro.style.display = 'block';
      }
    });
  });
