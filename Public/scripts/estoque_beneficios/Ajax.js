function makeRequestEstoque(url, movimentacaoEstoque, operacao) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    if(operacao == "INSERIR") {
        httpRequest.send('id_tipo_beneficio=' + encodeURIComponent(movimentacaoEstoque.idBeneficio) + '&tipo_movimentacao=' + encodeURIComponent(movimentacaoEstoque.movimentacao) + '&quantidade=' + encodeURIComponent(movimentacaoEstoque.qtd) + '&descricao=' + encodeURIComponent(movimentacaoEstoque.descricao)  + '&operacao=' + encodeURIComponent(operacao));  
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