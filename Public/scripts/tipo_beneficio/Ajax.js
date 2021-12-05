function makeRequestTipoBeneficio(url, tipoBeneficio, operacao) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    if(operacao == "cadastrar") {
       httpRequest.send('nome_tipo=' + encodeURIComponent(tipoBeneficio.nomeBeneficio) + '&id_unidade_medida=' + encodeURIComponent(tipoBeneficio.idUnidadeMedida) + '&id_categoria=' + encodeURIComponent(tipoBeneficio.idCategoriaBeneficio)  + '&operacao=' + encodeURIComponent(operacao));
    }/*else if(operacao == "atualizar") {
        httpRequest.send('nome_tipo=' + encodeURIComponent(tipoBeneficio.nomeBeneficio) + '&id_unidade_medida=' + encodeURIComponent(tipoBeneficio.idUnidadeMedida) + '&id_categoria=' + encodeURIComponent(tipoBeneficio.idCategoriaBeneficio) + '&id_tipo_beneficio=' + encodeURIComponent(tipoBeneficio.id) + '&operacao=' + encodeURIComponent(operacao));  
    }else if(operacao == "excluir"){
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
                    //tabela.ajax.reload();
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