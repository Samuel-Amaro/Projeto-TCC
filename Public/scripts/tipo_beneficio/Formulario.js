//registra eventos de limitar caracteres do input do form, ao carregar pagina
window.addEventListener("load", function(event) {
    limitaCaracteresCampo("#nomeBeneficio", ".feedback-nomeBeneficio", 150);
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
    let nomeBeneficio = document.querySelector("#nomeBeneficio"); //nome beneficio
    let unidadeMedida = document.querySelector("#unidadeMedida"); //id unidade medida
    let categoriaBeneficio = document.querySelector("#categoriaBeneficio"); //id categoria
    let feedbackNomeBeneficio = document.querySelector(".feedback-nomeBeneficio");
    feedbackNomeBeneficio.textContent = '';
    nomeBeneficio.value = '';
    unidadeMedida.options.item(0).selected = true;
    categoriaBeneficio.options.item(0).selected = true;
    //setaEstiloValidacaoCampo("#tipoAqui", "remover");
    //setaEstiloValidacaoCampo(".feedback-tipo", "remover");
}

function obterDadosForm() {
    let nomeBeneficio = document.querySelector("#nomeBeneficio").value;
    let unidadeMedida = document.querySelector("#unidadeMedida").value;
    let categoriaBeneficio = document.querySelector("#categoriaBeneficio").value;
    let tipoBeneficio = {"nomeBeneficio" : nomeBeneficio, "idUnidadeMedida" : unidadeMedida, "idCategoriaBeneficio" : categoriaBeneficio};
    return tipoBeneficio;
}

function validaCamposForm() {
    let nomeBeneficio = document.querySelector("#nomeBeneficio").value;
    let unidadeMedida = document.querySelector("#unidadeMedida").value;
    let categoriaBeneficio = document.querySelector("#categoriaBeneficio").value;
    if((nomeBeneficio.length === 0 || !nomeBeneficio.trim()) || (unidadeMedida === "SELECIONE" || unidadeMedida === "selecione") || (categoriaBeneficio === "SELECIONE" || categoriaBeneficio === "selecione")) {
        return false;
    }else{
        return true;
    }   
}

