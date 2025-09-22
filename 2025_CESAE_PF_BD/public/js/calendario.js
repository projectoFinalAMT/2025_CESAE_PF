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

    // === Modo clone via tecla modificadora ===
let cloneMode = false;

// Ativa clone com Ctrl, Alt ou Cmd (Meta no Mac)
function isCloneKey(e) {
  return e.key === 'Control' || e.key === 'Alt' || e.key === 'Meta';
}

document.addEventListener('keydown', (e) => {
  if (isCloneKey(e)) cloneMode = true;
});

document.addEventListener('keyup', (e) => {
  if (isCloneKey(e)) cloneMode = false;
});

// Se a janela perder o foco, garante que o modo clone desliga
window.addEventListener('blur', () => { cloneMode = false; });

// Helper: Date -> "YYYY-MM-DD HH:MM:SS" (para o teu backend)
const toMysqlFromDate = (d) => {
  if (!d) return null;
  const yyyy = d.getFullYear();
  const mm   = pad(d.getMonth() + 1);
  const dd   = pad(d.getDate());
  const HH   = pad(d.getHours());
  const MM   = pad(d.getMinutes());
  const SS   = pad(d.getSeconds());
  return `${yyyy}-${mm}-${dd} ${HH}:${MM}:${SS}`;
};


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

    const openCreate = (start, end, isAllDay = false) => {
        clearForm();

        // trabalhar sempre com Date
        const s = new Date(start);

        let sEff, eEff;

        if (isAllDay) {
          // se a seleção veio all-day (ex.: month view), usa janela de trabalho e +1h
          sEff = new Date(s.getFullYear(), s.getMonth(), s.getDate(), WORK_START, 0, 0, 0);
          eEff = new Date(sEff); eEff.setHours(eEff.getHours() + 1);
        } else {
          // caso normal: fim = início + 1h
          sEff = new Date(s);
          eEff = new Date(s); eEff.setHours(eEff.getHours() + 1);
        }

        // garante que não passa da meia-noite (opcional)
        const endOfDay = new Date(sEff.getFullYear(), sEff.getMonth(), sEff.getDate(), 23, 59, 59, 999);
        if (eEff > endOfDay) eEff = endOfDay;

        inpInicio.value = toLocalInput(sEff);
        inpFim.value    = toLocalInput(eEff);
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

    // === Helpers do card lateral ===
const rowsEl = document.getElementById('apontamentosRow');
const subtitlesEl = document.getElementById('subtitles');

const hhmm = (d) => String(d.getHours()).padStart(2,'0') + ':' + String(d.getMinutes()).padStart(2,'0');
const fmtDia = (d) => d.toLocaleDateString('pt-PT', { weekday: 'short', day: '2-digit', month: '2-digit' });

// Limpa e mostra mensagem
function renderEmpty(msg='Sem resultados') {
  if (!rowsEl) return;
  rowsEl.innerHTML = `
    <div class="row align-items-start apontamento-row">
      <div class="col-12 text-muted">${msg}</div>
    </div>`;
}

// Render “linhas” agrupadas por dia: [{date: Date, hora: 'HH:MM - HH:MM', titulo: '...'}]
function renderGrouped(list) {
  if (!rowsEl) return;
  if (!Array.isArray(list) || !list.length) return renderEmpty();

  // agrupa por AAAA-MM-DD
  const byDay = {};
  list.forEach(item => {
    const d = item.date;
    const key = `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
    (byDay[key] ||= { label: fmtDia(d), items: [] }).items.push(item);
  });

  // ordena dias e itens
  const orderedDays = Object.values(byDay);
  rowsEl.innerHTML = orderedDays.map(day => {
    const itens = day.items
      .sort((a,b) => a.startMs - b.startMs)
      .map(it => `
        <div class="row align-items-start apontamento-row">
          <div class="col-6">${it.hora}</div>
          <div class="col-6">${it.titulo}</div>
        </div>`).join('');
    return `
      <div class="row"><div class="col-12 fw-semibold mt-2">${day.label}</div></div>
      ${itens}
    `;
  }).join('');
}

// Eventos que intersectam [start,end)
function getEventsInRange(start, end) {
  return calendar.getEvents().filter(ev => {
    const s = ev.start; if (!s) return false;
    const e = ev.end || ev.start;
    return e > start && s < end; // intersecção
  });
}

// Converte eventos do FC em linhas (para renderGrouped)
function mapEventsToRows(events) {
  return events.map(ev => {
    const s = ev.start, e = ev.end || ev.start;
    const allDay = !!ev.allDay;
    return {
      date: new Date(s.getFullYear(), s.getMonth(), s.getDate()),
      startMs: s.getTime(),
      hora: allDay ? 'Dia todo' : `${hhmm(s)} - ${hhmm(e)}`,
      titulo: ev.title || 'Evento'
    };
  });
}

// === Geração de “Horário Livre” para a semana ===
// work window (ajusta se quiseres)
const WORK_START = 8;   // 08:00
const WORK_END   = 22;  // 22:00

// devolve o início/fim da semana corrente da vista (segunda a domingo)
function getWeekBoundsFromView() {
  // FullCalendar v6: currentStart/currentEnd (start=segunda, end=segunda seguinte para timeGridWeek/dayGridWeek)
  const vs = calendar.view.currentStart;
  const ve = calendar.view.currentEnd;
  return { weekStart: new Date(vs), weekEnd: new Date(ve) };
}

// Merge de intervalos ocupados [start,end) assumindo ordenados
function mergeBusy(intervals) {
  const out = [];
  intervals.sort((a,b) => a.start - b.start).forEach(int => {
    if (!out.length || int.start > out[out.length-1].end) out.push({ ...int });
    else out[out.length-1].end = new Date(Math.max(out[out.length-1].end, int.end));
  });
  return out;
}

// Gaps livres num dia dentro do horário de trabalho, considerando all-day como “dia todo ocupado”
function freeGapsOneDay(date, dayEvents) {
  const y=date.getFullYear(), m=date.getMonth(), d=date.getDate();
  const dayStart = new Date(y,m,d,WORK_START,0,0,0);
  const dayEnd   = new Date(y,m,d,WORK_END,0,0,0);

  // Se houver evento all-day, não há gaps
  if (dayEvents.some(e => e.allDay)) return [];

  // cria lista ocupada cortada ao horário
  const busy = dayEvents
    .filter(e => e.start && (e.end || e.start))
    .map(e => {
      const s = e.start < dayStart ? dayStart : e.start;
      const end = e.end || e.start;
      const ee = end > dayEnd ? dayEnd : end;
      return { start: s, end: ee };
    })
    .filter(int => int.end > int.start);

  const merged = mergeBusy(busy);

  // gaps
  const gaps = [];
  let cursor = dayStart;
  merged.forEach(b => {
    if (cursor < b.start) gaps.push({ start: cursor, end: b.start });
    if (cursor < b.end) cursor = b.end;
  });
  if (cursor < dayEnd) gaps.push({ start: cursor, end: dayEnd });

  return gaps;
}



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
      defaultTimedEventDuration: "01:00",
      forceEventDuration: true,
      displayEventTime: true,
eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },

eventContent(arg) {
  const time = arg.timeText;                 // "HH:mm" já formatado pelo FC
  const title = arg.event.title || 'Evento';
  return {
    html: `
      <div class="fc-event-main d-flex align-items-center">
        <strong class="me-1 fc-time">${time}</strong>
        <span class="fc-title text-truncate">${title}</span>
      </div>
    `
  };
},



      select(info) { openCreate(info.start, info.end, info.allDay); },
      eventClick(info) { openEdit(info.event); },

      eventDragStart(info) {
        // Opcional: feedback visual quando clone está ativo
        if (cloneMode) document.body.classList.add('fc-clone-cursor');
      },
      eventDisplay: 'block', // <- força bloco em dayGrid (em vez de dot)
      eventDidMount(info) {
        const cor = info.event.extendedProps?.instituicao_cor; // ajusta a tua prop
        if (cor) {
          info.el.style.backgroundColor = cor;
          info.el.style.borderColor = cor;
          info.el.style.color = '#fff'; // contraste
        }
      },
      eventDragStop(info) {
        document.body.classList.remove('fc-clone-cursor');
      },

      eventDrop: async function(info) {
        // Novas datas (guardar antes de reverter)
        const newStart = info.event.start;
        const newEnd   = info.event.end;

        // Evento original + extendedProps que usas no backend
        const ev = info.event;
        const x  = ev.extendedProps || {};

        const basePayload = {
          title: ev.title || null,
          cursos_id: x.curso_id || null,
          modulos_id: x.modulos_id || null,
          nota: x.nota || null
        };


        if (cloneMode) {
          // --- DUPLICAR ---
          info.revert(); // devolve o original
          const payload = {
            ...basePayload,
            start: toMysqlFromDate(newStart),
            end:   toMysqlFromDate(newEnd || newStart)
          };

          try {
            const res = await fetch('/events', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken
              },
              body: JSON.stringify(payload)
            });
            if (!res.ok) {
              let msg = 'Erro ao duplicar o evento.';
              try {
                const data = await res.json();
                if (data?.errors) msg = Object.values(data.errors).flat().join('\n');
                else if (data?.message) msg = data.message;
              } catch(_){}
              throw new Error(msg);
            }
            info.view.calendar.refetchEvents();
          } catch (err) {
            alert(err.message || 'Não foi possível duplicar.');
          }
        } else {
          // --- MOVER normal ---
          const payload = {
            ...basePayload,
            start: toMysqlFromDate(newStart),
            end:   toMysqlFromDate(newEnd || newStart)
          };

          try {
            const res = await fetch(`/events/${ev.id}`, {
              method: 'PUT',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken
              },
              body: JSON.stringify(payload)
            });
            if (!res.ok) {
              let msg = 'Erro ao mover o evento.';
              try {
                const data = await res.json();
                if (data?.errors) msg = Object.values(data.errors).flat().join('\n');
                else if (data?.message) msg = data.message;
              } catch(_){}
              throw new Error(msg);
            }
            info.view.calendar.refetchEvents();
          } catch (err) {
            // Se falhar, volta ao sítio original
            info.revert();
            alert(err.message || 'Não foi possível mover.');
          }
        }
      },


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

    //FILTRO CALENDARIO
    // 1) Preencher "Hoje" por defeito sempre que a vista muda (inclui primeiro render)
calendar.on('datesSet', () => {
    const now = new Date();
    const start = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    const end   = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1);
    const rows  = mapEventsToRows(getEventsInRange(start, end));
    renderGrouped(rows);
    if (subtitlesEl) subtitlesEl.textContent = 'Hoje';
  });

  // 2) Listener do dropdown de filtros
  const filterMenu = document.getElementById('filterDropdown');
  if (filterMenu) {
    filterMenu.addEventListener('click', (e) => {
      const link = e.target.closest('a[data-filter]');
      if (!link) return;
      e.preventDefault();

      const f = link.getAttribute('data-filter');
      const now = new Date();

      if (f === 'all') {
        // Hoje
        const start = new Date(now.getFullYear(), now.getMonth(), now.getDate());
        const end   = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1);
        renderGrouped(mapEventsToRows(getEventsInRange(start, end)));
        if (subtitlesEl) subtitlesEl.textContent = 'Hoje';
        return;
      }

      if (f === 'livre') {
        // Amanhã
        const amanha = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1);
        const start = new Date(amanha.getFullYear(), amanha.getMonth(), amanha.getDate());
        const end   = new Date(amanha.getFullYear(), amanha.getMonth(), amanha.getDate() + 1);
        renderGrouped(mapEventsToRows(getEventsInRange(start, end)));
        if (subtitlesEl) subtitlesEl.textContent = 'Amanhã';
        return;
      }

      if (f === 'reuniao') {
        // Semana (eventos)
        const { weekStart, weekEnd } = getWeekBoundsFromView();
        const rows = mapEventsToRows(getEventsInRange(weekStart, weekEnd));
        renderGrouped(rows);
        if (subtitlesEl) subtitlesEl.textContent = 'Semana (Eventos)';
        return;
      }

      if (f === 'aula') {
        // Horário Livre da semana (WORK_START..WORK_END)
        const { weekStart, weekEnd } = getWeekBoundsFromView();
        const livres = [];

        for (let d = new Date(weekStart); d < weekEnd; d = new Date(d.getFullYear(), d.getMonth(), d.getDate() + 1)) {
          const dayStart = new Date(d.getFullYear(), d.getMonth(), d.getDate());
          const dayEnd   = new Date(d.getFullYear(), d.getMonth(), d.getDate() + 1);

          const dayEvents = getEventsInRange(dayStart, dayEnd);

          const gaps = freeGapsOneDay(d, dayEvents.map(ev => ({
            start: ev.start,
            end: ev.end || ev.start,
            allDay: !!ev.allDay
          })));

          gaps.forEach(g => {
            livres.push({
              date: new Date(d.getFullYear(), d.getMonth(), d.getDate()),
              startMs: g.start.getTime(),
              hora: `${hhmm(g.start)} - ${hhmm(g.end)}`,
              titulo: 'Livre'
            });
          });
        }

        if (!livres.length) renderEmpty('Sem horários livres nesta semana');
        else renderGrouped(livres);

        if (subtitlesEl) subtitlesEl.textContent = `Horário Livre ( ${WORK_START}:00–${WORK_END}:00)`;
        return;
      }
    });
}



// === Botão: Exportar Excel ===
const btnExportarXlsx = document.getElementById('btnExportarXlsx');
if (btnExportarXlsx) {
  btnExportarXlsx.addEventListener('click', () => {

  const view = calendar.view;

  const start = view.currentStart.toISOString().split('T')[0] + ' 00:00:00';
  const end   = new Date(view.currentEnd - 1).toISOString().split('T')[0] + ' 23:59:59';


  window.location.href = `/events/export?start=${start}&end=${end}`;
});
}

// === Botão: Imprimir (se tiveres um #btnImprimir) ===
const btnImprimir = document.getElementById('btnImprimir');
if (btnImprimir) {
  btnImprimir.addEventListener('click', () => window.print());
}


  //. FILTRO CALENDARIO


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
