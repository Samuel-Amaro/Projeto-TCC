//O load evento é disparado quando a página inteira é carregada, incluindo todos os recursos dependentes, como folhas de estilo e imagens. 
window.addEventListener('load', function(event) {
    let selectElement = document.querySelector('#tipoPessoa');
    selectElement.addEventListener("change", function(event) {
        mostraCampoTipoPessoa(event.target.value);
    });
    //nome so pode 70 caracteres
    limitaCaracteresCampo(".nome-fornecedor-doador", ".feedback-nome", 70);
    //descrição so pode 300 caracteres
    limitaCaracteresCampo(".descricao-fornecedor-doador", ".feedback-descricao", 300);
    //endereco so pode 70 caracteres
    limitaCaracteresCampo("#inputEndereco", ".feedback-endereco", 70);
    //complemento so pode 30 caracteres
    limitaCaracteresCampo("#inputComplemento", ".feedback-complemento", 30);
    //bairro so pode 50 caracteres
    limitaCaracteresCampo("#inputBairro", ".feedback-bairro", 50);
    //cidade so pode 150 caracteres
    limitaCaracteresCampo("#inputCidade", ".feedback-cidade", 150);
    //email so pode 70 caracteres
    limitaCaracteresCampo("#email", ".feedback-email", 70);
    //aplicando mascara cnpj
    aplicaMascara("#cnpj", "99.999.999/9999-99");
    //aplica mascara de cpf
    aplicaMascara("#cpf", "999.999.999-99");
});

/**
 * esta função oculta e mostra campo de cpf e cnpj de acordo com a option selecionado pelo select
 * @param {*} value 
 */
function mostraCampoTipoPessoa(value) {
    let containerCpf = document.querySelector(".container-cpf");
    let containerCNPJ = document.querySelector(".container-cnpj");
    if(value === "FISICA") {
      containerCNPJ.style.display = "none"; 
      containerCpf.style.display = "block"; 
    }else{
      containerCNPJ.style.display = "block"; 
      containerCpf.style.display = "none";
    }
}

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
 * Esta função aplica uma mascara em um elemento de um formulario, ou um campo
 * @param {*} htmlElement 
 * @param {*} mascara 
 */
function aplicaMascara(htmlElement, formatoMascara) {
    let element = document.querySelector(htmlElement);
    let mascara = new Inputmask(formatoMascara);
    mascara.mask(element);
}
