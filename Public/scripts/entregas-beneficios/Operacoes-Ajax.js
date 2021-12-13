/*AO SUBMETER O FORM DE REGISTRAR ENTREGA - CLICAR EM ADICIONAR REGISTRO*/
let formRegistrarEntrega = document.querySelector(".form-registro-entrega");
formRegistrarEntrega.addEventListener("submit", function(event) {
    event.preventDefault();
    if(validaCampos()) {
        //inseri object registro na tabela datatabels
        tabelaRegistro.row.add(obterDadosForm()).draw();
        //add object no array
        arrayRegistrosEntregas.push(obterDadosForm());
        limpaCamposForm(); 
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Por favor, preencha corretamente os campos do formulário registrar entrega, para poder concluir a operação de entrega de benefício.'
        }); 
    }
});

/*AO CLICAR EM REGISTRAR - BOTÃO SUBMIT*/
let btnRegistrar = document.querySelector(".btn-registrar");
btnRegistrar.addEventListener("click", function(event) {
    //verifica se a entregas a serem registradas
    let resultado = obterDadosDataTables();
    if(resultado.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Sem entregas a serem registradas. Cadastre entregas no formulario e depois as registre clicando em registrar.'
        }); 
    }else{
        limpaDataTables();
        let jsonDados = JSON.stringify(resultado);
        if(makeRequestEntrega("../controller/ControllerEntregaBeneficios.php", jsonDados, "cadastrar") === 1) {
            //se der certo faz nada
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tivemos um erro interno ao tentar, registrar o montante de entregas, por favor tente novamente mais tarde, efetuar a operação.'
            }); 
        }
    }
});