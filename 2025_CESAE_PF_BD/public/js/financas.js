// -------- CÁLCULO VALORES CARD FATURAÇÃO/CARD GANHOS/CARD EXPECTÁVEL --------
document.addEventListener("DOMContentLoaded", function () {
  const qtd = document.getElementById("fatura-qtd"); // input quantidade_hora
  const valor = document.getElementById("fatura-valor"); // input valor_hora
  const ivaInput = document.getElementById("fatura-iva"); // input do utilizador
  const irsInput = document.getElementById("fatura-irs"); // input do utilizador

  // criado por mim como hidden no html para conseguir passar os valores da calculadora
  const valorTotalInput = document.getElementById('valor_total'); // hidden
  const valorIvaInput = document.getElementById('valor_iva'); // hidden
  const valorIrsInput = document.getElementById('valor_irs'); // hidden
  const valorSubtotalInput = document.getElementById('valor_subtotal') // hidden
  const valorLiquidoRealInput = document.getElementById('valor_liquido'); // hidden

  const subtotalEl = document.getElementById("subtotal"); // subtotal da calculadora (automático)
  const ivaEl = document.getElementById("iva"); // iva da calculadora (automático)
  const irsEl = document.getElementById("irs"); // irs da calculadora (automático)
  const totalEl = document.getElementById("total"); // total da calculadora (automático)
  const liquidoEl = document.getElementById("liquido"); // total liquido da calculadora

  function calcularTotais() {

    // conversão dos valores para decimal ou 0
    const qtdVal = parseFloat(qtd.value) || 0; //
    const valorUnitario = parseFloat(valor.value) || 0;
    const ivaPerc = parseFloat(ivaInput.value) || 0;
    const irsPerc = parseFloat(irsInput.value) || 0;

    // subtotal = valor base sem IVA/IRS
    const subtotal = qtdVal * valorUnitario;

    // cálculos de impostos
    const valorIva = subtotal * (ivaPerc / 100);
    const valorIrs = subtotal * (irsPerc / 100);

    // total = o que o cliente paga (subtotal + IVA)
    const total = subtotal + valorIva;

    // valor líquido real: aquilo que efetivamente fica na mão do utilizador
    // Subtotal - IRS (o IVA não conta porque é devolvido)
    const valorLiquidoReal = subtotal - valorIrs;

    // Debug
  console.log({
    qtdVal,
    valorUnitario,
    ivaPerc,
    irsPerc,
    subtotal,
    valorIva,
    valorIrs,
    total,
    valorLiquidoReal
  });

    valorTotalInput.value = total.toFixed(2);
    valorIvaInput.value = valorIva.toFixed(2);
    valorIrsInput.value = valorIrs.toFixed(2);
    valorSubtotalInput.value = subtotal.toFixed(2);
    valorLiquidoRealInput.value = valorLiquidoReal.toFixed(2);

    subtotalEl.textContent = `€${subtotal.toFixed(2)}`;
    ivaEl.textContent = `€${valorIva.toFixed(2)}`;
    irsEl.textContent = `-€${valorIrs.toFixed(2)}`;
    totalEl.textContent = `€${total.toFixed(2)}`;
    liquidoEl.textContent = `€${valorLiquidoReal.toFixed(2)}`;


    return { qtdVal, valorUnitario, valorIva, valorIrs, total, valorLiquidoReal };
  }

  [qtd, valor, ivaInput, irsInput].forEach(input =>
    input.addEventListener("input", calcularTotais)
  );

});


// -------- CARD GANHOS POR INSTITUICAO --------
// -------- gráfico donut --------
document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById('donutChart');
    if (!canvas) return;

    // Pega os dados que estavam no Blade
    const dataFromBlade = JSON.parse(canvas.dataset.faturacao);

    const labels = dataFromBlade.map(item => item.nome);
    const valores = dataFromBlade.map(item => item.valor);
    const cores = dataFromBlade.map(item => item.cor);

    new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: valores,
                backgroundColor: cores,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            cutout: "60%",
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const percent = dataFromBlade[context.dataIndex].percent;
                            return `${label}: €${value} (${percent}%)`;
                        }
                    }
                }
            }
        }
    });
});



// -------- CARD FATURAS --------
document.addEventListener("DOMContentLoaded", () => {
  const linhasTabela = document.querySelectorAll("#tabelaFaturas tr");

  document.getElementById("btnAplicarFiltroFaturas").addEventListener("click", () => {
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
    const modal = bootstrap.Modal.getInstance(document.getElementById("modalFiltroFaturas"));
    modal.hide();
  });
});

document.addEventListener('DOMContentLoaded', function () {
    // Função de cálculo
    function calcularTotaisEdicao() {
        const qtd = document.getElementById("qtdEditar");
        const valor = document.getElementById("valorEditar");
        const ivaInput = document.getElementById("ivaEditar");
        const irsInput = document.getElementById("irsEditar");

        const valorSubtotalInput = document.getElementById('valor_subtotal_editar');
        const valorIvaInput = document.getElementById('valor_iva_editar');
        const valorIrsInput = document.getElementById('valor_irs_editar');
        const valorTotalInput = document.getElementById('valor_total_editar');
        const valorLiquidoRealInput = document.getElementById('valor_liquido_editar');

        const subtotalEl = document.getElementById("subtotal");
        const ivaEl = document.getElementById("iva");
        const irsEl = document.getElementById("irs");
        const totalEl = document.getElementById("total");
        const liquidoEl = document.getElementById("liquido");

        const qtdVal = parseFloat(qtd.value) || 0;
        const valorUnitario = parseFloat(valor.value) || 0;
        const ivaPerc = parseFloat(ivaInput.value) || 0;
        const irsPerc = parseFloat(irsInput.value) || 0;

        const subtotal = qtdVal * valorUnitario;
        const valorIva = subtotal * (ivaPerc / 100);
        const valorIrs = subtotal * (irsPerc / 100);
        const total = subtotal + valorIva;
        const valorLiquidoReal = subtotal - valorIrs;

        valorSubtotalInput.value = subtotal.toFixed(2);
        valorIvaInput.value = valorIva.toFixed(2);
        valorIrsInput.value = valorIrs.toFixed(2);
        valorTotalInput.value = total.toFixed(2);
        valorLiquidoRealInput.value = valorLiquidoReal.toFixed(2);

        subtotalEl.textContent = `€${subtotal.toFixed(2)}`;
        ivaEl.textContent = `€${valorIva.toFixed(2)}`;
        irsEl.textContent = `-€${valorIrs.toFixed(2)}`;
        totalEl.textContent = `€${total.toFixed(2)}`;
        liquidoEl.textContent = `€${valorLiquidoReal.toFixed(2)}`;
    }

    // Event listeners para inputs do modal
    ['qtdEditar', 'valorEditar', 'ivaEditar', 'irsEditar'].forEach(id => {
        document.getElementById(id).addEventListener('input', calcularTotaisEdicao);
    });

    // Abrir modal e preencher campos (a tua função atual)
    const editarButtons = document.querySelectorAll('.btn-editar-fatura');
    const formEditar = document.getElementById('formEditarFatura');

    editarButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const fatura = JSON.parse(this.dataset.fatura);

            document.getElementById('instituicaoEditar').value = fatura.instituicoes_id;
            document.getElementById('cursoEditar').value = fatura.id_curso || '';
            document.getElementById('moduloEditar').value = fatura.id_modulo || '';
            document.getElementById('descricaoEditar').value = fatura.descricao;
            document.getElementById('qtdEditar').value = fatura.quantidade_horas;
            document.getElementById('valorEditar').value = fatura.valor_hora;
            document.getElementById('ivaEditar').value = fatura.IVAPercetagem;
            document.getElementById('irsEditar').value = fatura.baseCalculoIRS;
            document.getElementById('dataEmissaoEditar').value = fatura.dataEmissao;
            document.getElementById('dataPagamentoEditar').value = fatura.dataPagamento || '';
            document.getElementById('estadoFaturaEditar').value = fatura.estado_faturas_id;
            document.getElementById('observacoesEditar').value = fatura.observacoes || '';

            document.getElementById('valor_total_editar').value = fatura.valor;
            document.getElementById('valor_iva_editar').value = fatura.IVATaxa;
            document.getElementById('valor_irs_editar').value = fatura.IRSTaxa;
            document.getElementById('valor_subtotal_editar').value = fatura.valor_semImposto;
            document.getElementById('valor_liquido_editar').value = fatura.valor_liquido;

            formEditar.action = `/financas/${fatura.id}`;

            const modal = new bootstrap.Modal(document.getElementById('modalEditarFatura'));
            modal.show();

            // Chamar cálculo assim que o modal abre
            calcularTotaisEdicao();
        });
    });
});




// -------- TOAST TEMPORÁRIO - MENSAGEM DE SUCESSO --------
document.addEventListener('DOMContentLoaded', function () {
    const toastEl = document.getElementById('successToast');
    if(toastEl){
        const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
        toast.show();
    }
});


// -------- FECHAR BOTÃO COLLAPSE (ALTERAÇÃO ESTADO FATURA) --------
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.js-close-collapse').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            e.stopPropagation();

            const selector = btn.getAttribute('data-target');
            const el = document.querySelector(selector);
            if (!el) return;

            const instance = bootstrap.Collapse.getOrCreateInstance(el);
            instance.hide();
        });
    });
});


// -------- MENSAGEM: TEM A CERTEZA QUE DESEJA ELIMINAR FATURA? --------
document.addEventListener('DOMContentLoaded', function () {
    const confirmarEliminarModal = document.getElementById('confirmarEliminar');
    const formEliminar = document.getElementById('formEliminar');

    if (confirmarEliminarModal) {
        confirmarEliminarModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // botão que abriu o modal
            const id = button.getAttribute('data-id'); // pega o id da fatura

            // Atualiza o action do form com a rota correta
            formEliminar.action = `/financas/${id}`;
        });
    }
});
