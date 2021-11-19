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
let tabela = new DataTable('#dataTablesEstoque',{
    "responsive": true,
    "scrollX": true,
    "language": {
        "emptyTable": "Não ha beneficios cadastrados no momento"
    },
    "ajax": function(dados, callback) {
        fetch('../controller/ControllerMovimentacoesEstoque.php', minhaInicializacao).then(response => response.json()).then(data =>  callback(data));
    },//arrumar colunas que serão puxadas
    "columns": [
        {data: 'nome'},
        {data: 'quantidade_mov'},
        {data: 'quantidade_maxima'},
        {data: 'quantidade_minima'},
        {data: 'tipo_mov'}
    ], 
    "columnDefs": [ {
        "targets": 5,
        "data": null,
        "defaultContent": "<button type=\"button\" class=\"btn mr-2 p-0\" data-toggle=\"modal\" data-target=\"#modalCategoria\" data-whatever=\"@mdo\"><i class=\"fas fa-info-circle\"></i></button> <button type=\"button\" class=\"btn p-0\" data-toggle=\"modal\" data-target=\"#modalCategoria\" data-whatever=\"@mdo\"><i class=\"far fa-edit\"></i></button> <button type=\"button\" class=\"btn p-0\" target=\"self\" rel=\"next\"><i class=\"fas fa-trash-alt\"></i></button>"
    }]
});
