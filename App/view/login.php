<?php require_once("../controller/ControllerUsuario.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pagina de Login, Somente para funcionários autorizados do departamento da central de cestas.">
    <meta name="keywords" content="Login, Pagina de Login, Central de cestas, beneficio social, autenticação">
    <meta name="author" content="Samuel Amaro">
    <title>Login</title>
    <link rel="stylesheet" href="../../Public/css/estilo_login.css">
    <script src="https://kit.fontawesome.com/4cfa17c069.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../Public/scripts/jquery-1.2.6.pack.js"></script>
    <script type="text/javascript" src="../../Public/scripts/jquery.maskedinput-1.1.4.pack.js"></script>
</head>
<body>

    <main class="conteiner-geral">
        <section class="conteiner-login">
            <div class="conteiner-titulo">
                    <h1 class="titulo">Login</h1>
            </div>
            <div class="conteiner-form">
                <form action="#" enctype="multipart/form-data" method="POST" accept-charset="utf8" autocomplete="on" name="formulario_login" class="form_login">
                    <input type="hidden" name="operacao" value="login">
                    <label for="cpf" class="labels">CPF</label>
                    <input type="text" name="cpf" id="cpf" title="Preencha este campo com seu cpf, somente numeros" placeholder=" 999.999.999-99" required>
                    <label for="senha" class="labels">Senha</label>
                    <input type="password" name="senha" id="senha" title="Preencha este campo com sua senha, de no minimo 6 caracteres ou no máximo 12" min="6" max="12" required>
                    <div class="container-button">  
                    </div>
                    <input type="submit" name="login" id="login" value="Login" class="button-login">
                    <div class="cleared"></div>
                    <div class="conteiner-esquece-senha">
                        <a href="#" class="link-esquece-senha"><i class="fas fa-angle-left"></i> Esqueceu a senha?</a>
                    </div>
                </form>
            </div>
        </section>

        <div class="conteiner-modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="content"></p>
            </div>
        </div>

    </main>

    <script type="text/javascript">
        
        $(document).ready(function(){  
            $("#cpf").mask("999.999.999-99");   
        });

        $(".form_login").submit(
            function(event) {
                let cpf = $("#cpf").val();
                let senha = $("#senha").val();
                if(cpf === "" || senha === "") {
                    //console.log("Preencha os campos corretamente!");
                    let modal = document.querySelector(".conteiner-modal");
                    let span = document.
                    querySelector(".close");
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
                    p.textContent = "Preencha os campos corretamente!";
                    event.preventDefault();
                }else{
                    //realiza login com AJAX
                    //let inputCpf = document.querySelectorAll("#cpf");
                    //let cpfSemForm = tiraMascaraCPF(cpf); 
                    if(makeRequest('../controller/ControllerUsuario.php', cpf,  senha)) {
                        let modal = document.querySelector(".conteiner-modal");
                        let span = document.
                        querySelector(".close");
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
                        p.textContent = "Falha ao Fazer Login com Ajax!";
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
            //httpRequest.responseType = 'text';
            httpRequest.send('cpf=' + encodeURIComponent(cpf) + '&senha=' + encodeURIComponent(senha)  + '&operacao=login');

            function alertsContents() {
                if(httpRequest.readyState === 4) {
                    if(httpRequest.status === 200) {
                        //console.log(httpRequest.responseText);
                        //console.log("TIPO DE: " + typeof(httpResponse));
                        try {
                            //modal com resposta de usuario logado
                            let modal = document.querySelector(".conteiner-modal");
                            let span = document.
                            querySelector(".close");
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
                            //se o usuario exite retorna uma string json valida
                            let httpResponse = JSON.parse(httpRequest.responseText); 
                            if(httpResponse.error === 'true') {
                                p.textContent = httpResponse.erro;
                            }else{
                                p.textContent = httpResponse.computedString;
                            }
                            //console.log(httpResponse.toString());               
                        } catch (error) {
                            //se não existir retorna uma mensagem de servidor qualquer dizendo que deu erro, ou algo errado, mas não e uma string json valida
                            //modal com resposta de usuario não logado
                            let modal = document.querySelector(".conteiner-modal");
                            let span = document.
                            querySelector(".close");
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
                            p.textContent = "Usuario com cpf: " + cpf + " Não possui cadastro no sistema!";
                            //se o usuario não existir não retorna json
                            console.error(error.message);
                            console.error(error.name);
                        }
                        //console.log("VALUES: " + Object.values(httpResponse));
                    }else{
                        //alert("Ajax falhou, status http, sem sucesso! status: " + httpRequest.status);
                        return false;
                    }
                }else{
                    //alert("Ajax operação assincrona não concluida! onreadystatechange: " + httpRequest.readyState);
                    return false;
                }
            }
        }

        function tiraMascaraCPF(cpf) {
            let cpfFormatado = cpf;
            let cpfParte1 = cpf.substr(0,3);
            console.log("PARTE 1: " + cpfParte1);
            let cpfParte2 = cpf.substr(4, 3);
            console.log("PARTE 2: " + cpfParte2);
            let cpfParte3 = cpf.substr(8,3);
            console.log("PARTE 3: " + cpfParte3);
            let cpfParte4 = cpf.substr(12,2);
            console.log("PARTE 4: " + cpfParte4);
            let cpfSemFormatacao = cpfParte1 + cpfParte2 + cpfParte3 + cpfParte4;
            return cpfSemFormatacao;
        }
    </script>
</body>
</html>