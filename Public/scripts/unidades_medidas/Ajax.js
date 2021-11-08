function makeRequestUnidadesMedidas(url, unidadeMedida, operacao) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    if(operacao == "cadastrar") {
       httpRequest.send('sigla=' + encodeURIComponent(unidadeMedida.sigla) + '&descricao=' + encodeURIComponent(unidadeMedida.descricao) + '&operacao=' + encodeURIComponent(operacao));
    }else if(operacao == "atualizar") {
        httpRequest.send('sigla=' + encodeURIComponent(unidadeMedida.sigla) + '&descricao=' + encodeURIComponent(unidadeMedida.descricao) + '&operacao=' + encodeURIComponent(operacao) + '&id=' + encodeURIComponent(unidadeMedida.id));  
    }else if(operacao == "excluir"){
        httpRequest.send('operacao=' + encodeURIComponent(operacao) + '&id=' + encodeURIComponent(unidadeMedida));
    }else{
        httpRequest.send('sigla=' + encodeURIComponent(unidadeMedida.sigla) + '&descricao=' + encodeURIComponent(unidadeMedida.descricao) + '&operacao=' + encodeURIComponent(operacao));
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
                    limpaCamposForm();
                    tabela.ajax.reload();
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