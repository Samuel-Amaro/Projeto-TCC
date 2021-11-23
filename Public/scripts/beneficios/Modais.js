function mostraModalInformation() {
    let elementoModal = document.querySelector("#modalInfoBeneficios");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function carregaDadosModalInfo(data) {
    let nomeBeneficio = document.querySelector(".nome-beneficio");
    let formaAquisicaoBenef = document.querySelector(".forma-aqu-beneficio");
    let qtdMinimaBenef = document.querySelector(".qtd-minima-beneficio");
    let qtdMaximaBenef = document.querySelector(".qtd-maxima-beneficio");
    let dataHoraBeneficio = document.querySelector(".data-hora-beneficio");
    let descricaoBeneficio = document.querySelector(".descricao-beneficio");
    let categoriaBeneficio = document.querySelector(".categoria-beneficio");
    let nomeFornecedorDoador = document.querySelector(".nome-fornecedor-doador-beneficio");
    let cpfCpnjFornecedorDoador = document.querySelector(".cpf-cnpj-fornecedor-doador-beneficio");
    let identificacaoFornecedorDoador = document.querySelector(".identificacao-fornecedor-doador");
    let tipoPessoaFornecedorDoador = document.querySelector(".tipo-pessoa-fornecedor-doador");
    let emailFornecedorDoador = document.querySelector(".email-fornecedor-doador");
    nomeBeneficio.textContent = data.nome_beneficio;
    formaAquisicaoBenef.textContent = data.forma_aquisicao_beneficio;
    qtdMinimaBenef.textContent = data.quantidade_minima_beneficio;
    qtdMaximaBenef.textContent = data.quantidade_maxima_beneficio;
    dataHoraBeneficio.textContent = formataDataHora(data.data_hora_beneficio);
    descricaoBeneficio.textContent = data.descricao_beneficio;
    categoriaBeneficio.textContent = data.nome_categoria_beneficio;
    nomeFornecedorDoador.textContent = data.nome_fornecedor_doador;
    if(data.cpf_fornecedor_doador === null || data.cpf_fornecedor_doador === '') {
       cpfCpnjFornecedorDoador.textContent = data.cnpj_fornecedor_doador; 
    }else{
        cpfCpnjFornecedorDoador.textContent = data.cpf_fornecedor_doador; 
    }
    identificacaoFornecedorDoador.textContent = data.identificacao_fornecedor_doador;
    tipoPessoaFornecedorDoador.textContent = data.tipo_pessoa_fornecedor_doador;
    emailFornecedorDoador.textContent = data.email_fornecedor_doador;
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