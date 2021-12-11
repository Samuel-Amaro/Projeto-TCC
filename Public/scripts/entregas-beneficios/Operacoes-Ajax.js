/*AO SUBMETER O FORM DE REGISTRAR ENTREGA*/
let formRegistrarEntrega = document.querySelector(".form-registro-entrega");
formRegistrarEntrega.addEventListener("submit", function(event) {
    event.preventDefault();
    if(validaCampos()) {
        //console.log(obterDadosForm());
        //inseri object registro na tabela datatabels
        tabelaRegistro.row.add(obterDadosForm()).draw();
        //add object no array
        arrayRegistrosEntregas.push(obterDadosForm());
        limpaCamposForm(); 
    }else{
        console.log("Campos invalidos");
    }
    
});