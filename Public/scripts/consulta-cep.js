
let btnBuscaCep = document.querySelector(".btn-busca-cep");

btnBuscaCep.addEventListener("click", function() {
    pesquisaCep();
});

function pesquisaCep() {
    let cepValor = document.querySelector("#inputCep").value;
    //nova variavel "cep" somente com digitos
    let cepDigitos = cepValor.replace(/\D/g, '');
    //verifica se campo cep possui valor informado
    if(cepDigitos != "") {
        //expressão regular para valida o CEP
        let validaCep = /^[0-9]{8}$/;
        //valida o formato do CEP
        if(validaCep.test(cepDigitos)) {
           //busca cep com ajax e retorna um json
           let url = "https://viacep.com.br/ws/" + cepDigitos + "/json/";
           console.log(makeRequest(url));
        }else{
            console.log("Erro ao trazer o cep");
        }
    }else{
        console.log("Cep invalido os digitos");
    }
}

function makeRequest(url) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open('GET', url, true);
    //httpRequest.responseType = "json";
    httpRequest.send();
    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = httpRequest.responseText;  
                    return httpResponse;
                } catch (error) {
                    console.error(error.message);
                    console.error(error.name);
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                    //return null;
                }
            }else{
        
            }
        }else{
    
        }
    }
}
