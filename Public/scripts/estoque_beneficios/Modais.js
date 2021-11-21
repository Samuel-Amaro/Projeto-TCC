function mostraModalInformation() {
    let elementoModal = document.querySelector("#modalInfoEstoque");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function carregaDadosModalInfo(data) {
  let nome = document.querySelector(".nome-beneficio");
  let tipoMov = document.querySelector(".tipo-mov-estoque");
  let qtdMinima = document.querySelector(".qtd-minima-estoque");
  let qtdMaxima = document.querySelector(".qtd-maxima-estoque");
  let dataHora = document.querySelector(".data-hora-estoque");
  let uM = document.querySelector(".um-estoque"); 
  let qtdMedida = document.querySelector(".qtd-medida");
  let qtdMovimentada = document.querySelector(".qtd-mov");
  nome.textContent = data.nome;
  tipoMov.textContent = data.tipo_mov;
  qtdMinima.textContent = data.quantidade_minima;
  qtdMaxima.textContent = data.quantidade_maxima;
  dataHora.textContent = data.data_hora_ultima_mov;
  uM.textContent = data.sigla;
  qtdMedida.textContent = data.quantidade_por_medida;
  qtdMovimentada.textContent = data.quantidade_mov;
}