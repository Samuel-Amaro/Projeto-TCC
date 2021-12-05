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