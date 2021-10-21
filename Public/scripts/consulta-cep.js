
let btnBuscaCep = document.querySelector(".btn-busca-cep");
let feedbackCep = document.querySelector('.invalid-feedback-cep');

btnBuscaCep.addEventListener("click", function() {
    pesquisaCep();
});

function pesquisaCep() {
    let cepValor = document.querySelector("#inputCep").value;
    let cepElement = document.querySelector("#inputCep");
    //nova variavel "cep" somente com digitos
    let cepDigitos = cepValor.replace(/\D/g, '');
    //verifica se campo cep possui valor informado
    if(cepDigitos != "") {
        //expressão regular para valida o CEP
        let validaCep = /^[0-9]{8}$/;
        //valida o formato do CEP
        if(validaCep.test(cepDigitos)) {
           //remove classe de invalido caso tenha tentado antes 
           cepElement.classList.remove("is-invalid");
           //add uma class de validação de sucesso no elemento
           cepElement.classList.add("is-valid");
           feedbackCep.textContent = "Cep Correto...."; 
           //busca cep com ajax requisição GET e retorna um json
           let url = "https://viacep.com.br/ws/" + cepDigitos + "/json/";
           //let objectJsonCep =  makeRequest(url);
           makeRequestCep(url);
           //console.log(objectJsonCep);
        }else{
           //retira class de valida
           cepElement.classList.remove("is-valid"); 
           //add uma class de invalidação de erro no elemento
           cepElement.classList.add("is-invalid");
           feedbackCep.textContent = "Cep incorreto, digite novamente."; 
        }
    }else{
        //retira class de valida
        cepElement.classList.remove("is-valid");
        //add uma class de invalidação de erro no elemento
        cepElement.classList.add("is-invalid");
        feedbackCep.textContent = "Informe um cep por favor"; 
        //console.log("Cep invalido os digitos");
    }
}

function makeRequestCep(url) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("GET", url, true);
    //httpRequest.responseType = "json";
    httpRequest.send();
    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = JSON.parse(httpRequest.responseText);  
                    mostraDados(httpResponse.bairro, httpResponse.localidade, httpResponse.logradouro, httpResponse.uf, httpResponse.complemento, httpResponse.erro);
                } catch (error) {
                    //mostraModal("Erro ao atualizar conta de usuário", "Atualização de usuário", "Ok", "Sair", "error");
                    //console.error(error.message);
                    //console.error(error.name);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro na busca do CEP',
                        text: 'Ocorreu um erro ao buscar o cep, por favor preencha o campo corretamente.',
                        footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
                    });
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                    //return 0;
                }
                //console.log(httpResponse);
            }else{
        
            }
        }else{
    
        }
    }
}

function mostraDados(bairro, cidade, logradouro, estado, complemento, erro) {
  if(erro == true){
    let cepElement = document.querySelector("#inputCep");
    cepElement.classList.add("is-invalid");
    feedbackCep.textContent = "Cep informado e invalido!";
  }else{
    let inputEndereco = document.querySelector("#inputEndereco");
    let inputCidade = document.querySelector("#inputCidade");
    let selectEstado = document.querySelector("#inputEstado");
    let inputBairro = document.querySelector("#inputBairro");
    let inputComplemento = document.querySelector("#inputComplemento");
    inputEndereco.value = logradouro;
    //selectEstado.value = estado; //String.prototype.toLowerCase(estado)
    inputBairro.value = bairro;
    inputCidade.value = cidade;
    inputComplemento.value = complemento;
    inputEndereco.setAttribute("readonly", "readonly");
    inputCidade.setAttribute("readonly", "readonly");
    inputBairro.setAttribute("readonly", "readonly");
    inputComplemento.setAttribute("readonly", "readonly");
    inputEndereco.classList.add("is-valid");
    inputCidade.classList.add("is-valid");
    inputComplemento.classList.add("is-valid");
    inputBairro.classList.add("is-valid");
    //add option estado no select
    let optionValue = document.createElement("option");
    optionValue.selected = true;
    optionValue.textContent = estado;
    optionValue.value = estado;
    selectEstado.appendChild(optionValue);
    selectEstado.setAttribute("disabled", "true");
    selectEstado.classList.add("is-valid");
  }
}
