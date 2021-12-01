//quando o formulario de add movimentação de beneficio e add
let formAddMovimentacao = document.querySelector(".form-add-movimentacao");
formAddMovimentacao.addEventListener("submit", function(event) {
    obterDadosModalAddMovimentacao();
    limpaModalAddMov();
    event.preventDefault();
});