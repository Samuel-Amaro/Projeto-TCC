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
let tabela = new DataTable('#dataTablesTipoBeneficio',{
    "responsive": true,
    "scrollX": true,
    "language": {
        "emptyTable": "Não tipos de benefícios cadastrados no momento"
    },
    "ajax": function(dados, callback) {
        fetch('../controller/ControllerTipoBeneficio.php', minhaInicializacao).then(response => response.json()).then(data =>  callback(data));
    },
    "columns": [
        {data: 'nome_tipo'},
        {data: 'sigla'},
        {data: 'nome'}
    ],
    "columnDefs": [ {
        "targets": 3,
        "data": null,
        "defaultContent": "<button type=\"button\" class=\"btn btn-info mr-2 p-0\" data-toggle=\"modal\" data-target=\"#modalCategoria\" data-whatever=\"@mdo\"><i class=\"fas fa-info-circle\"></i></button> <button type=\"button\" class=\"btn btn-alterar mr-2 p-0\" data-toggle=\"modal\" data-target=\"#modalCategoria\" data-whatever=\"@mdo\"><i class=\"fas fa-user-edit\"></i></button> <button type=\"button\" class=\"btn btn-excluir p-0\" target=\"self\" rel=\"next\"><i class=\"fas fa-user-times\"></i></button>"
    }]
});
//ao clicar no btn de alterar retorna os dados da linha clicada
$('#dataTablesTipoBeneficio tbody').on('click', '.btn-alterar', function(){
    let data = tabela.row($(this).parents('tr')).data();
    mostraModal("#modalAlterarTipoBeneficio");
    carregaDadosModal("ALTER", data);
    //carregarDadosModalAlterar(data);
});
//ao clicar no btn de excluir a linha
$('#dataTablesTipoBeneficio tbody').on('click', '.btn-excluir', function(){
    let data = tabela.row($(this).parents('tr')).data();
    modalExlcuir(data.id_tipo_beneficio);
});
//ao clicar no btn de trazer a informação da linha
$('#dataTablesTipoBeneficio tbody').on('click', '.btn-info', function(){
    let data = tabela.row($(this).parents('tr')).data();
    mostraModal("#modalInfoTipoBeneficio");
    carregaDadosModal("INFORMATION", data);
});