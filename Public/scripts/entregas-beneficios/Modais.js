function mostraModal(selectorCss) {
    let elementoModal = document.querySelector(selectorCss);
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
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

function carregaDadosModalInformation(data) {
    document.querySelector(".data-entrega").textContent = data.data_entrega_beneficio;
    document.querySelector(".qtd-entregue").textContent = data.quantidade_entregue_beneficio;
    document.querySelector(".cpf-beneficiario").textContent = data.cpf_beneficiario;
    document.querySelector(".nome-beneficiario").textContent = data.nome_completo;
    document.querySelector(".nis-beneficiario").textContent = data.nis_beneficiario;
    document.querySelector(".celular-beneficiario-01").textContent = data.celular_beneficiario_required;
    document.querySelector(".celular-beneficiario-02").textContent = data.celular_beneficiario_opcional;
    document.querySelector(".endereco-beneficiario").textContent = data.endereco_beneficiario;
    document.querySelector(".bairro-beneficiario").textContent = data.bairro_beneficiario;
    document.querySelector(".cidade-beneficiario").textContent = data.cidade_beneficiario;
    document.querySelector(".uf-beneficiario").textContent = data.uf_beneficiario;
    document.querySelector(".qtd-people-home").textContent = data.qtd_pessoas_resid_beneficiario;
    document.querySelector(".renda-per-capita-beneficiario").textContent = data.renda_per_capita_beneficiario;
    document.querySelector(".email-beneficiario").textContent = data.email_benef;
    document.querySelector(".cep-beneficiario").textContent = data.cep_benef;
    document.querySelector(".complemento-ende").textContent = data.complemento_ende_benef;
    document.querySelector(".abrangencia-cras").textContent = data.abrangencia_cras_benef;
    document.querySelector(".nome-usuario").textContent = data.nome_usuario;
    document.querySelector(".cpf-usuario").textContent = data.cpf_usuario;
    document.querySelector(".email-usuario").textContent = data.email_usuario;
    document.querySelector(".cargo-usuario").textContent = data.cargo_usuario;
    document.querySelector(".celular-usuario").textContent = data.celular_usuario;
    document.querySelector(".nome-tipo").textContent = data.nome_tipo_beneficio;
    document.querySelector(".um-beneficio").textContent = data.unidade_medida_beneficio;
    document.querySelector(".categoria-beneficio").textContent = data.categoria_beneficio;
    document.querySelector(".nome-title").textContent = data.nome_completo;
}