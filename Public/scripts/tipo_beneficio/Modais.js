function mostraModal(selectCssModal) {
    let elementoModal = document.querySelector(selectCssModal);
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function carregaDadosModal(tipo_modal, data) {
    if(tipo_modal === "INFORMATION") {
       let tipoBeneficio = document.querySelector(".nome-tipo");
       let um = document.querySelector(".um");
       let cat = document.querySelector(".cat");
       let dataHora = document.querySelector(".data-hora");
       tipoBeneficio.textContent = data.nome_tipo;
       um.textContent = data.sigla;
       cat.textContent = data.nome;
       dataHora.textContent = formataDataHora(data.data_hora);
    }else if(tipo_modal === "ALTER") {
        let tipoBeneficio = document.querySelector("#tipoBeneficioModal");
        let umModal = document.querySelector("#umModal");
        let categoria = document.querySelector("#categoria");
        let idTipoBeneficio = document.querySelector("#id_tipo_beneficio");
        idTipoBeneficio.value = data.id_tipo_beneficio;
        tipoBeneficio.value = data.nome_tipo;
        //add o valor de um escolhido anteriormente no select atual
        let arrayOptionsUm = [];
        for (let index = 0; index < umModal.options.length; index++) {
            arrayOptionsUm.push(umModal.options.item(index).value);
            if(umModal.options.item(index).value == data.id_unidade) {
               umModal.options.item(index).selected = true;  
            }
        }
        //add o valor de categoria escolhido anteriormente no select atual
        let arrayOptionsCat = [];
        for (let index = 0; index < categoria.options.length; index++) {
            arrayOptionsCat.push(categoria.options.item(index).value);
            if(categoria.options.item(index).value == data.id_categoria) {
               categoria.options.item(index).selected = true; 
            }
        }
    }
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

function obterDadosModalAlterar() {
    let tipoBeneficio = document.querySelector("#tipoBeneficioModal").value;
    let umModal = document.querySelector("#umModal").value;
    let categoria = document.querySelector("#categoria").value;
    let idTipoBeneficio = document.querySelector("#id_tipo_beneficio").value;
    let tipoBeneficioObj = {"nomeBeneficio" : tipoBeneficio, "idUnidadeMedida" : umModal, "idCategoriaBeneficio" : categoria, "id" : idTipoBeneficio};
    return tipoBeneficioObj;
}

function validaCamposModal() {
    let tipoBeneficio = document.querySelector("#tipoBeneficioModal").value;
    let umModal = document.querySelector("#umModal").value;
    let categoria = document.querySelector("#categoria").value;
    if((tipoBeneficio.length === 0 || !tipoBeneficio.trim()) || (umModal === "SELECIONE" || umModal === "selecione") || (categoria === "SELECIONE" || categoria === "selecione")) {
        return false;
    }else{
        return true;
    }   
}

function limpaCamposModalAlterar() {
    document.querySelector("#tipoBeneficioModal").value = '';
    document.querySelector("#umModal").options.item(0).selected = true;
    document.querySelector("#categoria").options.item(0).selected = true;
    document.querySelector("#id_tipo_beneficio").value = '';
}