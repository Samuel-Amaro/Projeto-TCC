$(document).ready(function(){  
    $("#cpf").mask("999.999.999-99");   
});

/* Máscaras ER */
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
	id('telefone').onkeyup = function(){
		mascara( this, mtel );
	}
}

let inputSubmitForm = document.querySelector("#form_usuario");

inputSubmitForm.addEventListener("submit", function(event) {
    //realiza o cadastro do usuario por meio de ajax
    let nome = document.querySelector('input[type=\"text\"]#nome').value;
    let cpf = document.querySelector('input[type=\"text\"]#cpf').value;
    let telefone = document.querySelector('input[type=\"text\"]#telefone').value;
    let email = document.querySelector('input[type=\"email\"]#email').value;
    let cargo = document.querySelector('input[type=\"text\"]#cargo').value;
    let tipo = document.querySelector('select#tipo').value;
    let senha = document.querySelector('input[type=\"password\"]#senha').value;
    //console.log(nome + " " + tiraMascaraCPF(cpf) + " " + tiraMascaraTel(telefone) + " " + email + " " + cargo + " " + tipo + " " + senha);
    if(makeRequest("../controller/ControllerUsuario.php", nome, cpf, telefone, email, cargo, tipo, senha) === 1) {
       event.preventDefault();
    }else{
        //mostra modal com erro
         mostraModal("Formulario não enviado!", "usuario não cadastrado, obtemos um erro no nosso sistema, agurde uns instantes e tente novamente mais tarde!", "OK", "Sair", "error");
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
    let telFormatado = cpf;
    let telParte1 = telefone.substr(1,2); //DD
    let telParte2 = telefone.substr(5,5); //5 DIGITOS
    let telParte3 = telefone.substr(11,4); //4 DIGITOS
    return telParte1 + telParte2 + telParte3;
}


//limita caracters do input nome
var inputNome = document.querySelector("#nome");
var spanLimit = document.querySelector(".limit-char");
inputNome.addEventListener("keypress", function(e) {
    var maxChars = 70;
    inputLength = inputNome.value.length;
    if(inputLength >= maxChars) {
        e.preventDefault();
        mostraModal("Quantidade de caracteres permitidos são de no maximo 70", "Limite de caracteres permitdos atingido", "Ok", "Sair", "warning");
    }else{
        //spanLimit.textContent = "Qtd Caracteres Digitados: " + inputLength;
    }
});

//limita quantidade de caractes do campo cargo ou função
let inputCargo = document.querySelector("#cargo");
let spanLimitCargo = document.querySelector(".limit-char-cargo");
inputCargo.addEventListener("keypress", function(e) {
    var maxChars = 100;
    inputLength = inputCargo.value.length;
    if(inputLength >= maxChars) {
        e.preventDefault();
        mostraModal("Quantidade de caracteres permitidos são de no maximo 100", "Limite de caracteres permitdos atingido", "Ok", "Sair", "warning");
    }else{
        //spanLimitCargo.textContent = "Qtd Caracteres Digitados: " + inputLength;
    }
});