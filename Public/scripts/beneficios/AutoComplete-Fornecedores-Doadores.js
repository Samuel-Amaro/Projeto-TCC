//ao clicar no submit do form de autocomplete
//let submit = document.querySelector(".form-forn-doad-autocomplete");
//submit.addEventListener("submit", function(event) {
//    alert("Você clicou no autocomplete!");
//});

//Um request objeto, com uma única term propriedade, que se refere ao valor atualmente na entrada de texto.
//Um responseretorno de chamada, que espera um único argumento: os dados a serem sugeridos ao usuário.

$("#autoCompleteFornecedorDoador").autocomplete({
    //Object request, function response(Object dados)
    source: function(request, response) {
        //busca dados por ajax, por cpf ou cnpj
        //console.log(request.term);
        $.ajax({
            url : "../controller/ControllerFornecedoresDoadores.php",
            data : {
                operacao : "busca",
                termo : request.term
            },
            type: "POST",
            dataType : "json",
        }).done(function(json) {
            try {    
                let cnpjsCpfs = trataResponse(json);
                response(cnpjsCpfs);
            } catch (error) {
                console.error(error.message);
                console.error(error.name);
            }
        }).fail(function(xhr, status, errorThrown) {
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
            console.dir( xhr ); 
        });
    },//ao selecionar um item do autocomplete, preenche o form com os dados necessarios, passsando um array para função
    select : function(event, ui) {
        setaNomeFornecedorDoador(ui.item.value);
    }
});

/*
$('#autoCompleteFornecedorDoador').on('click', function(event, ui) {
    
});*/

let listaFornecedoresDoadores = [];

/**
 * * ESTA FUNÇÃO E RESPONSAVEL POR DESAGRUPAR OS VALORES VINDOS PARA O AUTUCOMPLETE E SO RETORNA PARA O RESPONSE DO AUTOCOMPLETE A LISTA DE CPFS E CNPJS QUE PROCURA
 */
function trataResponse(json) {
    let listaCnpjCpf = [];
    //esvazia lista, apos ter realizado alguma pesquisa anterior
    for (let index = 0; index <= listaFornecedoresDoadores.length; index++) {
        listaFornecedoresDoadores.pop();
    }
    if(Array.isArray(json)) {
        json.forEach(element => {
            let array = element.value; 
            listaFornecedoresDoadores.push(array);  
        });
        //console.log(listaFornecedoresDoadores);
        for (let index = 0; index < listaFornecedoresDoadores.length; index++) {
            listaCnpjCpf.push(listaFornecedoresDoadores[index][1]);
            //console.log(listaFornecedoresDoadores[index][1]);
        }
        return listaCnpjCpf; 
    }else{
        return json;
    }
}

/**
 * * Esta função carrega os dados de um forncedor ou doador escolhido no autocomplete, no formulario
 * @param {*} fornecedorDoador 
 */
function carregaDadosForm(fornecedorDoador) {
    let nome = document.querySelector("#nomeFornDoador");
    nome.value = '';
    let id = document.querySelector("#idFornDoador");
    id.value = '';
    nome.value = fornecedorDoador[2]; //nome fornecedor doador
    id.value = fornecedorDoador[0]; //id
}

/**
 * * Esta função dinamicamente ele vai setando os nomes de forncedores e doadores escolhidos do autocomplete, a cada clique e um novo nome
 * @param {} cnpjOuCpf 
 */
function setaNomeFornecedorDoador(cnpjOuCpf) {
    for (let index = 0; index < listaFornecedoresDoadores.length; index++) {
        if(listaFornecedoresDoadores[index][1] === cnpjOuCpf) {
            carregaDadosForm(listaFornecedoresDoadores[index]); 
        }
    }
}
