
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