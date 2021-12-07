/*quando o formulario de cadastrar for submetido*/
let formCadastrar = document.querySelector(".form-tipo-beneficio");
formCadastrar.addEventListener("submit", function(event) {
    if(validaCamposForm()) {
        event.preventDefault(); 
        if(makeRequestTipoBeneficio("../Controller/ControllerTipoBeneficio.php", obterDadosForm(), "cadastrar") === 1) {
            //se der certo faz nada
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Operação de cadastrar tipo de beneficio não foi executada, tente novamente mais tarde, problemas interno em nosso servidor.',
                footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
            });
        }
    }else{
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Não pode realizar o cadastro do tipo do benefício se não preencher os campos corretamente, por favor preencha os campos corretamente.',
            footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
        });
    }
});

/*quando o formulario de alterar for submetido*/
let formAlterar = document.querySelector(".form-alterar-tipo-beneficio");
formAlterar.addEventListener("submit", function(event) {
    event.preventDefault();
    if(validaCamposModal()) {
        if(makeRequestTipoBeneficio("../Controller/ControllerTipoBeneficio.php", obterDadosModalAlterar(), "atualizar") === 1) {
            //se der certo faz nada
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Operação de cadastrar tipo de beneficio não foi executada, tente novamente mais tarde, problemas interno em nosso servidor.',
                footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
            });
        }
    }else{
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Não pode realizar o atualizar o tipo do benefício se não preencher os campos corretamente, por favor preencha os campos corretamente. E clique em salvar alteração para efetur a operação.',
            footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
        });
    }
});