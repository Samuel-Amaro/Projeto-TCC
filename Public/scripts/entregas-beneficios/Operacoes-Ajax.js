/*AO SUBMETER O FORM DE REGISTRAR ENTREGA*/
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