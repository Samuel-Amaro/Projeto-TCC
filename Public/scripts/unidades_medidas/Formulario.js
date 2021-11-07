//registra eventos de limitar caracteres do input do form, ao carregar pagina
window.addEventListener("load", function(event) {
    limitaCaracteresCampo("#siglaUnidade", ".feedback-silga-unidade", 2);
    limitaCaracteresCampo("#descricaoUnidade", ".feedback-descricao-unidade", 50);
});

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
    let sigla = document.querySelector("#siglaUnidade");
    let descricao = document.querySelector("#descricaoUnidade");
    let feedbackSiglaUnidade = document.querySelector(".feedback-silga-unidade");
    let feedbackDescricao = document.querySelector(".feedback-descricao-unidade");
    feedbackSiglaUnidade.textContent = '';
    feedbackDescricao.textContent = '';
    sigla.value = '';
    descricao.value = '';
    setaEstiloValidacaoCampo("#siglaUnidade", "remover");
    setaEstiloValidacaoCampo("#descricaoUnidade", "remover");
}

function obterDadosForm() {
    let siglaValue = document.querySelector("#siglaUnidade").value;
    let descricaoValue = document.querySelector("#descricaoUnidade").value;
    let unidadeMedida = {sigla : siglaValue, descricao : descricaoValue};
    return unidadeMedida;
}

function validaCamposForm() {
    let siglaValue = document.querySelector("#siglaUnidade").value;
    let descricaoValue = document.querySelector("#descricaoUnidade").value;
    if((siglaValue.length === 0 || !siglaValue.trim()) || (descricaoValue.length === 0 || !descricaoValue.trim())) {
        return false;
    }else{
        return true;
    }   
}

