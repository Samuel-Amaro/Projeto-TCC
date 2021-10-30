//ao carregar a pagina
window.addEventListener('load', function(event) {
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
            "defaultContent": "<button type=\"button\" class=\"btn btn-primary btn-alterar-forn-doad\" data-toggle=\"modal\" data-target=\"#modalFornecedorDoador\" data-whatever=\"@mdo\"><i class=\"fas fa-user-edit\"></i></button> <button type=\"button\" class=\"btn btn-primary btn-excluir-forn-doad\"><i class=\"fas fa-user-times\"></i></button>"
        }]
    });
    //ao clicar no btn de alterar retorna os dados da linha clicada
    $('#dataTablesFornecedoresDoadores tbody').on('click', '.btn-alterar-forn-doad', function(){
        let data = tabela.row($(this).parents('tr')).data();
        mostraModalAlterarFornecedorDoador();
        //alert(data.nome); 
    });
});

/**
 * * Esta Função Mostra o modal
 * @param {*} fornecedorOuDoador 
 */
function mostraModalAlterarFornecedorDoador() {
    let elementoModal = document.querySelector("#modalFornecedorDoador");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function carregaDadosModalFornecedorDoador() {
    
}