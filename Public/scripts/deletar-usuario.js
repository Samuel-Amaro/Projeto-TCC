
//button do dropdow da barra de navegação do topo
let btnDeletar = document.querySelector("#btn-deletar");

//btn que chamar a funcionalidade de deletar conta
//ao clicar no botão do dropdow de deletar conta, chama a modal
btnDeletar.addEventListener("click", function() {
    Swal.fire({
        title: 'Realmente deseja deletar sua conta de usuário?',
        showDenyButton: true,
        showCancelButton: true,
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
            makeRequestDeleteUser("../controller/ControllerUsuario.php", sessionStorage.getItem("id_usuario_logado"));
            sessionStorage.removeItem('id_usuario_logado');
        } else if (result.isDenied) {
            //não deseja deletar  
            Swal.fire('Usuário não sera deletado', '', 'info');
        }
    });
    //mostraModalExcluir('Realmente deseja deletar sua conta de usuário?', 'Deletar conta de usuário', 'Sim', 'Cancelar', 'error');
});

//botões do modal
//let btn1DeletarModal = document.querySelector("#button-1-modal");
//let btn2CancelarDeletarModal = document.querySelector("#button-2-modal");

//se confimar, deletar por ajax
/*
btn1DeletarModal.addEventListener("click", function(){
    makeRequestDeleteUser("../controller/ControllerUsuario.php", sessionStorage.getItem("id_usuario_logado"));
    sessionStorage.removeItem('id_usuario_logado');
});
*/

//cancelar deletar conta de usuario
/*
btn2CancelarDeletarModal.addEventListener("click", function(){
    let modal = document.querySelector(".conteiner-modal");
    modal.style.display = "none";
});
*/

/*
function mostraModalExcluir(mensagemModal, tituloModal, textBtn1, textBtn2, tipo) {
    if(tipo == "sucesso") {
        let divsModal = document.querySelectorAll(".alert-success");
        divsModal.forEach(element => {
            element.style.backgroundColor = "#d4edda";
            element.style.color = "#155724";
        });
    }else{
        let divsModal = document.querySelectorAll(".alert-warning");
        divsModal.forEach(element => {
            element.style.backgroundColor = "#f8d7da";
            element.style.color = "#721c24";
        });
    }

    let titleModal = document.querySelector(".titulo-modal");
    let btn1Modal = document.querySelector("#button-1-modal");
    let btn2Modal = document.querySelector("#button-2-modal");
    let modal = document.querySelector(".conteiner-modal");
    let span = document.querySelector(".close");
    modal.style.display = "block";
    span.addEventListener("click", function() {
        modal.style.display = "none";
    });
    window.addEventListener("click", function(event) {
        if(event.target == modal) {
            modal.style.display = "none";
        }
    });
    let p = document.querySelector(".msg-content");
    p.textContent = mensagemModal;
    titleModal.textContent = tituloModal;
    btn1Modal.textContent = textBtn1;
    btn2Modal.textContent = textBtn2;
}
*/

function makeRequestDeleteUser(url, id_usuario) { 

    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open('POST', url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('id_usuario_logado=' + encodeURIComponent(id_usuario) + '&operacao=deletar');

    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = JSON.parse(httpRequest.responseText); 
                    if(httpResponse.location != "") {
                        window.location = httpResponse.location;
                    }else{
                        mostraModalExcluir(httpResponse.error, "Error ao deletar", "OK", "Sair", "error");
                    } 
                    //return 1;
                } catch (error) {
                    mostraModalExcluir("Erro ao deletar usuário", "Apagar conta de usuário", "Ok", "Sair", "error");
                    console.error(error.message);
                    console.error(error.name);
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                    //return 0;
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