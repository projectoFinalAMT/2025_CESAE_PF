// MODAL NOVA FATURA

document.addEventListener("DOMContentLoaded", function () {
  const qtd = document.getElementById("fatura-qtd");
  const valor = document.getElementById("fatura-valor");
  const ivaInput = document.getElementById("fatura-iva");
  const irsInput = document.getElementById("fatura-irs");

  const subtotalEl = document.getElementById("subtotal");
  const ivaEl = document.getElementById("iva");
  const irsEl = document.getElementById("irs");
  const totalEl = document.getElementById("total");

  function calcularTotais() {
    const qtdVal = parseFloat(qtd.value) || 0;
    const valorUnitario = parseFloat(valor.value) || 0;
    const ivaPerc = parseFloat(ivaInput.value) || 0;
    const irsPerc = parseFloat(irsInput.value) || 0;

    const subtotal = qtdVal * valorUnitario;
    const valorIva = subtotal * (ivaPerc / 100);
    const valorIrs = subtotal * (irsPerc / 100);
    const total = subtotal + valorIva - valorIrs;

    subtotalEl.textContent = `€${subtotal.toFixed(2)}`;
    ivaEl.textContent = `€${valorIva.toFixed(2)}`;
    irsEl.textContent = `-€${valorIrs.toFixed(2)}`;
    totalEl.textContent = `€${total.toFixed(2)}`;
  }

  [qtd, valor, ivaInput, irsInput].forEach(input =>
    input.addEventListener("input", calcularTotais)
  );
});





// CARD GANHOS POR INSTITUIÇÃO

document.addEventListener("DOMContentLoaded", () => {
  // Dados iniciais
  const instituicoes = ["CESAE", "LSD", "ISTEC", "ISLA", "ESTEL"];
  const cores = ["#a78bfa", "#ef4444", "#3b82f6", "#22c55e", "#4338ca"];
  const valores = [41.35, 21.51, 13.47, 9.97, 3.35];

  const ctx = document.getElementById("donutInstituicoes").getContext("2d");

  let chartDonut = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: instituicoes,
      datasets: [{
        data: valores,
        backgroundColor: cores
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      }
    }
  });

  function atualizarLegenda() {
    const lista = document.getElementById("listaInstituicoes");
    lista.innerHTML = "";
    chartDonut.data.labels.forEach((label, i) => {
      lista.innerHTML += `
        <li class="d-flex align-items-center mb-2">
          <span class="badge rounded-circle me-2" style="background-color:${cores[i]};">&nbsp;</span>
          <span class="text-secondary">${label}</span>
          <span class="ms-auto fw-bold text-dark">${chartDonut.data.datasets[0].data[i]}%</span>
        </li>`;
    });
  }
  atualizarLegenda();

  // Aplicar filtros
  document.getElementById("btnAplicarFiltro").addEventListener("click", () => {
    const checks = document.querySelectorAll("#checkInstituicoes input[type=checkbox]");
    const novasLabels = [];
    const novosValores = [];
    const novasCores = [];

    checks.forEach((check, i) => {
      if (check.checked) {
        novasLabels.push(instituicoes[i]);
        novosValores.push(valores[i]);
        novasCores.push(cores[i]);
      }
    });

    chartDonut.data.labels = novasLabels;
    chartDonut.data.datasets[0].data = novosValores;
    chartDonut.data.datasets[0].backgroundColor = novasCores;
    chartDonut.update();

    atualizarLegenda();

    // Manter seleção original
    document.getElementById("btnSelecionarTudo").addEventListener("click", function () {
    document.querySelectorAll("#checkInstituicoes input[type='checkbox']").forEach(cb => {
        cb.checked = true;
    });
});


    // Fechar modal
    const modal = bootstrap.Modal.getInstance(document.getElementById("modalFiltroInstituicao"));
    modal.hide();
  });
});


// CARD RECIBOS
document.addEventListener("DOMContentLoaded", () => {
  const linhasTabela = document.querySelectorAll("#tabelaRecibos tr");

  document.getElementById("btnAplicarFiltroRecibos").addEventListener("click", () => {
    // Obter filtros
    const instituicoes = [...document.querySelectorAll("#filtroInstituicao input:checked")].map(el => el.value);
    const estados = [...document.querySelectorAll("#filtroEstado input:checked")].map(el => el.value);

    const dataInicio = document.getElementById("filtroDataInicio").value;
    const dataFim = document.getElementById("filtroDataFim").value;

    const valorMin = parseFloat(document.getElementById("filtroValorMin").value) || -Infinity;
    const valorMax = parseFloat(document.getElementById("filtroValorMax").value) || Infinity;

    // Filtrar linhas
    linhasTabela.forEach(row => {
      const inst = row.dataset.instituicao;
      const estado = row.dataset.estado;
      const data = row.dataset.data;
      const valor = parseFloat(row.dataset.valor);

      let mostrar = true;

      if (!instituicoes.includes(inst)) mostrar = false;
      if (!estados.includes(estado)) mostrar = false;
      if (dataInicio && data < dataInicio) mostrar = false;
      if (dataFim && data > dataFim) mostrar = false;
      if (valor < valorMin || valor > valorMax) mostrar = false;

      row.style.display = mostrar ? "" : "none";
    });

    // Fechar modal depois de aplicar
    const modal = bootstrap.Modal.getInstance(document.getElementById("modalFiltroRecibos"));
    modal.hide();
  });
});

