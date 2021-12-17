async function makeRequestFecht(url, operacao) {
    let cabecalho = new Headers();
    cabecalho.append('contentType', 'application/x-www-form-urlencoded; charset=UTF-8');
    //formulario, contem dados para o server
    let form = new FormData();
    form.append('operacao', operacao);
    //inicialização da api fecht informações para o servidor
    const minhaInicializacao = {
        method: 'POST', //Method HTTP
        headers: cabecalho, //cabecalho http
        body: form //corpo da requisição
    };
    let response = await fetch(url, minhaInicializacao);
    if(!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }else{
        return await response.json();
    }
}

function makeRequestCharts(url, operacao) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    try{
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
                    let dados = httpResponse.data[0];
                    console.log("AJAX: " + dados.qtd_total_entrada);
                    console.log("AJAX: " + dados.qtd_total_saida);
                    console.log("AJAX: " + dados.saldo_atual_estoque);
                    valores.push(dados.qtd_total_entrada, dados.qtd_total_saida, dados.saldo_atual_estoque);
                    return 1;
                } catch (error) {
                    console.error(error.message);
                    console.error(error.name);
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                    return 0;
                }
            }
        }  
    }
}
