
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
