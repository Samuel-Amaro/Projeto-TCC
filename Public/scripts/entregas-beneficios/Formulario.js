window.addEventListener("load", function(event) {
    //tipo beneficio so 150 caracteres
    limitaCaracteresCampo(".autocomplete-tipo-beneficio", ".feedback-autocomplete-tipo-beneficio", 150);
    //nome beneficiario somente 70 caracteres
    limitaCaracteresCampo("#beneficiario", ".feedback-autocomplete-nome-beneficiario", 70);
});

function limitaCaracteresCampo(htmlElementCampo, htmlElementFeedback, qtdMaximaCaracteres) {
    let input = document.querySelector(htmlElementCampo);
    let feedback = document.querySelector(htmlElementFeedback);
    input.addEventListener("keypress", function(e) {
        let maximoCaracteres = qtdMaximaCaracteres;
        let tamanhoInput = input.value.length;
        if(tamanhoInput >= maximoCaracteres) {
            feedback.classList.remove("valid-feedback");
            feedback.classList.add("invalid-feedback");
            feedback.textContent = "Quantidade de caracteres permitidos são de no máximo " + qtdMaximaCaracteres;
        }else if(tamanhoInput === 0) {
            feedback.classList.remove("valid-feedback");
            feedback.classList.add("invalid-feedback");
            feedback.textContent = "Preecha este campo por favor!";
        }else{
            feedback.classList.remove("invalid-feedback");
            feedback.classList.add("valid-feedback");
            feedback.textContent = "Quantidade de caracteres digitados foram " + tamanhoInput;
        }
    });
}

function obterDadosForm() {
    let registroEntrega = {"idTipoBeneficio" : document.querySelector("#idTipoBeneficio").value, "idBeneficiario" : document.querySelector("#idBeneficiario").value, "quantidade" : document.querySelector("#qtd").value, "nomeTipoBeneficio" : document.querySelector("#tipoBeneficio").value, "nomeBeneficiario" : document.querySelector("#beneficiario").value, "idUsuarioLogado" : document.querySelector("#id_usuario").value};
    return registroEntrega;
}

function limpaCamposForm() {
    document.querySelector("#idTipoBeneficio").value = '';
    document.querySelector("#idBeneficiario").value = '';
    document.querySelector(".autocomplete-tipo-beneficio").value = '';
    document.querySelector(".autocomplete-beneficiario").value = '';
    document.querySelector("#qtd").value = '';
}

function validaCampos() {
    let idTipoBeneficio = document.querySelector("#idTipoBeneficio").value;
    let idBeneficiario = document.querySelector("#idBeneficiario").value;
    let nomeTipoBeneficio = document.querySelector("#tipoBeneficio").value;
    let nomeBeneficiario = document.querySelector("#beneficiario").value;
    if((nomeBeneficiario.length === 0 || !nomeBeneficiario.trim()) || (nomeTipoBeneficio.length === 0 || !nomeTipoBeneficio.trim()) || (idBeneficiario === '' || idTipoBeneficio === '')) {
       return false; 
    }else{
        return true;
    }
}