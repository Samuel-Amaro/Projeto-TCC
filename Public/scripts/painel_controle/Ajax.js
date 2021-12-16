let dados;

function makeRequestCharts(url, operacao) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    try {
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        httpRequest.send("operacao=" + encodeURIComponent(operacao));   
    } catch (error) {
        console.error(error.name);
        console.error(error.message);
    }
    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = JSON.parse(httpRequest.responseText);  
                    console.log(httpResponse.dados);
                    setDados(httpResponse.dados);
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
    dados = data;
    console.log("DENTRO DA FUNÇÃO SET: " + dados);
    getDados();
}

function getDados() {
    console.log("DENTRO DA FUNÇÃO GET: " + dados);
    return dados;
}