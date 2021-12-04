/*SUBMETER FORMULARIO DE CADASTRAR*/
let submitFormCadastrar = document.querySelector(".form-tipo-aquisicao");
submitFormCadastrar.addEventListener("submit", function(event) {
    if(validaCamposForm()) {
       event.preventDefault();
        if(makeRequestTipoAquisicao("../Controller/ControllerTipoAquisicao.php", obterDadosForm(), "cadastrar") === 1) {
            //se der certo faz nada proprio make request manda mensagem de sucesso  
        }else{
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Operação de cadastrar tipo aquisição não foi executada, tente novamente mais tarde, problemas interno em nosso servidor.',
                footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
            });
        }
    }else{
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Por favor, preencha as informações corretamente, para que se possa realizar a operação desejada.',
            footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
        });
    }
});

/*SUBMETER FORMULARIO DE ALTERAR*/
let submitFormAlterar = document.querySelector("#modalAlterarTipoAquisicao");
submitFormAlterar.addEventListener("submit", function(event) {
    if(validaCamposFormAlterar()) {
        event.preventDefault();
        if(makeRequestTipoAquisicao("../Controller/ControllerTipoAquisicao.php", obterDadosModalAlterar(), "atualizar") === 1) {
            //faz nada
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Obtemos um erro. Ao realizar a operação desejada. Por favor tente novamente mais tarde.',
                footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
            });
        } 
    }else{
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Por favor, preencha as informações corretamente, para que se possa realizar a operação desejada.',
            footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
        });
    }
});


function mostraModalExcluir(id) {
    Swal.fire({
        title: 'Realmente deseja deletar este tipo de aquisição?',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Sim',
        denyButtonText: 'Não',
        customClass: {
          actions: 'my-actions',
          cancelButton: 'order-1 right-gap',
          confirmButton: 'order-2',
          denyButton: 'order-3',
        }
    }).then((result) => {
        //sim deseja deletar
        if(result.isConfirmed) {
            if(makeRequestTipoAquisicao("../Controller/ControllerTipoAquisicao.php", id, "excluir")) {
                //faz nada apos a exlcusão
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Tipo de aquisição não foi deletado. tivemos um problema interno em nosso servidor, por favor tente novamente mais tarde.',
                    footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
                });
            }
        }
    });
}