//registra eventos de limitar caracteres do input do form, ao carregar pagina
window.addEventListener("load", function(event) {
    limitaCaracteresCampoTipo("#tipoAqui", ".feedback-tipo", 100);
});

function limitaCaracteresCampoTipo(htmlElementCampo, htmlElementFeedback, qtdMaximaCaracteres) {
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

function limpaCamposForm() {
    let tipo = document.querySelector("#tipoAqui");
    let feedbackTipo = document.querySelector(".feedback-tipo");
    feedbackTipo.textContent = '';
    tipo.value = '';
    setaEstiloValidacaoCampo("#tipoAqui", "remover");
    setaEstiloValidacaoCampo(".feedback-tipo", "remover");
}

function obterDadosForm() {
    let tipo = document.querySelector("#tipoAqui").value;
    let tipoAquisicao = {"tipo" : tipo};
    return tipoAquisicao;
}

function validaCamposForm() {
    let tipo = document.querySelector("#tipoAqui").value;
    if(tipo.length === 0 || !tipo.trim()) {
        return false;
    }else{
        return true;
    }   
}

