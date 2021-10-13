/**
 * Script de mostrar o modal beneficiario e tratar o modal antes de fazer uma request por ajax 
*/

//registra um manipulador de eveventos quando o formulario modal e submetido
let formAlterar = document.querySelector(".form-beneficiario");

formAlterar.addEventListener("submit", function(event) {
    let inputsForms = document.querySelectorAll(".form-control");
    let inputSelects = document.querySelectorAll(".form-select");
    inputsForms.forEach(input => {
        input.classList.add('is-valid');
    });
    inputSelects.forEach(select => {
        select.classList.add("is-valid");
    });
    //cancela o evento
    //event.preventDefault();
});



/*FORMATAÇÃO DO CAMPO DE NOMES DO MODAL*/
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


/**
 * esta funçaõ obtem dados do modal
 * @returns Object 
 */
function obterDadosModal() {
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


/*********************************FUNÇÃO DE FAZER REQUEST PARA SERVIDOR AJAX **************************/
function makeRequest(url, beneficiario = {}) { 

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
                    )
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