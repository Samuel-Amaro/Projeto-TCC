<?php 

require_once("../model/ModelUsuario.php");

if(session_start()) {
    //se o objeto do usuario não existe na seção
    if(!isset($_SESSION["usuario_logado"])) {
        //manda um redirecionamento para login
        header("Location: ../../index.php");
        exit;
    }else{
        //se ja existir o dado do usuario logado na session, intanciar um model
        //desserializar o objeto model setado na seção
        $arrayUserDesserializado = unserialize($_SESSION["usuario_logado"]);
        $modelUser = new ModelUsuario($arrayUserDesserializado->getIdUsuario(), $arrayUserDesserializado->getCpfUsuario(), $arrayUserDesserializado-> getCelularUsuario(), $arrayUserDesserializado->getEmailUsuario(), $arrayUserDesserializado->getCargoUsuario(), $arrayUserDesserializado->getTipoUsuario(), $arrayUserDesserializado->getSenhaUsuario(), $arrayUserDesserializado->getNomeUsuario());
        $modelUser->setDataCadastroUsuario($arrayUserDesserializado->getDataCadastroUsuario());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content="Samuel Amaro"/>
        <title>Cadastro de Usuários</title>
        <!-- estilo do form usuario -->
        <link rel="stylesheet" href="../../Public/css/estilo_form_usuario.css">
        <link href="../../Public/css/styles.css" rel="stylesheet"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <!--MENU NAVEGAÇÃO DO TOPO-->
        <?php
        include("../view/MenuNavegacaoTop.php");
        ?>
        <div id="layoutSidenav">
            <!--BARRA DE NAVEGAÇÃO LATERAL ESQUERDA-->
            <?php 
            include("../view/BarraLateralNavegacao.php");
            ?>
            <div id="layoutSidenav_content">
                <main style="overflow: hidden;">
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Usuários</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">
                                <a href="PainelControle.php">Painel controle</a>
                            </li>
                            <li class="breadcrumb-item active">Cadastrar</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">Cadastrar novos usuários no sistema</div>
                            <div class="card-footer">
                                <div class="alert alert-warning mb-0" role="alert">Campos com * são de preenchimento obrigatório!</div>
                            </div>
                        </div>
                    </div>
                    <div class="row content-dinamico">
                        <div class="flex-container">
                            <header class="conteiner-description">
                                <div class="conteiner-h2">
                                    <h2>Criar conta usuário</h2>
                                </div>
                                <div class="conteiner-p">
                                    <p>Ao cadastrar um novo usuário se atente ao tipo de usuário que estará cadastrando isso poderá dar permissões que você não queira a pessoas não confiáveis.</p>
                                </div>
                            </header>
                            <form action="" method="POST" name="form_usuario" id="form_usuario" title="Formulario de cadastro de um novo usuario" enctype="multipart/form-data" accept-charset="utf8" autocomplete="on">
                                <input type="hidden" name="operacao" value="cadastro">
                                <div class="container-row-not-flex">
                                    <label for="nome" id="labels">Nome Completo</label>
                                    <input type="text" name="nome" id="nome" title="Informe seu nome completo" required placeholder="Informe seu nome completo" maxlength="70">
                                    <span class="limit-char"></span>
                                    <div class="valid-feedback-nome"></div>
                                </div>
                                <div class="linha-grupo-label">
                                    <label for="cpf" class="labels-flex-group-1">CPF</label>
                                    <label for="celular" class="labels-flex-group-1">Telefone Pessoal</label>
                                </div>
                                <div class="linha-grupo-inputs">
                                    <input type="text" name="cpf" id="cpf" class="primeiro-input" title="Informe somente os numeros de seu cpf" required placeholder="Informe Seu cpf somente numeros">
                                    <input type="text" name="telefone" id="telefone" class="segundo-input" required title="Informe somente os numeros de seu telefone, incluindo DD" placeholder="Informe seu telefone somente numeros" maxlength="15">
                                </div>
                                <div class="linha-grupo-label">
                                    <label for="email" id="labels-flex">Email Pessoal</label>
                                    <label for="cargo" id="labels-flex">Cargo ou Função</label>
                                </div>
                                <div class="linha-grupo-inputs">
                                    <input type="email" name="email" id="email" class="primeiro-input" title="Informe seu email pessoal por favor" required placeholder="Informe seu email email@dominio.com">
                                    <input type="text" name="cargo" id="cargo" class="segundo-input" title="Informe o cargo ou função que você exerce dentro da instituição" required placeholder="Informe cargo ou função" maxlength="100">
                                    <!--<div class="valid-feedback-cargo"></div>-->
                                </div>
                                <div class="linha-grupo-label">
                                    <label for="tipo" id="labels-flex">Tipo usuário</label>
                                    <label for="senha" id="labels-flex">Senha</label>
                                </div>
                                <div class="linha-grupo-inputs">
                                    <select name="tipo" id="tipo" required title="Escolha o tipo de perfil de usuário que satisfará o objetivo do usuário em utilizar o sistema, lembre-se de acordo com o tipo de usuário existem funcionalidades no sistema que certos perfis não poderão utilizar.
                                    " class="primeiro-input">
                                        <option value="adm">Administrador</option>
                                        <option value="comun">Comun</option>
                                    </select>
                                    <input type="password" name="senha" id="senha" required title="Informe uma senha válida entre 6 a 12 caracteres válidos." class="segundo-input" placeholder="Informe uma senha" minlength="6" maxlength="12">
                                </div>
                                <div class="conteiner-buttons">
                                    <a href="PainelControle.php" target="_self" rel="next" id="link">Voltar</a>
                                    <input type="submit" value="Cadastrar" id="button">
                                </div>
                            </form>
                        </div>  
                    </div>
                </main>
                <!--
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
                -->
            </div><!--layoutSidenav_nav-->
        </div><!--layoutSidenav-->

        <!--modal excluir-->
        <!--
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
        </div>--><!--modal excluir-->
        <script>
            sessionStorage.setItem("id_usuario_logado", "<?php echo $arrayUserDesserializado->getIdUsuario(); ?>");
        </script>
        <!-- scripts boostrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous" type="text/javascript"></script>
        <script src="../../Public/scripts/scripts.js" type="text/javascript"></script>
        <!-- plugin de alertas bonitos -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript" charset="utf8"></script>
        <!-- script de deltar conta de usuario logado -->
        <script src="../../Public/scripts/deletar-usuario.js" type="text/javascript"></script>        
        <!--<script src="../../Public/scripts/painel_controle.js"></script>-->
        <!-- formata campos de CPF -->
        <script type="text/javascript" src="../../Public/scripts/jquery-1.2.6.pack.js"></script>
        <script type="text/javascript" src="../../Public/scripts/jquery.maskedinput-1.1.4.pack.js"></script>
        <!-- script da view do form usuario-->
        <script src="../../Public/scripts/form-usuario.js" type="text/javascript"></script>
    </body>
</html>
