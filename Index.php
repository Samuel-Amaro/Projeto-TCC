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
    <!--<link href="../../Public/css/styles.css" rel="stylesheet"/>-->
    <link rel="stylesheet" href="Public/css/estilo_login.css">
    <script src="https://kit.fontawesome.com/4cfa17c069.js" crossorigin="anonymous"></script>
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
                    <input type="text" name="cpf" id="cpf" title="Preencha este campo com seu cpf, somente numeros" placeholder="cpf" required data-toggle="tooltip" data-placement="right">
                    <!--<label for="senha" class="labels">Senha</label>-->
                    <input type="password" name="senha" id="senha" title="Preencha este campo com sua senha, de no minimo 6 caracteres ou no máximo 12" min="6" max="12" required placeholder="senha" data-toggle="tooltip" data-placement="right">
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
            <div class="conteiner-header-modal alert-success alert-warning">
                <h3 class="titulo-modal"></h3>
            </div>
            <div class="modal-content alert-success alert-warning">
                <span class="close">&times;</span>
                <p class="msg-content"></p>
            </div>
            <div class="conteiner-footer-modal alert-success alert-warning">
                <a href="#" id="button-1-modal" target="_self" rel="next"></a>
                <a href="#" target="_self" rel="next" id="button-2-modal"></a>
            </div>
        </div>
    </main>
    <!-- boostrap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../Public/scripts/scripts.js" type="text/javascript" charset="utf8"></script>
    <!-- plugin de alertas bonitos -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript" charset="utf8"></script>
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!--<script type="text/javascript" src="Public/scripts/jquery.maskedinput-1.1.4.pack.js"></script>
    -->
    <script type="text/javascript" src="Public/scripts/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="Public/scripts/login.js"></script>
</body>
</html>