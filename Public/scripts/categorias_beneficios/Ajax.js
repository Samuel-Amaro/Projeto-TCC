/**
 * * Esta função faz a solicitação para postar dados no servidor
 * @param {*} url 
 * @param {*} categoria
*/
function makeRequestCategoria(url, categoria, operacao) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    if(operacao == "atualizar") {
        httpRequest.send('nome=' + encodeURIComponent(categoria.nome) + '&descricao=' + encodeURIComponent(categoria.descricao) + '&operacao=' + encodeURIComponent(operacao) + '&id=' + encodeURIComponent(categoria.id));  
    }else if(operacao == "excluir"){
        httpRequest.send('operacao=' + encodeURIComponent(operacao) + '&id=' + encodeURIComponent(categoria));
    }else{
        httpRequest.send('nome=' + encodeURIComponent(categoria.nome) + '&descricao=' + encodeURIComponent(categoria.descricao) + '&operacao=' + encodeURIComponent(operacao));
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
                    limpaCamposFormCategoria();
                    tabela.ajax.reload();
                    return 1;
                } catch (error) {
                    console.error(error.message);
                    console.error(error.name);
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                    return 0;
                }
            }else{
                //return 0;
            }
        }else{
                //alert("Ajax operação assincrona não concluida! onreadystatechange: " + httpRequest.readyState);
                //operação assincrona ajax não chegou no estagio de concluida
                //return 0;
        }
    }
}