function mostraModal() {
    let elementoModal = document.querySelector("#modalInfoTipo");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function carregaDadosModalInfo(data) {
    document.querySelector(".nome-tipo").textContent = data.tipo;
}

function mostraModalAlterar() {
    let elementoModal = document.querySelector("#modalAlterarTipoAquisicao");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function carregaDadosModalAlterar(data) {
    document.querySelector("#tipo").value = data.tipo;
    document.querySelector("#id_tipo").value = data.id_tipo_aquisicao;
}

function validaCamposFormAlterar() {
    let tipo = document.querySelector("#tipo").value;
    if(tipo.length === 0 || !tipo.trim()) {
        return false;
    }else{
        return true;
    }   
}

function obterDadosModalAlterar() {
    let tipo = document.querySelector("#tipo").value;
    let id = document.querySelector("#id_tipo").value;
    let tipoAquisicao = {"tipo" : tipo, "id" : id};
    return tipoAquisicao;
}
