let valores = [];
let labels = [];

function makeRequestCharts(url, operacao) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    /*try {*/
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    httpRequest.send("operacao=" + encodeURIComponent(operacao));   
    /*} catch (error) {
        console.error(error.name);
        console.error(error.message);
    }*/
    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = JSON.parse(httpRequest.responseText);  
                    //return httpResponse;
                    //console.log("DATA MAKE: " + httpResponse.data);
                    //dados = httpResponse.data[0];
                    setDados(httpResponse.data);
                } catch (error) {
                    console.error(error.message);
                    console.error(error.name);
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                }
            }
        }
    }
}

function setDados(data) {
    dados = data[0];
    valores.push(dados.qtd_total_entrada);
    valores.push(dados.qtd_total_saida);
    valores.push(dados.saldo_atual_estoque);
    //console.log("DENTRO DA FUNÇÃO SET: " + dados);
}
