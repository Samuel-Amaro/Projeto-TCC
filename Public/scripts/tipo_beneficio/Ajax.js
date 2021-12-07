function makeRequestTipoBeneficio(url, tipoBeneficio, operacao) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    if(operacao == "cadastrar") {
       httpRequest.send('nome_tipo=' + encodeURIComponent(tipoBeneficio.nomeBeneficio) + '&id_unidade_medida=' + encodeURIComponent(tipoBeneficio.idUnidadeMedida) + '&id_categoria=' + encodeURIComponent(tipoBeneficio.idCategoriaBeneficio)  + '&operacao=' + encodeURIComponent(operacao));
    }else if(operacao == "atualizar") {
        httpRequest.send('nome_tipo=' + encodeURIComponent(tipoBeneficio.nomeBeneficio) + '&id_unidade_medida=' + encodeURIComponent(tipoBeneficio.idUnidadeMedida) + '&id_categoria=' + encodeURIComponent(tipoBeneficio.idCategoriaBeneficio) + '&id_tipo_beneficio=' + encodeURIComponent(tipoBeneficio.id) + '&operacao=' + encodeURIComponent("alterar"));  
    }/*else if(operacao == "excluir"){
        httpRequest.send('operacao=' + encodeURIComponent(operacao) + '&id=' + encodeURIComponent(tipoObject));
    }else{
        httpRequest.send('tipo=' + encodeURIComponent(tipoObject) + '&operacao=' + encodeURIComponent(operacao));
    }*/
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