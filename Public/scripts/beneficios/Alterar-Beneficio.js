//quando o formulario do modal alterar e submetido
let formAlterar = document.querySelector(".form-alterar-beneficio");
formAlterar.addEventListener("submit", function(event) {
    obterDadosModalAlterar();
    limpaModalAlterar();
    event.preventDefault();
});





