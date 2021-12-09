function mostraModalInformation() {
    let elementoModal = document.querySelector("#modalInfoEstoque");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function carregaDadosModalInfo(data) {
  document.querySelector(".nome-tipo-beneficio").textContent = data.nome_tipo;
  document.querySelector(".um").textContent = data.sigla; 
  document.querySelector(".categoria").textContent = data.nome;
  document.querySelector(".saldo-atual").textContent = data.saldo_atual;
}

function formataDataHora(dataHoraString) {
  let d = new Date(dataHoraString);
  let dia = d.getDate();
  let mes = d.getMonth() + 1; //porque começa em 0 janeiro
  let ano = d.getFullYear();
  let hora = d.getHours();
  let minuto = d.getMinutes();
  let segundos = d.getSeconds();
  return `${dia}/${mes}/${ano} ${hora}:${minuto}:${segundos}`;
}

function mostraModalAddMovimentacao() {
  let elementoModal = document.querySelector("#modalAddMovimentacao");
  let objectBoostrap = new bootstrap.Modal(elementoModal);
  objectBoostrap.show();
}

function carregaDadosModalAddMovimentacao(data) {
  let qtd = document.querySelector("#quantidade");
  let idBeneficio = document.querySelector("#id_tipo_beneficio");
  let operacao = document.querySelector("#operacao");
  idBeneficio.value = data.id_tipo_beneficio;
  operacao.value = "ALTERAR";
  qtd.setAttribute("min", 0);
}

function obterDadosModalAddMovimentacao() {
  let idBeneficio = document.querySelector("#id_tipo_beneficio").value; //number
  let operacao = document.querySelector("#operacao").value; //text
  let qtd = document.querySelector("#quantidade").value; //number
  let descricao = document.querySelector(".descricao").value; //text
  let movimentacao = document.querySelector("#tipoMovimentacao").value; //select
  let objMovimentacao = {};
  try {
      objMovimentacao = {
          "idBeneficio" : idBeneficio,
          "operacao" : operacao,
          "qtd" : new Number(qtd).valueOf(),
          "descricao" : descricao,
          "movimentacao" : movimentacao
      };
      return objMovimentacao;
  } catch (error) {
      console.error(error.name);
      console.error(error.message);
      return undefined;    
  }
}

function validaValoresModal() {
  let qtd = document.querySelector("#quantidade").value; //number
  let movimentacao = document.querySelector("#tipoMovimentacao").value; //select
  if(qtd > 0 && (movimentacao != "SELECIONE" || movimentacao != "selecione")) {
    return true;
  }else{
    return false;
  }
}

function limpaModalAddMov() {
  document.querySelector("#quantidade").value = ''; //number
  document.querySelector("#id_beneficio").value = 0;//hidden
  document.querySelector("#operacao").value = ''; //text
  document.querySelector(".descricao").value = ''; //text
  document.querySelector("#tipoMovimentacao").options.item(0).selected = true; //select
}