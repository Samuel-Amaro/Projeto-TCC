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
    let inputCpf = document.querySelector("#cpf");
    let containerCNPJ = document.querySelector(".container-cnpj");
    let inputCnpj = document.querySelector("#cnpj");
    if(value === "FISICA") {
      containerCNPJ.style.display = "none"; //oculta
      inputCnpj.removeAttribute("required"); //retira
      inputCpf.setAttribute("required", "required"); //aplica
      containerCpf.style.display = "block";  //mostra
    }else if(value === "JURIDICA"){
      containerCNPJ.style.display = "block"; //mostra
      containerCpf.style.display = "none"; //oculta
      inputCpf.removeAttribute("required"); //retira
      inputCnpj.setAttribute("required", "required"); //aplica
    }else{
        containerCpf.style.display = "none";
        containerCNPJ.style.display = "none";
        inputCnpj.removeAttribute("required"); //retira
        inputCpf.removeAttribute("required"); //retira
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

//campos fixos do formulario a serem verificados
//campos de texto e de select
let camposArray = [".nome-fornecedor-doador", "#tipoPessoa", "#tipoIdentificacao", "#inputEndereco", "#inputBairro", "#inputCidade", "#inputEstado", "#telefone01", "#telefone02"];

//Submissão do form de cadastrar fornecedor ou doador
let submitForm = document.querySelector(".form-fornecedor");
submitForm.addEventListener("submit", function(event){
    //array com campos do formulario invalidos
    let fieldInvalid = camposInvalidos(camposArray);
    //sem campos invalidos
    if(fieldInvalid.length === 0) {
        //aplica class css do bostratp notificando que campos estão validos
        camposArray.forEach(element => {
            setaEstiloValidacaoCampo(element, ".is-valid");
        });
        console.log(obterDadosFormulario());
        //limpara os campos do formulario apos passar 5 segundos
        let resultado = setTimeout(limpaCamposFormulario, 5000);
        event.preventDefault();
    }else{
        //possui campos invalidos    
        //aplica class css do bostrap notificando que esta invalidos
        fieldInvalid.forEach(element => {
            setaEstiloValidacaoCampo(element, ".is-invalid");  
        });
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Alguns campos não foram preenchidos, corretamente, por favor, preencha os novamente, da forma correta!',
            footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
        });
        event.preventDefault();
    }
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
    }else if(classValidacao == ".is-invalid"){
        elemento.classList.remove("is-invalid");
        elemento.classList.add("is-valid");
    }else if(classValidacao == "remover"){
        elemento.classList.remove("is-valid");
        elemento.classList.remove("is-invalid");
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
            "cpf" : tiraMascaraCPF(document.querySelector("#cpf").value),
            "cep" : document.querySelector("#inputCep").value,
            "endereco" : document.querySelector("#inputEndereco").value,
            "complemento" : document.querySelector("#inputComplemento").value,
            "bairro" : document.querySelector("#inputBairro").value,
            "cidade" : document.querySelector("#inputCidade").value,
            "estado" : document.querySelector("#inputEstado").value,
            "telefoneCelular" : tiraMascaraTel(document.querySelector("#telefone01").value, "celular"),
            "telefoneFixo" : tiraMascaraTel(document.querySelector("#telefone02").value, "fixo"),
            "email" : document.querySelector("#email").value
       };
       return dados;
    }else{
        let dados = {
            "nome" : document.querySelector(".nome-fornecedor-doador").value,
            "descricao" : document.querySelector("#descricao").value,
            "tipoPessoa" : document.querySelector("#tipoPessoa").value,
            "identificacao" :  document.querySelector("#tipoIdentificacao").value,
            "cnpj" : tiraMascaraCNPJ(document.querySelector("#cnpj").value),
            "cep" : document.querySelector("#inputCep").value,
            "endereco" : document.querySelector("#inputEndereco").value,
            "complemento" : document.querySelector("#inputComplemento").value,
            "bairro" : document.querySelector("#inputBairro").value,
            "cidade" : document.querySelector("#inputCidade").value,
            "estado" : document.querySelector("#inputEstado").value,
            "telefoneCelular" : tiraMascaraTel(document.querySelector("#telefone01").value, "celular"),
            "telefoneFixo" : tiraMascaraTel(document.querySelector("#telefone02").value, "fixo"),
            "email" : document.querySelector("#email").value
       };
       return dados;
    }
}

/**
 * * Esta Função valida os campos de uma formulario.
 * @param {*} arraySelectorsCss 
 * @returns array - com os campos invalidos
 */
function camposInvalidos(arraySelectorsCss) {
    let camposInvalidos = [];
    let camposValidos = [];
    arraySelectorsCss.forEach(element => {
        //campo com mascara, de cpf ou cnpj
        if(element == "#tipoPessoa") {
            let r = campoIdentificacaoValido();
            if(r === "cpfValido") {
               //cpf valido, inseri no array dos campos para aplicar classe css
               camposArray.push("#cpf");
            }else if(r === "cnpjValido") {
               //cnpj valido, inseri no array dos campos para aplicar classe css
               camposArray.push("#cnpj");
            }else{
               //cpf ou cnpj invalido
               camposInvalidos.push(r);
            }
        }else if(element == "#telefone01") {
            //campo com mascara de telefone celular
            let telefoneCelular = document.querySelector("#telefone01").value;
            let telefoneCelularPuro = tiraMascaraTel(telefoneCelular, "celular");
            if(telefoneCelularPuro.length < 11) {
               camposInvalidos.push("#telefone01"); 
            }else{
                //camposArray.push("#telefone01");
            }
        }else if(element == "#telefone02") {
            //campo com mascara de telefone celular
            let telefoneFixo = document.querySelector("#telefone02").value;
            let telefoneFixoPuro = tiraMascaraTel(telefoneFixo, "fixo");
            if(telefoneFixoPuro.length < 10) {
               camposInvalidos.push("#telefone02"); 
            }else{
                //camposArray.push("#telefone02");
            }
        }else{
            let elementHtml = document.querySelector(element).value;
            if(elementHtml === "" || elementHtml === " " || elementHtml === "SELECIONE") {
                camposInvalidos.push(element); 
            }else{
                camposValidos.push(element);
            }    
        }
    });
    return camposInvalidos;  
}

/**
 * Verifica se o campo de identificação de pessoa escolheu um tipo de pessoa, e aplica um tipo de valição visual e com js sobre o campo escolhido como o cpf ou cnpj
 * @returns 
 */
function campoIdentificacaoValido() {
    let tipoPessoa = document.querySelector("#tipoPessoa").value;
    if(tipoPessoa == "FISICA") {
       let cpf = document.querySelector("#cpf").value;
       let cpfSemFormatacao = tiraMascaraCPF(cpf);
       if(cpfSemFormatacao.length < 11) {
          console.log(cpfSemFormatacao);
          return "#cpf"; 
       }else{
          return "cpfValido";
       }    
    }else if(tipoPessoa === "JURIDICA"){
        let cnpj = document.querySelector("#cnpj").value;
        let cnpjSemFormatacao = tiraMascaraCNPJ(cnpj);
        if(cnpjSemFormatacao.length < 14) {
           return "#cnpj"; 
        }else{
            return "cnpjValido";
        }
    }else{
        return "#tipoPessoa";
    }
}

/**
 * Esta função tira mascara de cpf
 * @param {*} cpf 
 * @returns 
 */
function tiraMascaraCPF(cpf) {
    let cpfFormatado = cpf;
    let cpfParte1 = cpf.substr(0,3); //3 DIGITOS
    let cpfParte2 = cpf.substr(4, 3); //3 DIGITOS
    let cpfParte3 = cpf.substr(8,3); //3 DIGITOS
    let cpfParte4 = cpf.substr(12,2); //2 DIGITOS
    let cpfSemFormatacao = cpfParte1 + cpfParte2 + cpfParte3 + cpfParte4;
    let cpfStr = '';
    //apos tira a mascara verificar se o cpf, esta completo, com toda numeração
    for (let index = 0; index < cpfSemFormatacao.length; index++) {
        if(cpfSemFormatacao[index] === "_") {
            //faz nada
        }else{
            cpfStr = cpfStr + cpfSemFormatacao[index];
        }
    }
    return cpfStr;
}

/**
 * Esta Função tira a mascara de cnpj de um cnpj formatado
 * @param {*} cnpj 
 * @returns 
 */
function tiraMascaraCNPJ(cnpj) {
    let cnpjFormatado = cnpj;
    let parte1 = cnpjFormatado.substr(0,2); //XX
    let parte2 = cnpjFormatado.substr(3, 3);//XXX
    let parte3 = cnpjFormatado.substr(7, 3); //XXX
    let parte4 = cnpjFormatado.substr(11, 4);//XXXX
    let parte5 = cnpjFormatado.substr(16, 2); //XX
    let cnpjSemFormatacao =  parte1 + parte2 + parte3 + parte4 + parte5;
    //verificar se o cnpj esta com a numeração completa
    let cnpjPuro = '';
    for (let index = 0; index < cnpjSemFormatacao.length; index++) {
        if(cnpjSemFormatacao[index] === "_") {
            //faz nada, caracteres invalidos estão compondo o cnpj
        }else{
            cnpjPuro = cnpjPuro + cnpjSemFormatacao[index];
        }
    }
    return cnpjPuro;
}

/**
 * Esta função tira a mascara de telefones, tanto telefone celular quanto fixo, so informa o tipo
 * @param {*} telefone 
 * @param {*} tipo 
 * @returns 
 */
function tiraMascaraTel(telefone, tipo) {
    if(tipo === "celular") {
        let telFormatado = telefone;
        let telParte1 = telefone.substr(0,2); //DD
        let telParte2 = telefone.substr(3,5); //99999
        let telParte3 = telefone.substr(9,4); //9999
        //verificar se o telefone sem formatação contém a quantidade de numeros correta
        let telSemFormatacao = telParte1 + telParte2 + telParte3;
        let telefonePuro = '';
        for (let index = 0; index < telSemFormatacao.length; index++) {
            if(telSemFormatacao[index] === "_") {
               //telefone sem formatação contem caracteres da mascara invalido 
            }else{
               //numeros corretos
               telefonePuro = telefonePuro + telSemFormatacao[index]; 
            }    
        }
        return telefonePuro;
    }else{
        let telFixoFormatado = telefone;
        let telParte1 = telFixoFormatado.substr(0, 2); //DD
        let telParte2 = telFixoFormatado.substr(3, 4); //9999
        let telParte3 = telFixoFormatado.substr(8, 4); //9999 
        let telFixoSemFormatacao = telParte1 + telParte2 + telParte3;
        //verificar se o telefone sem formatação contém a quantidade de numeros correta
        let telFixoPuro = '';
        for (let index = 0; index < telFixoSemFormatacao.length; index++) {
            if(telFixoSemFormatacao[index] === "_") {
               //telefone sem formatação contem caracteres da mascara invalido 
            }else{
               //numeros corretos
               telFixoPuro = telFixoPuro + telFixoSemFormatacao[index]; 
            }    
        }
        return telFixoPuro;
    }
}

/**
 * Esta função limpa os campos do formulario
 */
function limpaCamposFormulario() {
    let nome = document.querySelector(".nome-fornecedor-doador");
    let descricao = document.querySelector("#descricao");
    let identificacao = document.querySelector("#tipoIdentificacao");
    let tipoPessoa = document.querySelector("#tipoPessoa");
    let cep = document.querySelector("#inputCep");
    let endereco = document.querySelector("#inputEndereco");
    let complemento = document.querySelector("#inputComplemento");
    let bairro =  document.querySelector("#inputBairro");
    let cidade  = document.querySelector("#inputCidade");
    let estado = document.querySelector("#inputEstado");
    let telefoneCelular = document.querySelector("#telefone01");
    let telefoneFixo = document.querySelector("#telefone02");
    let email = document.querySelector("#email");
    nome.value = '';
    descricao.value = '';
    identificacao.options.item(0).selected = true;
    tipoPessoa.options.item(0).selected = true;
    cep.value = '';
    endereco.value = '';
    complemento.value = '';
    bairro.value = '';
    cidade.value = '';
    estado.options.item(0).selected = true;
    telefoneCelular.value = '';
    telefoneFixo.value = '';
    email.value = '';
    //faz os atributos de endereço serem editaveis
    endereco.removeAttribute("readonly");
    complemento.removeAttribute("readonly");
    bairro.removeAttribute("readonly");
    cidade.removeAttribute("readonly");
    estado.setAttribute("disabled", false);
    //tira class css dos elementos
    let arraySelector = [".nome-fornecedor-doador", "#descricao", "#tipoIdentificacao", "#tipoPessoa", "#inputCep", "#inputEndereco", "#inputComplemento", "#inputBairro", "#inputCidade", "#inputEstado" ,"#telefone01", "#telefone02", "#email"];
    arraySelector.forEach(element => {
        setaEstiloValidacaoCampo(element, "remover");
    });
}