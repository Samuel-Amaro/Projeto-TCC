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
    event.preventDefault();
});


function limitaCaracteresInputNome() {
    let inputNome = document.querySelector("#inputNome");
    let feedbackValidNome = document.querySelector(".valid-feedback-nome");
    inputNome.addEventListener("keypress", function(e) {
        var maxChars = 70;
        inputLength = inputNome.value.length;
        if(inputLength >= maxChars) {
            e.preventDefault();
            inputNome.classList.remove('is-valid');
            inputNome.classList.add('is-invalid');
            feedbackValidNome.textContent = "Quantidade de caracteres permitidos são de no máximo 70.";
        }else{
            inputNome.classList.remove('is-invalid');
            inputNome.classList.add('is-valid');
            feedbackValidNome.textContent = "Qtd Caracteres Digitados: " + inputLength;
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