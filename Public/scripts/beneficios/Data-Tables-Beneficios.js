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
        {data: 'descricao'}, //descricaoBeneficio
        {data: 'nome'}, //nomeBeneficio
        {data: 'categoriaId'}, //categoriaBeneficio
        {data: 'formaAquisicao'}, //formaAquisicao
        {data: 'qtdTotal'}, //quantidadeTotal
        {data: 'unidadeMedidaId'}, //unidadeMedida 
        {data: 'qtdMedida'}, //quantidadePorMedida
        {data: 'qtdMinima'}, //quantidadeMinima
        {data: 'qtdMaxima'}, //quantidadeMaxima
        {data: 'nomeFornecedorOuDoador'},
        {data: 'cnpjOuCpfFornecedorDoador'}
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