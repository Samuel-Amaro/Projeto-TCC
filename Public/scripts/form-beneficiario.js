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
    console.log(obterDados());
    event.preventDefault();
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

/***************Máscaras de telefones***************************/
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
function makeRequest(url, nome, cpf, telefone, email, cargo, tipo, senha) { 

    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open('POST', url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('nome=' + encodeURIComponent(nome) +    '&cpf=' + encodeURIComponent(tiraMascaraCPF(cpf)) + '&telefone=' + encodeURIComponent(tiraMascaraTel(telefone))  + '&email=' + encodeURIComponent(email) + '&cargo=' + encodeURIComponent(cargo) + '&tipo=' + encodeURIComponent(tipo)  + '&senha=' + encodeURIComponent(senha)  + '&operacao=cadastro');

    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = JSON.parse(httpRequest.responseText);  
                    mostraModal(httpResponse.computedString, "Resposta do servidor", "OK", "Sair", "sucesso");
                    return 1;
                } catch (error) {
                    mostraModal("Erro ao atualizar conta de usuário", "Atualização de usuário", "Ok", "Sair", "error");
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
    //tira R$ do renda per capita, vem valor com cifrão
    let beneficiario = {
        "primeiroNome" : document.querySelector("#inputNomePrimeiro").value,
        "ultimoNome" : document.querySelector("#inputNomeUltimo").value,
        "cpf" : tiraMascaraCPF(document.querySelector("#inputCpf").value), 
        "telefoneObrigatorio" :  tiraMascaraTel(document.querySelector("#inputFone").value),
        "telefoneOpcional" : tiraMascaraTel(document.querySelector("#inputFoneOpcional").value),  
        "cep" : document.querySelector("#inputCep").value,
        "email" : document.querySelector(".email").value,
        "endereco" : document.querySelector("#inputEndereco").value,
        "complemento" : document.querySelector("#inputComplemento").value,
        "cidade" : document.querySelector("#inputCidade").value,
        "uf" : document.querySelector("#inputEstado").value,
        "bairro" : document.querySelector("#inputBairro").value,
        "nis" : tiraMascaraCPF(document.querySelector("#inputNis").value), 
        "quantidadePeopleHome" : document.querySelector("#inputQtdPessoasHome").value,
        "rendaPerCapita" : document.querySelector("#inputRenda").value,
        "observacao" : document.querySelector(".obs").value,
        "abrangencia" : document.querySelector("#inputTipoCras").value
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