let cabecalho = new Headers();
cabecalho.append('contentType', 'application/x-www-form-urlencoded; charset=UTF-8');
//formulario, contem dados para o server
let form = new FormData();
form.append('operacao', 'listar');
//inicialização da api fecht informações para o servidor
const minhaInicializacao = {
    method: 'POST', //Method HTTP
    headers: cabecalho, //cabecalho http
    body: form //corpo da requisição
};
//inicializa tabela datables com ajax, sem usar jquery, somente com API nativas
let tabela = new DataTable('#dataTablesUnidadeMedida',{
    "responsive": true,
    "scrollX": true,
    "language": {
        "emptyTable": "Não ha unidades de medidas cadastradas no momento"
    },
    "ajax": function(dados, callback) {
        fetch('../controller/ControllerUnidadeMedida.php', minhaInicializacao).then(response => response.json()).then(data =>  callback(data));
    },
    "columns": [
        {data: 'sigla'},
        {data: 'descricao'}
    ],
    "columnDefs": [ {
        "targets": 2,
        "data": null,
        "defaultContent": "<button type=\"button\" class=\"btn btn-alterar-unidade-medida mr-2\" data-toggle=\"modal\" data-target=\"#modalCategoria\" data-whatever=\"@mdo\"><i class=\"fas fa-user-edit\"></i></button> <button type=\"button\" class=\"btn btn-excluir-unidade-medida\" target=\"self\" rel=\"next\"><i class=\"fas fa-user-times\"></i></button>"
    }]
});
//ao clicar no btn de alterar retorna os dados da linha clicada
$('#dataTablesUnidadeMedida tbody').on('click', '.btn-alterar-unidade-medida', function(){
    let data = tabela.row($(this).parents('tr')).data();
    mostraModalAlterar();
    carregarDadosModalAlterar(data);
});
$('#dataTablesUnidadeMedida tbody').on('click', '.btn-excluir-unidade-medida', function(){
    let data = tabela.row($(this).parents('tr')).data();
    mostraModalExcluir(data.id_unidade);
});