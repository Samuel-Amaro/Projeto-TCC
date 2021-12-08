//armazena beneficios, a serem cadastrados, e popula tabela HTML
let arrayBeneficios = [];

let tabelaBeneficios = new DataTable('#dataTablesBeneficio', {
    //opções de inicialização do plugin
    //"scrollX": true,
    "responsive": true,
    "paging": true,
    "language": {
        "emptyTable": "Sem benefícios a serem cadastrados"
    },
    "data": arrayBeneficios, //array com beneficios
    "columns": [
        {data: 'idTipeBeneficio'}, //idTipoBeneficio
        {data: 'nomeFornecedorOuDoador'}, //nome fornecedor doador
        {data: 'idTipoAquisicao'}, //idTipoAquisicao
        {data: 'quantidade'}, //quantidade
        {data: 'cnpjOuCpfFornecedorDoador'} //cnpj ou cpf fornecedor/doador
    ]
});

/**
 * * Esta função retorna os dados que estão na tabela datatables
 * 
 * @returns array
 */
function obterDadosDataTables() {
    return tabelaBeneficios.data().toArray();
}

function limpaDataTables() {
    tabelaBeneficios.clear().draw();    
}