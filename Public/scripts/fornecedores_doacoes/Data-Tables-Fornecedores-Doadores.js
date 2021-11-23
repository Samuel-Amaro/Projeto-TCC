//cabeçalho http, especificando o tipo de conteudo
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
let tabela = new DataTable('#dataTablesFornecedoresDoadores',{
    "responsive": true,
    "scrollX": true,
    "language": {
        "emptyTable": "Não ha fornecedores e doadores cadastrados no momento"
    },
    "ajax": function(dados, callback) {
        fetch('../controller/ControllerFornecedoresDoadores.php', minhaInicializacao).then(response => response.json()).then(data =>  callback(data));
    },
    "columns": [
        {data: 'nome'},
        //{data: 'descricao'},
        {data: 'identificacao'},
        {data: 'tipo_pessoa'},
        {data: 'cpf'},
        {data: 'cnpj'}
        //{data: 'cep'},
    ],
    "columnDefs": [ {
        "targets": 5,
        "data": null,
        "defaultContent": "<button type=\"button\" class=\"btn btn-info-modal p-0\" data-toggle=\"modal\" data-target=\"#modalInfoFornDoad\" data-whatever=\"@mdo\"><i class=\"fas fa-info-circle\"></i></button> <button type=\"button\" class=\"btn p-0 btn-alterar-forn-doad\" data-toggle=\"modal\" data-target=\"#modalFornecedorDoador\" data-whatever=\"@mdo\"><i class=\"fas fa-user-edit\"></i></button> <button type=\"button\" class=\"btn p-0 btn-excluir-forn-doad\"><i class=\"fas fa-user-times\"></i></button>"
    }]
});
//ao clicar no btn de alterar retorna os dados da linha clicada
$('#dataTablesFornecedoresDoadores tbody').on('click', '.btn-alterar-forn-doad', function(){
    let data = tabela.row($(this).parents('tr')).data();
    //console.log(data.nome);
    mostraModalAlterarFornecedorDoador();
    carregaDadosModalFornecedorDoador(data);
});
//ao clicar no btn de excluir ira retornar os dados necessarios para exlcuir
$('#dataTablesFornecedoresDoadores tbody').on('click', '.btn-excluir-forn-doad', function(){
    let data = tabela.row($(this).parents('tr')).data();
    mostraModalExcluirFornecedoresDoadores(data.id);
});
//ao cliar no btn de info modal ira mostrar o modal com informações de onde clicou
$('#dataTablesFornecedoresDoadores tbody').on('click', '.btn-info-modal', function(){
    let data = tabela.row($(this).parents('tr')).data();
    mostraModalInfoForcedoresDoadores();
    mostraModalInfo(data);
    //console.log(data);
});



