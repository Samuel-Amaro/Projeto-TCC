//esse script manipula o cadastro de beneficios por meio de ajax, fazendo as solicitações ao server
let btnCadastrarBeneficios = document.querySelector(".btn-cadastrar-beneficio");
btnCadastrarBeneficios.addEventListener("click", function(event) {
    let dados = obterDadosDataTables();
    if(dados.length === 0) {
        Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: 'Não temos beneficios a serem cadastrados no momento.'
        });
    }else{
        for (let index = 0; index < dados.length; index++) {
            console.log(dados[index]);
        }
    }
});
