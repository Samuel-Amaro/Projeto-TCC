function mostraModalInfoBeneficiario() {
    let elementoModal = document.querySelector("#modalInfoBeneficiario");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function carregaDadosModalInfoBeneficiario(data) {
    let nome = document.querySelector(".nome-beneficiario");
    let obs = document.querySelector(".obs-beneficiario");
    let renda = document.querySelector(".renda-beneficiario");
    let qtdHome = document.querySelector(".qtd-pessoa-home-beneficiario");
    let nis = document.querySelector(".numero-nis-beneficiario");
    let uf = document.querySelector(".uf-beneficiario");
    let cidade = document.querySelector(".cidade-beneficiario");
    let bairro = document.querySelector(".bairro-beneficiario");
    let endereco = document.querySelector(".endereco-beneficiario");
    let celular = document.querySelector(".celular-beneficiario");
    let telefone = document.querySelector(".telefone-beneficiario");
    let dataHora = document.querySelector(".data-hora-insercao-beneficiario");
    let cpf = document.querySelector(".cpf-beneficiario");
    let cep = document.querySelector(".cep-beneficiario");
    let complementoEndereco = document.querySelector(".complemento-endereco-beneficiario");
    let abrangenciaCras = document.querySelector(".abrangencia-cras-beneficiario");
    let email = document.querySelector(".email-beneficiario");
    abrangenciaCras.textContent = data.abrangencia_cras;
    bairro.textContent = data.bairro;
    celular.textContent = aplicaMascaraTelefone(data.celular_opcional);
    telefone.textContent = aplicaMascaraTelefone(data.celular_required);
    cep.textContent = data.cep;
    cidade.textContent = data.cidade;
    complementoEndereco.textContent = data.complemento_ende;
    cpf.textContent = aplicaMascaraNumeroNis(data.cpf);
    email.textContent = data.email;
    endereco.textContent = data.endereco;
    nis.textContent = aplicaMascaraNumeroNis(data.nis);
    nome.textContent = data.primeiro_nome + data.ultimo_nome;
    qtdHome.textContent = data.qtd_pessoas_home;
    renda.textContent = data.renda;
    uf.textContent = data.uf;
}