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
                    <h1 class="titulo">Central de cestas</h1>
                    <!--
                    <div class="logo">
                        <img src="../../Public/img/icon-cesta.png" alt="icone de imagem de cesta" width="80px"
                         height="80px">
                    </div>
                    ---->
            </div>
            <div class="conteiner-form">
                <form action="#" enctype="multipart/form-data" method="POST" accept-charset="utf8" autocomplete="on" name="formulario_login" class="form_login">
                    <input type="hidden" name="operacao" value="login">
                    <!--<label for="cpf" class="labels">CPF</label>-->
                    <input type="text" name="cpf" id="cpf" title="Preencha este campo com seu cpf, somente numeros" placeholder="cpf" required>
                    <!--<label for="senha" class="labels">Senha</label>-->
                    <input type="password" name="senha" id="senha" title="Preencha este campo com sua senha, de no minimo 6 caracteres ou no máximo 12" min="6" max="12" required placeholder="senha">
                    <div class="conteiner-esquece-senha">
                        <a href="#" class="link-esquece-senha">esqueci minha senha</a>
                    </div>
                    <input type="submit" name="login" id="login" value="Login" class="button-login">
                    <!--<div class="cleared"></div>-->
                    
                </form>
            </div>
            <div class="conteiner-footer">
                <p>Não possui cadastro? <br> <a href="#">Se cadastre aqui!</a></p>
            </div>
        </section>
        <div class="conteiner-modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="content"></p>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="../../Public/scripts/login.js"></script>
</body>
</html>