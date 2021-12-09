//submit form de add movimentação do beneficio
let formAddMov = document.querySelector(".form-add-movimentacao");
formAddMov.addEventListener("submit", function(event) {
    event.preventDefault();
    if(validaValoresModal()) {
        if(makeRequestEstoque("../controller/ControllerMovimentacoesEstoque.php", obterDadosModalAddMovimentacao(), "INSERIR") === 1) {
            //se der certo faz nada    
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Obtemos um erro ao adicionar a movimentação no estoque, tente esta ação novamente mais tarde por favor.'
            }); 
        }
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Por favor, preencha os campos corretamente, para que a movimentação no estoque possa ser efetuada.'
        });
    }
});