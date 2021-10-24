//O load evento é disparado quando a página inteira é carregada, incluindo todos os recursos dependentes, como folhas de estilo e imagens. 
window.addEventListener('load', function(event) {
    let selectElement = document.querySelector('#tipoPessoa');
    selectElement.addEventListener("change", function(event) {
        mostraCampoTipoPessoa(event.target.value);
    });
    //nome so pode 70 caracteres
    limitaCaracteresCampo(".nome-fornecedor-doador", ".feedback-nome", 70);
    //descrição so pode 300 caracteres
    limitaCaracteresCampo(".descricao-fornecedor-doador", ".feedback-descricao", 300);
    //endereco so pode 70 caracteres
    limitaCaracteresCampo("#inputEndereco", ".feedback-endereco", 70);
    //complemento so pode 30 caracteres
    limitaCaracteresCampo("#inputComplemento", ".feedback-complemento", 30);
    //bairro so pode 50 caracteres
    limitaCaracteresCampo("#inputBairro", ".feedback-bairro", 50);
    //cidade so pode 150 caracteres
    limitaCaracteresCampo("#inputCidade", ".feedback-cidade", 150);
    //email so pode 70 caracteres
    limitaCaracteresCampo("#email", ".feedback-email", 70);
    //aplicando mascara cnpj
    aplicaMascara("#cnpj", "99.999.999/9999-99");
    //aplica mascara de cpf
    aplicaMascara("#cpf", "999.999.999-99");
    //aplica mascara de telefone celular
    aplicaMascara("#telefone01", '99 99999-9999');
    //aplica mascara de telefone fixo
    aplicaMascara("#telefone02", '99 9999-9999');
});

/**
 * esta função oculta e mostra campo de cpf e cnpj de acordo com a option selecionado pelo select
 * @param {*} value 
 */
function mostraCampoTipoPessoa(value) {
    let containerCpf = document.querySelector(".container-cpf");
    let containerCNPJ = document.querySelector(".container-cnpj");
    if(value === "FISICA") {
      containerCNPJ.style.display = "none"; 
      containerCpf.style.display = "block"; 
    }else{
      containerCNPJ.style.display = "block"; 
      containerCpf.style.display = "none";
    }
}

/**
 * Esta função aplica um evento e um manipulador de evento para contar a quantidade de caracteres digitdas em um input, mostrando o feedback de quantos foram digitados
 * @param {*} htmlElementCampo 
 * @param {*} htmlElementFeedback 
 * @param {*} qtdMaximaCaracteres 
 */
function limitaCaracteresCampo(htmlElementCampo, htmlElementFeedback, qtdMaximaCaracteres) {
    let input = document.querySelector(htmlElementCampo);
    let feedback = document.querySelector(htmlElementFeedback);
    input.addEventListener("keypress", function(e) {
        let maximoCaracteres = qtdMaximaCaracteres;
        let tamanhoInput = input.value.length;
        if(tamanhoInput >= maximoCaracteres) {
            e.preventDefault();
            //input.classList.remove('is-valid');
            //input.classList.add('is-invalid');
            feedback.classList.remove(".valid-feedback");
            feedback.classList.add(".invalid-feedback");
            feedback.textContent = "Quantidade de caracteres permitidos são de no máximo " + qtdMaximaCaracteres;
        }else{
            feedback.classList.remove(".invalid-feedback");
            feedback.classList.add(".valid-feedback");
            feedback.textContent = "Qtd Caracteres Digitados: " + tamanhoInput;
        }
    });
}

/**
 * Esta função aplica uma mascara em um elemento de um formulario, ou um campo
 * @param {*} htmlElement 
 * @param {*} mascara 
 */
function aplicaMascara(htmlElement, formatoMascara) {
    let element = document.querySelector(htmlElement);
    let mascara = new Inputmask(formatoMascara);
    mascara.mask(element);
}

//Submissão do form de cadastrar fornecedor ou doador
let submitForm = document.querySelector(".form-fornecedor");
submitForm.addEventListener("submit", function(event){
    setaEstiloValidacaoCampo(".nome-fornecedor-doador", ".is-valid");
    console.log(obterDadosFormulario());
    event.preventDefault();
});

/**
 * Esta função seta uma class de validação de css, em um campo do formulario de beneficio
 * @param {*} htmlElement 
 * @param {*} classValidacao 
 */
function setaEstiloValidacaoCampo(htmlElement, classValidacao) {
    let elemento = document.querySelector(htmlElement);
    if(classValidacao == ".is-invalid"){
       elemento.classList.remove("is-valid");
       elemento.classList.add("is-invalid");
    }else{
        elemento.classList.remove("is-invalid");
        elemento.classList.add("is-valid");
    }
}

/**
 * Esta função retorna os dados que são submetidos em um formulario
 * @returns object
 */
function obterDadosFormulario() {
    let p = document.querySelector("#tipoPessoa").value;
    if(p === "FISICA") {
        let dados = {
            "nome" : document.querySelector(".nome-fornecedor-doador").value,
            //"descricao" : document.querySelector("#descricao").value,
            "tipoPessoa" : document.querySelector("#tipoPessoa").value,
            "identificacao" :  document.querySelector("#tipoIdentificacao").value,
            "cpf" : document.querySelector("#cpf").value,
            "cep" : document.querySelector("#inputCep").value,
            "endereco" : document.querySelector("#inputEndereco").value,
            "complemento" : document.querySelector("#inputComplemento").value,
            "bairro" : document.querySelector("#inputBairro").value,
            "cidade" : document.querySelector("#inputCidade").value,
            "estado" : document.querySelector("#inputEstado").value,
            "telefoneCelular" : document.querySelector("#telefone01").value,
            "telefoneFixo" : document.querySelector("#telefone02").value,
            "email" : document.querySelector("#email").value
       };
       return dados;
    }else{
        let dados = {
            "nome" : document.querySelector(".nome-fornecedor-doador").value,
            "descricao" : document.querySelector("#descricao").value,
            "tipoPessoa" : document.querySelector("#tipoPessoa").value,
            "identificacao" :  document.querySelector("#tipoIdentificacao").value,
            "cnpj" : document.querySelector("#cnpj").value,
            "cep" : document.querySelector("#inputCep").value,
            "endereco" : document.querySelector("#inputEndereco").value,
            "complemento" : document.querySelector("#inputComplemento").value,
            "bairro" : document.querySelector("#inputBairro").value,
            "cidade" : document.querySelector("#inputCidade").value,
            "estado" : document.querySelector("#inputEstado").value,
            "telefoneCelular" : document.querySelector("#telefone01").value,
            "telefoneFixo" : document.querySelector("#telefone02").value,
            "email" : document.querySelector("#email").value
       };
       return dados;
    }
}



