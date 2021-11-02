//ao clicar no submit do form de autocomplete
let submit = document.querySelector(".form-forn-doad-autocomplete");
submit.addEventListener("submit", function(event) {
    alert("Você clicou no autocomplete!");
});

//Um request objeto, com uma única term propriedade, que se refere ao valor atualmente na entrada de texto.
//Um responseretorno de chamada, que espera um único argumento: os dados a serem sugeridos ao usuário.

$("#autoCompleteFornecedorDoador").autocomplete({
    //Object request, function response(Object dados)
    source: function(request, response) {
        //busca dados por ajax, por cpf ou cnpj
        console.log(request.term);
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
                //console.log(json);
                //console.log(JSON.parse(json));    
                response(json);
            } catch (error) {
                console.error(error.message);
                console.error(error.name);
            }
        }).fail(function(xhr, status, errorThrown) {
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
            console.dir( xhr ); 
        });
    }
});