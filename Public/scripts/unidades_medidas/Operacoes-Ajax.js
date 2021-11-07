/*SUBMETER FORMULARIO DE CADASTRAR*/
let submitFormCadastrar = document.querySelector(".form-unidades-medidas");
submitFormCadastrar.addEventListener("submit", function(event) {
    if(validaCamposForm()) {
        event.preventDefault();
        if(makeRequestUnidadesMedidas("../controller/ControllerUnidadeMedida.php", obterDadosForm(), "cadastrar") == 1) {
            //se fer certo faz nada
        }else{
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Operação de cadastrar unidade de medida não foi executada, tente novamente mais tarde, problemas interno em nosso servidor.',
                footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
            });
        }
        //console.log("Campos validos!");
    }else{
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Alguns campos não foram preenchidos corretamente, por favor, preencha os novamente, da forma correta!',
            footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
        });    
        limpaCamposForm();
    }
});