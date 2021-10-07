
function mostraModal(mensagemModal, tituloModal, textBtn1, textBtn2, tipo) {
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

let btnCadastrarUser = document.querySelector(".btn-cadastrar-user");
btnCadastrarUser.addEventListener("click", function(){
    //console.log("clicou");
    let contentDinamico = document.querySelector(".content-dinamico");
    let conteudo = document.createTextNode("<?php include(\"../view/FormUsuarioContent.php\");?>");
    contentDinamico.appendChild(conteudo);
    /*
    let scriptFormUsuario1 = document.createElement('script');
    //jQUERY formatador cpf
    scriptFormUsuario1.src = "../../Public/scripts/jquery-1.2.6.pack.js";
    scriptFormUsuario1.type = "text/javascript";
    let scriptFormUsuario2 = document.createElement('script');
    scriptFormUsuario2.src = "../../Public/scripts/jquery.maskedinput-1.1.4.pack.js";
    scriptFormUsuario2.type = "text/javascript";
    let linkCss = document.createElement('link');
    linkCss.href = "../../Public/css/estilo_form_usuario.css";
    linkCss.rel = "stylesheet";
    let scriptFormUsuario3 = document.createElement('script');
    scriptFormUsuario3.src = "../../Public/scripts/form-usuario.js";
    scriptFormUsuario3.type = "text/javascript";
    let body = document.querySelector('body');
    let head = document.querySelector('head');
    body.appendChild(scriptFormUsuario3);
    head.appendChild(linkCss);
    head.appendChild(scriptFormUsuario1);
    head.appendChild(scriptFormUsuario2);*/
});