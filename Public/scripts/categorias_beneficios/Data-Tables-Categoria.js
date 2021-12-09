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
let tabela = new DataTable('#dataTablesCategoria',{
    "responsive": true,
    "scrollX": true,
    "language": {
        "emptyTable": "Não ha categorias cadastradas no momento"
    },
    "ajax": function(dados, callback) {
        fetch('../controller/ControllerCategoriaBeneficio.php', minhaInicializacao).then(response => response.json()).then(data =>  callback(data));
    },
    "columns": [
        {data: 'nome'}
    ],
    "columnDefs": [ {
        "targets": 1,
        "data": null,
        "defaultContent": "<button type=\"button\" class=\"btn btn-alterar-categoria mr-2 p-0\" data-toggle=\"modal\" data-target=\"#modalCategoria\" data-whatever=\"@mdo\"><i class=\"fas fa-user-edit\"></i></button>  <button type=\"button\" class=\"btn btn-mostrar-categoria p-0\"><i class=\"fas fa-info\"></i></button>  <button type=\"button\" class=\"btn btn-excluir-categoria p-0\" target=\"self\" rel=\"next\"><i class=\"fas fa-user-times\"></i></button>"
    }]
});
//ao clicar no btn de alterar retorna os dados da linha clicada
$('#dataTablesCategoria tbody').on('click', '.btn-alterar-categoria', function(){
    let data = tabela.row($(this).parents('tr')).data();
    //console.log(data.nome);
    //console.log(data.id_categoria);
    mostraModalAlterarCategoria();
    carregaDadosModalAlterarCategoria(data);
    //carregaDadosModalFornecedorDoador(data);
});
$('#dataTablesCategoria tbody').on('click', '.btn-excluir-categoria', function(){
    let data = tabela.row($(this).parents('tr')).data();
    //console.log(data.nome);
    mostraModalExcluirCategoria(data.id_categoria);
    //mostraModalExcluirFornecedoresDoadores(data.id);
});