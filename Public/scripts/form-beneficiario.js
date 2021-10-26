let inputSubmit = document.querySelector(".form-beneficiario");

//registrando um manipulador de evento de clique neste input
//O submit evento é disparado quando um <form>é enviado.
//o form so e submetido quando todos campos required estiverem prenchidos
inputSubmit.addEventListener("submit", function(event) {
    let inputsForms = document.querySelectorAll(".form-control");
    let inputSelects = document.querySelectorAll(".form-select");
    inputsForms.forEach(input => {
        input.classList.add('is-valid');
    });
    inputSelects.forEach(select => {
        select.classList.add("is-valid");
    });
    if(makeRequestCadastrar("../controller/ControllerBeneficiario.php", obterDados()) == 1) {
       //faz nada se der certo
    }else{
        //deu erro cancela o evento submit
        //mostraModal("Ocorreu um erro interno em nosso sistema, por favor tente novamente mais tarde essa ação.", "Cadastro de beneficiário", "Ok", "Sair", "sucesso");
        //plugin de alerta bonito
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ocorreu um erro interno em nosso sistema, por favor tente novamente mais tarde essa ação.',
            footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
        });
        event.preventDefault();
    }
});


function limitaCaracteresInputNome() {
    let inputNome = document.querySelector("#inputNomePrimeiro");
    let feedbackValidNome = document.querySelector(".valid-feedback-primeiro-nome");
    inputNome.addEventListener("keypress", function(e) {
        var maxChars = 35;
        inputLength = inputNome.value.length;
        if(inputLength >= maxChars) {
            e.preventDefault();
            inputNome.classList.remove('is-valid');
            inputNome.classList.add('is-invalid');
            feedbackValidNome.textContent = "Quantidade de caracteres permitidos são de no máximo 35.";
        }else{
            inputNome.classList.remove('is-invalid');
            inputNome.classList.add('is-valid');
            feedbackValidNome.textContent = "Qtd Caracteres Digitados: " + inputLength;
        }
    });
    let inputNomeUltimo = document.querySelector("#inputNomeUltimo");
    let feedbackValidUltimoNome = document.querySelector(".valid-feedback-ultimo-nome");
    inputNomeUltimo.addEventListener("keypress", function(e) {
        var maxChars = 35;
        inputLength = inputNomeUltimo.value.length;
        if(inputLength >= maxChars) {
            e.preventDefault();
            inputNomeUltimo.classList.remove('is-valid');
            inputNomeUltimo.classList.add('is-invalid');
            feedbackValidUltimoNome.textContent = "Quantidade de caracteres permitidos são de no máximo 35.";
        }else{
            inputNomeUltimo.classList.remove('is-invalid');
            inputNomeUltimo.classList.add('is-valid');
            feedbackValidUltimoNome.textContent = "Qtd Caracteres Digitados: " + inputLength;
        }
    });
}

limitaCaracteresInputNome();

/***************Máscara de telefones***************************/
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
//Chamado depois que todos os recursos e o DOM estão totalmente carregados. NÃO será chamado quando a página for carregada do cache, como com o botão Voltar.
window.onload = function(){
	let inputTelefone = document.querySelector("#inputFone");
    inputTelefone.addEventListener("keyup", function() {
        mascara(this, mtel );
    });    
    let inputTelefoneOpcional = document.querySelector("#inputFoneOpcional");
    inputTelefoneOpcional.addEventListener("keyup", function() {
        mascara(this, mtel );
    });
}

/************************MASCARA DE CPF****************************/
$(document).ready(function(){  
    $("#inputCpf").mask("999.999.999-99");   
});

/***********************MASCARA NUMERO DO NIS*********************/
$(document).ready(function(){  
    $("#inputNis").mask("999.999.999-99");   
});

/***********************MASCARA DE RENDA POR CABEÇA**************/
$(document).ready(function() {
    $('#inputRenda').maskMoney();
});


/*********************************FUNÇÃO DE FAZER REQUEST PARA SERVIDOR AJAX **************************/

function makeRequestCadastrar(url, beneficiario = {}) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('primeiroNome=' + encodeURIComponent(beneficiario.primeiroNome) + '&ultimoNome=' + encodeURIComponent(beneficiario.ultimoNome) + '&cpf=' + encodeURIComponent(beneficiario.cpf) + '&telefoneObrigatorio=' + encodeURIComponent(beneficiario.telefoneObrigatorio) + '&telefoneOpcional=' + encodeURIComponent(beneficiario.telefoneOpcional) + '&cep=' + encodeURIComponent(beneficiario.cep) + '&email=' + encodeURIComponent(beneficiario.email) + '&endereco=' + encodeURIComponent(beneficiario.endereco) + '&complemento=' + encodeURIComponent(beneficiario.complemento) + '&cidade=' + encodeURIComponent(beneficiario.cidade) + '&estado=' + encodeURIComponent(beneficiario.uf) + '&bairro=' + encodeURIComponent(beneficiario.bairro) + '&nis=' + encodeURIComponent(beneficiario.nis) + '&qtdPessoasResidencia=' + encodeURIComponent(beneficiario.quantidadePeopleHome) + '&rendaPerCapita=' + encodeURIComponent(beneficiario.rendaPerCapita) + '&obs=' + encodeURIComponent(beneficiario.observacao) + '&abrangencia=' + encodeURIComponent(beneficiario.abrangencia) + '&operacao=' + encodeURIComponent(beneficiario.operacao) + '&id_usuario=' + encodeURIComponent(beneficiario.id_usuario));

    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = JSON.parse(httpRequest.responseText);  
                    //mostraModal(httpResponse.computedString, "Cadastro de beneficiário", "OK", "Sair", "sucesso");
                    Swal.fire(
                        'Mais um em nosso sistema',
                        'Ótimo, você acabou de cadastrar um beneficiário com sucesso!',
                        'success'
                    );
                    return 1;
                } catch (error) {
                    console.error(error.message);
                    console.error(error.name);
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                    return 0;
                }
            }else{
                //return 0;
            }
        }else{
                //alert("Ajax operação assincrona não concluida! onreadystatechange: " + httpRequest.readyState);
                //operação assincrona ajax não chegou no estagio de concluida
                //return 0;
        }
    }
}

function obterDados() {
    let beneficiario = {
        "primeiroNome" : document.querySelector("#inputNomePrimeiro").value,
        "ultimoNome" : document.querySelector("#inputNomeUltimo").value,
        "cpf" : tiraMascaraCPF(document.querySelector("#inputCpf").value), 
        "telefoneObrigatorio" :  tiraMascaraTel(document.querySelector("#inputFone").value),
        "telefoneOpcional" : tiraMascaraTel(document.querySelector("#inputFoneOpcional").value),  
        "cep" : document.querySelector("#inputCep").value,
        "email" : document.querySelector("#inputEmailOpcional").value,
        "endereco" : document.querySelector("#inputEndereco").value,
        "complemento" : document.querySelector("#inputComplemento").value,
        "cidade" : document.querySelector("#inputCidade").value,
        "uf" : document.querySelector("#inputEstado").value,
        "bairro" : document.querySelector("#inputBairro").value,
        "nis" : tiraMascaraNis(document.querySelector("#inputNis").value), 
        "quantidadePeopleHome" : document.querySelector("#inputQtdPessoasHome").value,
        "rendaPerCapita" : parseFloat((document.querySelector("#inputRenda").value).replace(",", ".")), 
        "observacao" : document.querySelector("#floatingTextarea").value,
        "abrangencia" : document.querySelector("#inputTipoCras").value,
        "operacao" : document.querySelector("#operacao").value,
        "id_usuario" : document.querySelector("input[type=\"hidden\"]#id_usuario").value
    };
    return beneficiario;
}

function tiraMascaraCPF(cpf) {
    let cpfFormatado = cpf;
    let cpfParte1 = cpf.substr(0,3); //3 DIGITOS
    //console.log("PARTE 1: " + cpfParte1);
    let cpfParte2 = cpf.substr(4, 3); //3 DIGITOS
    //console.log("PARTE 2: " + cpfParte2);
    let cpfParte3 = cpf.substr(8,3); //3 DIGITOS
    //console.log("PARTE 3: " + cpfParte3);
    let cpfParte4 = cpf.substr(12,2); //2 DIGITOS
    //console.log("PARTE 4: " + cpfParte4);
    let cpfSemFormatacao = cpfParte1 + cpfParte2 + cpfParte3 + cpfParte4;
    return cpfSemFormatacao;
}

function tiraMascaraTel(telefone) {
    let telFormatado = telefone;
    let telParte1 = telefone.substr(1,2); //DD
    let telParte2 = telefone.substr(5,5); //5 DIGITOS
    let telParte3 = telefone.substr(11,4); //4 DIGITOS
    return telParte1 + telParte2 + telParte3;
}

function tiraMascaraNis(nis) {
    let nisFormatado = nis;
    let nisParte1 = nis.substr(0,3); //3 DIGITOS
    let nisParte2 = nis.substr(4, 3); //3 DIGITOS
    let nisParte3 = nis.substr(8,3); //3 DIGITOS
    let nisParte4 = nis.substr(12,2); //2 DIGITOS
    let nisSemFormatacao = nisParte1 + nisParte2 + nisParte3 + nisParte4;
    return nisSemFormatacao;
}

/*
function mostraModal(mensagemModal, tituloModal, textBtn1, textBtn2, tipo) {
    if(tipo == "sucesso") {
        let divsModal = document.querySelectorAll(".alert-success");
        divsModal.forEach(element => {
            element.style.backgroundColor = "#d4edda";
            element.style.color = "#155724";
        });
    }else{
        let divsModal = document.querySelectorAll(".alert-warning");
        divsModal.forEach(element => {
            element.style.backgroundColor = "#f8d7da";
            element.style.color = "#721c24";
        });
    }

    let titleModal = document.querySelector(".titulo-modal");
    let btn1Modal = document.querySelector("#button-1-modal");
    let btn2Modal = document.querySelector("#button-2-modal");
    let modal = document.querySelector(".conteiner-modal");
    let span = document.querySelector(".close");
    modal.style.display = "block";
    span.addEventListener("click", function() {
        modal.style.display = "none";
    });
    window.addEventListener("click", function(event) {
        if(event.target == modal) {
            modal.style.display = "none";
        }
    });
    let p = document.querySelector(".msg-content");
    p.textContent = mensagemModal;
    titleModal.textContent = tituloModal;
    btn1Modal.textContent = textBtn1;
    btn2Modal.textContent = textBtn2;
}

*/

//O change evento é acionado para <input>, <select>e <textarea>os elementos, quando uma alteração ao valor do elemento é cometida pelo usuário. 
/********************VERIFICA SE O beneficiario QUE VAI SER CADASTRADO JA EXISTE NO SISTEMA***********************/

//regitra o manipulador de evento de mudança no input do primeiro nome
let inputCpf = document.querySelector("input[type=\"text\"]#inputCpf");
let feedbackInputCpf = document.querySelector(".valid-feedback-cpf");

inputCpf.addEventListener("change", function(event) {
    feedbackInputCpf.textContent = event.target.value; 
});

