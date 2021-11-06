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