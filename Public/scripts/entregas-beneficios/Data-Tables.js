//armazena registros de entrega, a serem cadastrados, e popula tabela HTML
let arrayRegistrosEntregas = [];

let tabelaRegistro = new DataTable('#dataTablesRegistroEntregas', {
    //opções de inicialização do plugin
    //"scrollX": true,
    "responsive": true,
    "paging": true,
    "language": {
        "emptyTable": "Sem entregas a serem registradas"
    },
    "data": arrayRegistrosEntregas, //array com entregas
    "columns": [
        {data: 'nomeTipoBeneficio'}, //nome tipo beneficio
        {data: 'nomeBeneficiario'}, //nome beneficiario
        {data: 'quantidade'} //quantidade
    ]
});

function obterDadosDataTables() {
    return tabelaRegistro.data().toArray();
}

function limpaDataTables() {
    tabelaRegistro.clear().draw();    
}