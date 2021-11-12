window.addEventListener("load", function(event) {
    //descrição so pode 70 caracteres
    limitaCaracteresCampo("#descricao-beneficio", ".feedback-descricao", 70);
    //nome so pode 70 caracteres
    limitaCaracteresCampo("#nomeBeneficio", ".feedback-nome", 70);
});


/**
 * Esta função aplica um evento e um manipulador de evento para contar a quantidade de caracteres digitdas em um input, mostrando o feedback de quantos foram digitados
 * @param {*} htmlElementCampo 
 * @param {*} htmlElementFeedback 
 * @param {*} qtdMaximaCaracteres 
 */
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

/**
 * Esta função seta uma class de validação de css, em um campo do formulario de beneficio
 * @param {*} htmlElement 
 * @param {*} classValidacao 
 */
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
        //feedbackAutocomplete.classList.remove("invalid-feedback");
        //feedbackAutocomplete.classList.add("valid-feedback");
        //campoCnpjOuCpf.classList.remove("is-invalid");
        //campoCnpjOuCpf.classList.add("is-valid");
        return {id : campoId, nome : campoNome, cnpjOuCpf: valorCnpjOuCpf};
    }
}