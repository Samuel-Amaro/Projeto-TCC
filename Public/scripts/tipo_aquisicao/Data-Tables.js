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
let tabela = new DataTable('#dataTablesTipoAquisicao',{
    "responsive": true,
    "scrollX": true,
    "language": {
        "emptyTable": "Não ha tipos de aquisição cadastrados no momento"
    },
    "ajax": function(dados, callback) {
        fetch('../controller/ControllerTipoAquisicao.php', minhaInicializacao).then(response => response.json()).then(data =>  callback(data));
    },
    "columns": [
        {data: 'tipo'}
    ],
    "columnDefs": [ {
        "targets": 1,
        "data": null,
        "defaultContent": "<button type=\"button\" class=\"btn btn-info-modal mr-2 p-0\" data-toggle=\"modal\" data-target=\"#modalCategoria\" data-whatever=\"@mdo\"><i class=\"fas fa-info-circle\"></i></button> <button type=\"button\" class=\"btn btn-alterar-tipo mr-2 p-0\" data-toggle=\"modal\" data-target=\"#modalCategoria\" data-whatever=\"@mdo\"><i class=\"fas fa-user-edit\"></i></button> <button type=\"button\" class=\"btn btn-excluir-tipo p-0\" target=\"self\" rel=\"next\"><i class=\"fas fa-user-times\"></i></button>"
    }]
});

//ao clicar no btn de info retorna os dados para visualização no modal
$('#dataTablesTipoAquisicao tbody').on('click', '.btn-info-modal', function(){
    let data = tabela.row($(this).parents('tr')).data();
    mostraModal();
    carregaDadosModalInfo(data);
});

//ao clicar no btn de alterar retorna os dados da linha clicada
$('#dataTablesTipoAquisicao tbody').on('click', '.btn-alterar-tipo', function(){
    let data = tabela.row($(this).parents('tr')).data();
    mostraModalAlterar();
    carregaDadosModalAlterar(data);
});
$('#dataTablesTipoAquisicao tbody').on('click', '.btn-excluir-tipo', function(){
    let data = tabela.row($(this).parents('tr')).data();
    mostraModalExcluir(data.id_tipo_aquisicao);
});