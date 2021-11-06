/*CADASTRAR*/
let submit = document.querySelector(".form-categoria");
submit.addEventListener("submit", function(event) {
    if(validaCampos()) {
        event.preventDefault();
        //console.log("teste, campos corretos");
        if(makeRequestCategoria("../controller/ControllerCategoriaBeneficio.php" , obterDadosFormCategoria(), "cadastro")) {
            //se der certo faz nada, so limpa campos
        }else{
            //se der errado cancela evento de submissão
            event.preventDefault();
        }
    }else{
        //console.log("teste, campos não preenchidos");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Alguns campos não foram preenchidos, corretamente, por favor, preencha os novamente, da forma correta!',
            footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
        });
        event.preventDefault();
    }
});

/*ALTERAR*/
let submitAlterar = document.querySelector(".form-alterar-categoria");
submitAlterar.addEventListener("submit", function(event) {
    if(makeRequestCategoria("../controller/ControllerCategoriaBeneficio.php", obterDadosModalAlterarCategoria(), "atualizar")) {
        //se der certo faz nada
    }else{
        //se der erro mostra mensagem
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Alguns campos não foram preenchidos, corretamente, por favor, preencha os novamente, da forma correta!',
            footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
        });
        event.preventDefault();
    }
});