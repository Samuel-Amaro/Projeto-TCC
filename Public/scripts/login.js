
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


/*
function mostraModal(mensagem) {
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
    let p = document.querySelector(".content");
    p.textContent = mensagem;
}
*/

$(document).ready(function(){  
    $("#cpf").mask("999.999.999-99");   
});

$(".form_login").submit(
    function(event) {
        let cpf = $("#cpf").val();
        let senha = $("#senha").val();
        if(cpf === "" || senha === "") {
            mostraModal("Preencha os Campos Corretamente", "Campos incorretos", "Ok", "Cancelar", "error");
            event.preventDefault();
        }else{
            //realiza login com AJAX
            //retorna true ou algo diferente de false, e porque deu certo
            if(makeRequest('App/controller/ControllerUsuario.php', tiraMascaraCPF(cpf), senha) === false) {
                mostraModal("Falha ao Fazer Login com Ajax!", "Falha ao realizar Login", "Tentar Novamente", "Cancelar", "error");
                //não submete o form
                event.preventDefault();
            }else{
                event.preventDefault();
            }
        }
    }
);

function makeRequest(url, cpf, senha) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open('POST', url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //httpRequest.responseType = 'document';
    httpRequest.send('cpf=' + encodeURIComponent(cpf) + '&senha=' + encodeURIComponent(senha)  + '&operacao=login');

    function alertsContents() {
        //modal com resposta de usuario logado
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    //se o usuario exite retorna uma string json valida com dados de resposta do servidor
                    let httpResponse = JSON.parse(httpRequest.responseText);  
                    //propriedade de erro do json for true, houve erro
                    if(httpResponse.error === true) {
                        mostraModal(httpResponse.erro, "Erro ao realizar login", "Tentar Novamente", "Cancelar", "error");
                    }else{
                        //redireciona o usuario para o painel de controle, caso usuario esteja tudo correto
                        window.location = httpResponse.location;
                    }
                } catch (error) {
                    //caso o servidor retorne uma string json não valida
                    mostraModal("Usuario com cpf: " + cpf + " Não possui cadastro no sistema!", "Usuario não existe", "Ok", "Cancelar", "error");
                    console.error(error.message);
                    console.error(error.name);
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                }
            }else{
                //codigo de status HTTP não e de sucesso
                //return false;
            }
        }else{
                //alert("Ajax operação assincrona não concluida! onreadystatechange: " + httpRequest.readyState);
                //operação assincrona ajax não chegou no estagio de concluida
                //return false;
        }
    }
}

function tiraMascaraCPF(cpf) {
    let cpfFormatado = cpf;
    let cpfParte1 = cpf.substr(0,3);
    //console.log("PARTE 1: " + cpfParte1);
    let cpfParte2 = cpf.substr(4, 3);
    //console.log("PARTE 2: " + cpfParte2);
    let cpfParte3 = cpf.substr(8,3);
    //console.log("PARTE 3: " + cpfParte3);
    let cpfParte4 = cpf.substr(12,2);
    //console.log("PARTE 4: " + cpfParte4);
    let cpfSemFormatacao = cpfParte1 + cpfParte2 + cpfParte3 + cpfParte4;
    return cpfSemFormatacao;
}
