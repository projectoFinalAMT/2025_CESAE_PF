
document.addEventListener('DOMContentLoaded', () => {
  const selInst   = document.getElementById('instituicao_ids');
  const selCurso  = document.getElementById('curso_ids');
  const selModulo = document.getElementById('modulo_ids');

  const values = (sel) => Array.from(sel?.selectedOptions || []).map(o => o.value);

  function resetSelect(selectEl, placeholder = null) {
    if (!selectEl) return;
    selectEl.innerHTML = '';
    if (placeholder) {
      const opt = document.createElement('option');
      opt.disabled = true; opt.textContent = placeholder;
      selectEl.appendChild(opt);
    }
    selectEl.disabled = true;
  }

  function enableIfHasOptions(selectEl) {
    if (!selectEl) return;
    selectEl.disabled = selectEl.options.length === 0;
  }

  // Carrega cursos para um array de instituições (merge de resultados)
  async function loadCursosByInsts(instIds) {
    resetSelect(selCurso);
    resetSelect(selModulo);

    if (!instIds || instIds.length === 0) return;

    const vistos = new Set();

    for (const id of instIds) {
      try {
        const res = await fetch(`/instituicoes/${id}/cursos`, { headers: { 'Accept': 'application/json' }});
        if (!res.ok) throw new Error('Falha ao carregar cursos.');
        const cursos = await res.json(); // [{id, titulo}, ...]
        cursos.forEach(c => {
          if (vistos.has(c.id)) return;
          vistos.add(c.id);
          const o = document.createElement('option');
          o.value = c.id;
          o.textContent = c.titulo ?? c.nome ?? `Curso #${c.id}`;
          selCurso.appendChild(o);
        });
      } catch (e) {
        console.error(e);
        alert(e.message || 'Erro a carregar cursos.');
      }
    }

    enableIfHasOptions(selCurso);
  }

  // Carrega módulos para um array de cursos (merge de resultados)
  async function loadModulosByCursos(cursoIds) {
    resetSelect(selModulo);

    if (!cursoIds || cursoIds.length === 0) return;

    const vistos = new Set();

    for (const id of cursoIds) {
      try {
        const res = await fetch(`/cursos/${id}/modulos`, { headers: { 'Accept': 'application/json' }});
        if (!res.ok) throw new Error('Falha ao carregar módulos.');
        const modulos = await res.json(); // [{id, nomeModulo}, ...]
        modulos.forEach(m => {
          if (vistos.has(m.id)) return;
          vistos.add(m.id);
          const o = document.createElement('option');
          o.value = m.id;
          o.textContent = m.nomeModulo ?? `Módulo #${m.id}`;
          selModulo.appendChild(o);
        });
      } catch (e) {
        console.error(e);
        alert(e.message || 'Erro a carregar módulos.');
      }
    }

    enableIfHasOptions(selModulo);
  }

  // Eventos
  selInst?.addEventListener('change', () => loadCursosByInsts(values(selInst)));
  selCurso?.addEventListener('change', () => loadModulosByCursos(values(selCurso)));

  // Ao abrir o modal, limpa dependentes
  const modalEl = document.getElementById('alunoModal');
  modalEl?.addEventListener('show.bs.modal', () => {
    resetSelect(selCurso);
    resetSelect(selModulo);
  });
});



// calculo das medias na tabela alunos
function calculomedia(){

   

const avaliacoes = document.querySelectorAll('input[type="number"]');
let divisor=0;
let soma=0;

console.log(avaliacoes)


for(let avaliacao of avaliacoes){

let valor = parseFloat(avaliacao.value);

if (!isNaN(valor)){
    soma += valor
    divisor++
}
}
let media= (soma/divisor).toFixed(2)

//colocar a media na coluna da media
let mediaDoAluno= document.querySelector('.mediaAluno');
mediaDoAluno.value=media
}
