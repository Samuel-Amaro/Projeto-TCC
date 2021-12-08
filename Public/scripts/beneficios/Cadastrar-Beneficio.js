//esse script manipula o cadastro de beneficios por meio de ajax, fazendo as solicitações ao server
let btnCadastrarBeneficios = document.querySelector(".btn-cadastrar-beneficio");
btnCadastrarBeneficios.addEventListener("click", function(event) {
    let dados = obterDadosDataTables();
    //let arrayDados = [];
    if(dados.length === 0) {
        Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: 'Não temos beneficios a serem cadastrados no momento.'
        });
    }else{
        //console.log(dados);
        let jsonDados = JSON.stringify(dados);
        //console.log(jsonDados);
        if(makeRequestBeneficio("../controller/ControllerBeneficio.php", jsonDados, "cadastrar") === 1) {
            //se der certo faz nada 
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Beneficio não foi cadastrado. houve um erro interno tente novamente mais tarde por favor!'
            }); 
        }
    }
});
