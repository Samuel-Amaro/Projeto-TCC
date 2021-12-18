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

