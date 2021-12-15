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
let tabela = new DataTable('#dataTablesEntregas',{
    "responsive": true,
    "scrollX": true,
    "language": {
        "emptyTable": "Não ha entregas registradas no momento"
    },
    "ajax": function(dados, callback) {
        fetch('../controller/ControllerEntregaBeneficios.php', minhaInicializacao).then(response => response.json()).then(data =>  callback(data));
    },//arrumar colunas que serão puxadas
    "columns": [
        {data: 'nome_completo'}, //nome beneficiario
        {data: 'cpf_beneficiario'}, //cpf beneficiario
        {data: 'nis_beneficiario'}, //nis beneficiario
        {data: 'nome_tipo_beneficio'}, //nome do tipo beneficio
        {data: 'quantidade_entregue_beneficio'}, //quantidade entregue
        {data: 'data_entrega_beneficio'} //data entrega
    ], 
    "columnDefs": [ {
        "targets": 6,
        "data": null,
        "defaultContent": "<button type=\"button\" class=\"btn btn-info-modal mr-2 p-0\" data-toggle=\"modal\" data-target=\"#modalCategoria\" data-whatever=\"@mdo\"><i class=\"fas fa-info-circle\"></i></button>"
    }]
});

//ao clicar no btn de info retorna os dados da linha clicada
$('#dataTablesEntregas tbody').on('click', '.btn-info-modal', function(){
    let data = tabela.row($(this).parents('tr')).data();
    //console.log(data);
    mostraModal("#modalInfoEntregas");
    carregaDadosModalInformation(data);
});
