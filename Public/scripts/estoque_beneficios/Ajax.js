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
                    //limpaModalAddMov();
                    tabela.ajax.reload();
                    // Recarrega a página atual sem usar o cache
                    document.location.reload(true);
                    return 1;
                } catch (error) {
                    if(error instanceof TypeError) {
                        console.error("MENSAGEM DE ERRO: " + error.message); //Mensagem de erro
                        console.error("NOME DO ERRO: " + error.name); //Nome do erro.
                        console.error("NOME ARQUIVO: " + error.fileName); //nome arquivo
                        console.log("NUMERO DA LINHA NO ARQUIVO: " + error.lineNumber); //Número da linha no arquivo que gerou este erro.            
                        console.log("NUMERO DA COLUNA QUE GEROU ERRO: " + error.columnNumber); //Número da coluna na linha que gerou esse erro.          
                        console.log("RASTREAMENTO DA PILHA: " + error.stack); //Rastreamento de pilha      
                        console.error("HTTP RESPONSE: " + httpRequest.responseText);
                    }else{
                        console.error("MENSAGEM DE ERRO: " + error.message);
                        console.error("NOME DO ERRO: " + error.name);
                        console.error("HTTP RESPONSE: " + httpRequest.responseText);
                    }
                    return 0;
                }
            }
        }
    }
}