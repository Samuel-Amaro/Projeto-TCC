/**
 * * ESTA FUNÇÃO E RESPONSAVEL POR MOSTRAR UM MODAL
 */
function mostraModalExcluirFornecedoresDoadores(idFornecedorDoador) {
    Swal.fire({
        title: 'Realmente deseja deletar este fornecedor doador?',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Sim',
        denyButtonText: 'Não',
        customClass: {
          actions: 'my-actions',
          cancelButton: 'order-1 right-gap',
          confirmButton: 'order-2',
          denyButton: 'order-3',
        }
    }).then((result) => {
        //sim deseja deletar
        if (result.isConfirmed) {
            if(makeRequestDeletarFornecedorDoador("../controller/ControllerFornecedoresDoadores.php", idFornecedorDoador)) {
            
            }else{
                /*Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Fornecedor Doador não foi deletado. tivemos um problema interno em nosso servidor, por favor tente novamente mais tarde.',
                    footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
                });*/
            }
        }else if(result.isDenied) {
            //não deseja deletar  
            //Swal.fire('Fornecedor ou doador não sera deletado.', '', 'info');
        }
    });
}


/**
 * * Esta função faz uma solicitação por ajax para deletar os dados de um fornecedor ou doador.
 * @param {*} url 
 * @param {*} id
 */
 function makeRequestDeletarFornecedorDoador(url, id) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('id=' + encodeURIComponent(id) + '&operacao=' + encodeURIComponent('deletar'));
    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = JSON.parse(httpRequest.responseText);  
                    /*Swal.fire(
                        'Obaa...',
                        httpResponse.response,
                        'success'
                    );*/
                    //console.log(tabela);
                    tabela.ajax.reload(); //recarrega tabela
                    location.reload(); //recarrega pagina
                    tabela.draw(); //redesenha tabela
                    return 1;
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Fornecedor Doador não foi deletado. tivemos um problema interno em nosso servidor, por favor tente novamente mais tarde.',
                        footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
                    });
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

