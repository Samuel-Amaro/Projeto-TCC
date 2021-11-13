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

/**
 * * Esta função valida os campos do formulario de cadastrar beneficio
 * 
 * retorna os campos invalidos para serem tratados antes de ser submetidos
 * 
 * @param {*} seletoresCssCampos 
 * @returns array
 */
function validaCamposForm(seletoresCssCampos = []) {
    let camposInvalidos = [];
    let camposValidos = [];
    if(seletoresCssCampos.length === 0) {
       //array vazio sem campos a validar
       return false; 
    }else{
        seletoresCssCampos.forEach(element => {
            //valida selects
            if(element === "#categoriaBeneficio" || element === "#formaAquisicao" || element === "#unidadeMedida") {
                let valor = document.querySelector(element).value;
                if(valor === "SELECIONE" || valor === "selecione" || valor === "Nenhuma Unidade disponivel") {
                    camposInvalidos.push(element);
                }else{
                    camposValidos.push(element);
                }
            }//valida input type="text"
            else if(element === "#descricao-beneficio" || element === "#nomeBeneficio") {
                let valor = document.querySelector(element).value;
                if((valor.length === 0 || !valor.trim()) || valor === '') {
                    camposInvalidos.push(element);
                }else{
                    camposValidos.push(element);
                }
            }//valida os input type="number"
            else if(element === "#qtdTotal" || element === "#qtdPorMedida" || element === "#qtdMaxima" || element === "#qtdMinima"){
                let valor = document.querySelector(element).value;
                if(valor >= 1) {
                   camposValidos.push(element); 
                }else{
                    camposInvalidos.push(element);
                }
            }
        });
        return camposInvalidos;
    }
    /*let campoDescricao = document.querySelector("#descricao-beneficio"); //type="text"
    let campoNome = document.querySelector("#nomeBeneficio"); //type="text"
    let campoCategoria = document.querySelector("#categoriaBeneficio"); //select
    let campoFormaAquisicao = document.querySelector("#formaAquisicao"); //select 
    let campoQtdTotal = document.querySelector("#qtdTotal"); //type = "number"
    let campoUnidadeMedida = document.querySelector("#unidadeMedida"); //select
    let campoQtdPorMedida = document.querySelector("#qtdPorMedida"); //type="number"
    let campoQtdMaxima = document.querySelector("#qtdMaxima"); //type="number"
    let campoQtdMinima = document.querySelector("#qtdMinima"); //type="number"
    */
}


/**
 * Esta função obtem os dados submitidos do formulario do beneficio
 * @returns json
 */
 function obterDadosBeneficio() {
    let beneficio = {
        "descricaoBeneficio" : document.querySelector(".descricao-beneficio").value,
        "nomeBeneficio" : document.querySelector("#nomeBeneficio").value,  
        "categoriaBeneficio" : document.querySelector("#categoriaBeneficio").value, 
        "formaAquisicao" : document.querySelector("#formaAquisicao").value,
        "quantidadeTotal" : document.querySelector("#qtdTotal").value,
        "unidadeMedida" : document.querySelector("#unidadeMedida").value,
        "quantidadePorMedida" : document.querySelector("#qtdPorMedida").value,
        "quantidadeMinima" : document.querySelector("#qtdMinima").value,
        "quantidadeMaxima" : document.querySelector("#qtdMaxima").value
    };
    return beneficio;
}

/**
 * Esta função limpa campos do formulario
 */
function limpaCamposForm() {
    document.querySelector(".descricao-beneficio").value = '';
    document.querySelector("#nomeBeneficio").value = '';
    document.querySelector("#categoriaBeneficio").options.item(0).selected = true;
    document.querySelector("#formaAquisicao").options.item(0).selected = true;
    document.querySelector("#qtdTotal").value = '';
    document.querySelector("#unidadeMedida").options.item(0).selected = true;
    document.querySelector("#qtdPorMedida").value = '';
    document.querySelector("#qtdMinima").value = '';
    document.querySelector("#qtdMaxima").value = '';
    document.querySelector("#autoCompleteFornecedorDoador").value = '';
    document.querySelector("#idFornDoador").value = '';
    document.querySelector("#nomeFornDoador").value = '';
}

/*
let btcCadastrarBeneficios = document.querySelector(".btn-cadastrar-beneficio");
btcCadastrarBeneficios.addEventListener("click", function(envet) {
    obterBeneficiosACadastrar();
});*/