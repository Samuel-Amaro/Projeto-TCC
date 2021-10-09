let inputSubmitForm = document.querySelector("#form-alterar-usuario");

//REGITRA UM MANIPULADOR DE EVENTO NO FORMULARIO 
//EVENTO DE SUBMISSÃO DE FORMULARIO
inputSubmitForm.addEventListener("submit", function(event) {
    //realizar atualização do usuario por meio do ajax
    let nome = document.querySelector('#inputNome').value;
    //let cpf = document.querySelector('input[type=\"text\"]#cpf').value;
    let telefone = document.querySelector('#inputTelefone').value;
    let email = document.querySelector('#inputEmail').value;
    let cargo = document.querySelector('#inputCargo').value;
    let tipo = document.querySelector('#selectTipoUsuario').value;
    let senha = document.querySelector('#inputPassword').value;
    let id = document.querySelector("#id_usuario").value;
    let hashSenha = document.querySelector("#hash_senha").value;
    
        if(makeRequest("../controller/ControllerUsuario.php", nome, telefone, email, cargo, tipo, senha, id, hashSenha) === 1) {
            //event.preventDefault();
        }else{
            //mostra modal com erro
            //mostraModal("Usuario não atualizado!", "usuario não atualizado, obtemos um erro no nosso sistema, agurde uns instantes e tente novamente mais tarde!", "OK", "Sair", "error");
            event.preventDefault();
        }
});

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
        window.location = "../../index.php";
    });
    /*
    btn2Modal.addEventListener("click", function(){
        modal.style.display = "none";
        window.location = "../../index.php";
    });
    btn1Modal.addEventListener("click", function(){
        modal.style.display = "none";
        window.location = "../../index.php";
    });
    */
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

/*mascara de cpf*/
$(document).ready(function(){  
    $("#inputCpf").mask("999.999.999-99");   
});

/* Máscaras de telefone*/
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

function id( el ){
	return document.getElementById( el );
}

window.onload = function(){
	id('inputTelefone').onkeyup = function(){
		mascara( this, mtel );
	}
}

function tiraMascaraTel(telefone) {
    let telFormatado = telefone;
    let telParte1 = telefone.substr(1,2); //DD
    let telParte2 = telefone.substr(5,5); //5 DIGITOS
    let telParte3 = telefone.substr(11,4); //4 DIGITOS
    return telParte1 + telParte2 + telParte3;
}

//REGISTRANDO EVENTO QUE LIMITA CARACTERES DO INPUT NOME
//alert-limit-caracteres-nome
let alertNome = document.querySelector('.alert-limit-caracteres-nome');
let inputNome = document.querySelector('#inputNome');
inputNome.addEventListener("keypress", function(e) {
    var maxChars = 70;
    inputLength = inputNome.value.length;
    if(inputLength >= maxChars) {
        e.preventDefault();
        alertNome.style.display = "block";
        alertNome.textContent = "Quantidade de caracteres permitidos são de no máximo 70 para o campo de nome.";
    }else{
        alertNome.style.display = "none";
        //spanLimit.textContent = "Qtd Caracteres Digitados: " + inputLength;
    }
});

//REGISTRANDO EVENTO QUE LIMITA CARACTERES DO INPUT CARGO OU FUNÇÃO
let alertCargo = document.querySelector('.alert-limit-caracteres-cargo');
let inputCargo = document.querySelector('#inputCargo');
inputCargo.addEventListener("keypress", function(e) {
    var maxChars = 100;
    inputLength = inputCargo.value.length;
    if(inputLength >= maxChars) {
        e.preventDefault();
        alertCargo.style.display = "block";
        alertCargo.textContent = "Quantidade de caracteres permitidos são de no máximo 100 para o campo de cargo ou função";
    }else{
        alertCargo.style.display = "none";
        //spanLimit.textContent = "Qtd Caracteres Digitados: " + inputLength;
    }
});

function makeRequest(url, nome, telefone, email, cargo, tipo, senha, id, hashSenhaAntiga) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open('POST', url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('nome=' + encodeURIComponent(nome) + '&telefone=' + encodeURIComponent(tiraMascaraTel(telefone))  + '&email=' + encodeURIComponent(email) + '&cargo=' + encodeURIComponent(cargo) + '&tipo=' + encodeURIComponent(tipo)  + '&senha=' + encodeURIComponent(senha)  + '&operacao=atualizar' + '&id=' + encodeURIComponent(id) + '&hashSenhaAntiga=' + encodeURIComponent(hashSenhaAntiga));

    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = JSON.parse(httpRequest.responseText);  
                    mostraModal(httpResponse.computedString, "Atualização de conta de usuário", "OK", "Sair", "sucesso");
                    //console.log(httpRequest.responseText);
                    return 1;
                } catch (error) {
                    console.error(error.message);
                    console.error(error.name);
                    //mostraModal(httpRequest.responseText, "Atualização de conta de usuário não efetuada", "OK", "Sair", "sucesso");
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