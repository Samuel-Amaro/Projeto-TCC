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
    "language": {
        "emptyTable": "Não ha fornecedores e doadores cadastrados no momento"
    },
    "ajax": function(dados, callback) {
        fetch('../controller/ControllerFornecedoresDoadores.php', minhaInicializacao).then(response => response.json()).then(data =>  callback(data));
    },
    "columns": [
        {data: 'nome'},
        {data: 'descricao'},
        {data: 'identificacao'},
        {data: 'tipo_pessoa'},
        {data: 'cpf'},
        {data: 'cnpj'},
        {data: 'cep'},
    ]
});

