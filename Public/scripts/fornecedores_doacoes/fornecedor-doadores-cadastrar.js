
//campos fixos do formulario a serem verificados
//campos de texto e de select
let camposArray = [".nome-fornecedor-doador", "#tipoPessoa", "#tipoIdentificacao", "#inputEndereco", "#inputBairro", "#inputCidade", "#inputEstado", "#telefone01", "#telefone02"];

//Submissão do form de cadastrar fornecedor ou doador
let submitForm = document.querySelector(".form-fornecedor");
submitForm.addEventListener("submit", function(event){
    //array com campos do formulario invalidos
    let fieldInvalid = camposInvalidos(camposArray);
    //sem campos invalidos
    if(fieldInvalid.length === 0) {
        //aplica class css do bostratp notificando que campos estão validos
        camposArray.forEach(element => {
            setaEstiloValidacaoCampo(element, ".is-valid");
        });
        //obtem dados do formulario submetido
        if(makeRequestFornecedorDoador("../controller/ControllerFornecedoresDoadores.php", obterDadosFormulario())) {
            //deu certo faz nada.
        }else{
            //deu erro
            event.preventDefault();
        }
        console.log(obterDadosFormulario());
        //limpara os campos do formulario apos passar 5 segundos
        let resultado = setTimeout(limpaCamposFormulario, 5000);
    }else{
        //possui campos invalidos    
        //aplica class css do bostrap notificando que esta invalidos
        fieldInvalid.forEach(element => {
            setaEstiloValidacaoCampo(element, ".is-invalid");  
        });
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Alguns campos não foram preenchidos, corretamente, por favor, preencha os novamente, da forma correta!',
            footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
        });
        event.preventDefault();
    }
});

/**
 * * Esta função faz a solicitação para postar dados no servidor
 * @param {*} url 
 * @param {*} fornecedorDoador 
 */
function makeRequestFornecedorDoador(url, fornecedorDoador = {}) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    if(fornecedorDoador.tipoPessoa === "FISICA") {
        //puxa cpf
        httpRequest.send('nome=' + encodeURIComponent(fornecedorDoador.nome) + '&descricao=' + encodeURIComponent(fornecedorDoador.descricao) + '&tipoPessoa=' + encodeURIComponent(fornecedorDoador.tipoPessoa) + '&identificacao=' + encodeURIComponent(fornecedorDoador.identificacao) + '&cpf=' + encodeURIComponent(fornecedorDoador.cpf) + '&cep=' + encodeURIComponent(fornecedorDoador.cep) + '&endereco=' + encodeURIComponent(fornecedorDoador.endereco) + '&complemento=' + encodeURIComponent(fornecedorDoador.complemento) + '&bairro=' + encodeURIComponent(fornecedorDoador.bairro) + '&cidade=' + encodeURIComponent(fornecedorDoador.cidade) + '&estado=' + encodeURIComponent(fornecedorDoador.estado) + '&telefoneCelular=' + encodeURIComponent(fornecedorDoador.telefoneCelular) + '&telefoneFixo=' + encodeURIComponent(fornecedorDoador.telefoneFixo) + '&email=' + encodeURIComponent(fornecedorDoador.email) + '&operacao=' + encodeURIComponent(fornecedorDoador.operacao));
    }else{
        //puxa cnpj
        httpRequest.send('nome=' + encodeURIComponent(fornecedorDoador.nome) + '&descricao=' + encodeURIComponent(fornecedorDoador.descricao) + '&tipoPessoa=' + encodeURIComponent(fornecedorDoador.tipoPessoa) + '&identificacao=' + encodeURIComponent(fornecedorDoador.identificacao) + '&cnpj=' + encodeURIComponent(fornecedorDoador.cnpj) + '&cep=' + encodeURIComponent(fornecedorDoador.cep) + '&endereco=' + encodeURIComponent(fornecedorDoador.endereco) + '&complemento=' + encodeURIComponent(fornecedorDoador.complemento) + '&bairro=' + encodeURIComponent(fornecedorDoador.bairro) + '&cidade=' + encodeURIComponent(fornecedorDoador.cidade) + '&estado=' + encodeURIComponent(fornecedorDoador.estado) + '&telefoneCelular=' + encodeURIComponent(fornecedorDoador.telefoneCelular) + '&telefoneFixo=' + encodeURIComponent(fornecedorDoador.telefoneFixo) + '&email=' + encodeURIComponent(fornecedorDoador.email) + '&operacao=' + encodeURIComponent(fornecedorDoador.operacao));
    }
    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = JSON.parse(httpRequest.responseText);  
                    Swal.fire(
                        'Obaa...',
                        httpResponse.response,
                        'success'
                    );
                    return 1;
                } catch (error) {
                    console.error(error.message);
                    console.error(error.name);
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                    return 0;
                }
            }else{
                //return 0;
            }
        }else{
                //alert("Ajax operação assincrona não concluida! onreadystatechange: " + httpRequest.readyState);
                //operação assincrona ajax não chegou no estagio de concluida
                //return 0;
        }
    }
}