/**
 * * Esta função faz solicitações ao servidor por meio da API HTTREQUEST
 * 
 * faz solicitações ao servidor por meio da tecnologia e conceitos ajax
 * @param {*} url 
 * @param {*} categoria 
 * @param {*} operacao 
 */
function makeRequestBeneficio(url, beneficio, operacao) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    if(operacao === "inserir" || operacao === "INSERIR") {
        httpRequest.send('descricao=' + encodeURIComponent(beneficio.descricao) + '&nome=' + encodeURIComponent(beneficio.nome) + '&categoriaId=' + encodeURIComponent(beneficio.categoriaId) + '&cnpjOuCpfFornecedorDoador=' + encodeURIComponent(beneficio.cnpjOuCpfFornecedorDoador) + '&formaAquisica' + encodeURIComponent(beneficio.formaAquisicao) + '&idFornecedorOuDoador=' + encodeURIComponent(beneficio.idFornecedorDoador) + '&nomeFornecedorOuDoador=' + encodeURIComponent(beneficio.nomeFornecedorOuDoador) + '&qtdMaxima=' + encodeURIComponent(beneficio.qtdMaxima) + '&qtdMedida=' + encodeURIComponent(beneficio.qtdMedida) + '&qtdMinima=' + encodeURIComponent(beneficio.qtdMinima) + '&qtdTotal=' + encodeURIComponent(beneficio.qtdTotal) + '&unidadeMedidaId=' + encodeURIComponent(beneficio.unidadeMedidaId) + '&operacao=' + encodeURIComponent(operacao));
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