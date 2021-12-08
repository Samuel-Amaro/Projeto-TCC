window.addEventListener("load", function(event) {
    //descrição so pode 300 caracteres
    limitaCaracteresCampo("#descricao-beneficio", ".feedback-descricao", 300);
});

function limitaCaracteresCampo(htmlElementCampo, htmlElementFeedback, qtdMaximaCaracteres) {
    let input = document.querySelector(htmlElementCampo);
    let feedback = document.querySelector(htmlElementFeedback);
    input.addEventListener("keypress", function(e) {
        let maximoCaracteres = qtdMaximaCaracteres;
        let tamanhoInput = input.value.length;
        if(tamanhoInput >= maximoCaracteres) {
            //e.preventDefault();
            //input.classList.remove('is-valid');
            //input.classList.add('is-invalid');
            feedback.classList.remove("valid-feedback");
            feedback.classList.add("invalid-feedback");
            feedback.textContent = "Quantidade de caracteres permitidos são de no máximo " + qtdMaximaCaracteres;
        }else if(tamanhoInput === 0) {
            //input.classList.remove('is-valid');
            //input.classList.add('is-invalid');
            feedback.classList.remove("valid-feedback");
            feedback.classList.add("invalid-feedback");
            feedback.textContent = "Preecha este campo por favor!";
        }else{
            //input.classList.remove('is-invalid');
            //input.classList.add('is-valid');
            feedback.classList.remove("invalid-feedback");
            feedback.classList.add("valid-feedback");
            feedback.textContent = "Quantidade de caracteres digitados foram " + tamanhoInput;
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

/**
 * * Esta função obtem os dados informados no autocomplete
 * @returns object
 */
function obterDadosFornecedorDoador() {
    let campoId = document.querySelector("#idFornDoador").value;
    let campoNome = document.querySelector("#nomeFornDoador").value;
    let campoCnpjOuCpf = document.querySelector("#autoCompleteFornecedorDoador");  
    let valorCnpjOuCpf = document.querySelector("#autoCompleteFornecedorDoador").value;
    let feedbackAutocomplete = document.querySelector(".feedback-autocomplete");  
    //se o campo cpf ou cnpj estiver vazio
    if((valorCnpjOuCpf.length === 0 || !valorCnpjOuCpf.trim()) || valorCnpjOuCpf === '') {
        feedbackAutocomplete.classList.remove("valid-feedback");
        feedbackAutocomplete.classList.add("invalid-feedback");
        campoCnpjOuCpf.classList.remove("is-valid");
        campoCnpjOuCpf.classList.add("is-invalid");
        return false;
    }else{
        return {id : campoId, nome : campoNome, cnpjOuCpf: valorCnpjOuCpf};
    }
}

function validaCamposForm() {
    let descricaoBeneficio = document.querySelector("#descricao-beneficio").value;
    let tipoBeneficio = document.querySelector("#tipoBeneficio").value;
    let tipoAquisicao = document.querySelector("#tipoAquisicao").value;
    let qtd = document.querySelector("#qtd").value;
    if((tipoBeneficio === "SELECIONE" || tipoBeneficio === "selecione") || (tipoAquisicao === "SELECIONE" || tipoAquisicao === "selecione") || (qtd < 0 || qtd === 0)) {
        return false;
    }else{
        return true;
    }
}

function obterDadosBeneficio() {
    let beneficio = {"descricaoBeneficio" : document.querySelector("#descricao-beneficio").value, "idTipoBeneficio" : document.querySelector("#tipoBeneficio").value, "idTipoAquisicao" : document.querySelector("#tipoAquisicao").value, "quantidade" : document.querySelector("#qtd").value};
    return beneficio;
}

function limpaCamposForm() {
    document.querySelector(".descricao-beneficio").value = '';
    document.querySelector("#tipoAquisicao").options.item(0).selected = true;
    document.querySelector("#tipoBeneficio").options.item(0).selected = true;
    document.querySelector("#qtd").value = '';
    document.querySelector("#autoCompleteFornecedorDoador").value = '';
    document.querySelector("#idFornDoador").value = '';
    document.querySelector("#nomeFornDoador").value = '';
}
