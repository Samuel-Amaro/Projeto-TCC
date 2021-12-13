function makeRequestEntrega(url, entrega, operacao) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    if(operacao === "cadastrar" || operacao === "CADASTRAR") {
        try {
            //httpRequest.setRequestHeader('Content-Type', 'application/json');
            httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            httpRequest.send("data=" + encodeURIComponent(entrega) + "&operacao=" + encodeURIComponent(operacao));   
        } catch (error) {
            console.error(error.name);
            console.error(error.message);
        }
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
