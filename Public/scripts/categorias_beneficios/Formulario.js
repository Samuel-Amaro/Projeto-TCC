window.addEventListener("load", function(event) {
    limitaCaracteresCampo("#nomeCategoria", ".feedback-nome-categoria", 100);
    limitaCaracteresCampo("#descricaoCategoria", ".feedback-descricao", 300)
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
 * * ESTA FUNÇÃO VERIFICA SE OS CAMPOS DO FORMULARIO ESTÃO PREECHIDOS OU NÃO
 * */
function validaCampos() {
    let nome = document.querySelector("#nomeCategoria").value;
    let descricao = document.querySelector("#descricaoCategoria").value;
    if(nome === '' || descricao === '') {
        return false;
    }else{
        setaEstiloValidacaoCampo("#nomeCategoria", "is-valid");
        setaEstiloValidacaoCampo("#descricaoCategoria", "is-valid");
        return true;
    }   
}

/**
 * * Esta função obtem os dados do formulario de categorias
 * @returns object
 */
function obterDadosFormCategoria() {
    let nome = document.querySelector("#nomeCategoria").value;
    let descricao = document.querySelector("#descricaoCategoria").value;
    let categoria = {nome : nome, descricao : descricao};
    return categoria;
}

/**
 * * ESTA FUNÇÃO LIMPA CAMPOS DO FORMULARIO
 */
function limpaCamposFormCategoria() {
    let nome = document.querySelector("#nomeCategoria");
    let descricao = document.querySelector("#descricaoCategoria");
    let feedbackNome = document.querySelector(".feedback-nome-categoria");
    let feedbackDescricao = document.querySelector(".feedback-descricao");
    feedbackNome.textContent = '';
    feedbackDescricao.textContent = '';
    nome.value = '';
    descricao.value = '';
    setaEstiloValidacaoCampo("#descricaoCategoria", "remover");
    setaEstiloValidacaoCampo("#descricaoCategoria", "remover");
}