function mostraModalInfoForcedoresDoadores() {
    let elementoModal = document.querySelector("#modalInfoFornecedorDoador");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function mostraModalInfo(data) {
    let nome = document.querySelector(".nome");
    let indentificacao = document.querySelector(".identificacao");
    let tipoPessoa = document.querySelector(".tipo-pessoa");
    let descricao = document.querySelector(".descricao");
    let dataHora = document.querySelector(".data-hora");
    let email = document.querySelector(".email");
    let cnpj = document.querySelector(".cnpj");
    let cpf = document.querySelector(".cpf");
    let telefoneCelular = document.querySelector(".fone-celular");
    let telefoneFixo = document.querySelector(".fone-fixo");
    let endereco = document.querySelector(".endereco");
    let cep = document.querySelector(".cep");
    let cidade = document.querySelector(".cidade");
    let bairro = document.querySelector(".bairro");
    let complemento = document.querySelector(".complemento");
    let estado = document.querySelector(".uf");
    bairro.textContent = data.bairro;
    cep.textContent = data.cep;
    cidade.textContent = data.cidade;
    cnpj.textContent = data.cnpj;
    complemento.textContent = data.complemento;
    cpf.textContent = aplicaMascaraNumeroCPF(data.cpf);
    dataHora.textContent = formataDataHora(data.data_hora);
    descricao.textContent = data.descricao;
    email.textContent = data.email;
    endereco.textContent = data.email;
    indentificacao.textContent = data.identificacao;
    nome.textContent = data.nome;
    telefoneCelular.textContent = aplicaMascaraTelefone(data.telefone_celular);
    telefoneFixo.textContent = aplicaMascaraTelefone(data.telefone_fixo);
    tipoPessoa.textContent = data.telefoneFixo;
    tipoPessoa.textContent = data.tipo_pessoa;
    estado.textContent = data.uf;
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


/**
 * esta função aplica uma mascara de formatação no telefone
 * @param {} telefoneSemFormatacao 
 */
 function aplicaMascaraTelefone(telefoneSemFormatacao) { 
    if(telefoneSemFormatacao == "") {
        return "";     
    }else{
        let telefonePuro = telefoneSemFormatacao;
        let parte1 = "(" + telefonePuro.substr(0, 2) + ") "; //(##) 
        let parte2 = telefonePuro.substr(2, 5); //#####
        let parte3 = "-" + telefonePuro.substr(7, 4); //-####
        return `${parte1}${parte2}${parte3}`;
    }
}


/**
 * esta função aplica uma mascara de formatação no campo numero do cpf
 * @param {*} cpfSemFormatacao 
*/
function aplicaMascaraNumeroCPF(cpfSemFormatacao) {
    if(cpfSemFormatacao === '' || cpfSemFormatacao === null || cpfSemFormatacao === undefined) {
        //faz nada
    }else{
        return cpfSemFormatacao.substr(0, 3) + "." + cpfSemFormatacao.substr(3, 3) + "." + cpfSemFormatacao.substr(6, 3) + "-" + cpfSemFormatacao.substr(9, 2);
    }
}
