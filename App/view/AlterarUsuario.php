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
        function aplicaMascaraTelefone(string $telefone) {
            $dd = substr($telefone, 0, 2); //##
            $digito = substr($telefone, 2, 1); //#
            $digitosParte1 = substr($telefone, 3, 4); //####
            $digitosParte2 = substr($telefone, 7, 4); //####
            $ddFormatado = "(" . $dd .")"; //(##)
            $digitoFormatado = " " . $digito; // #
            $digitosParte1Formatado = $digitosParte1 . "-"; // ####-
            return $ddFormatado . $digitoFormatado . $digitosParte1Formatado . $digitosParte2;
        }
        $dataCadastroSemForm = date_create($arrayUserDesserializado->getDataCadastroUsuario());
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
        <meta name="author" content=""/>
        <title>Painel de controle</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet"/>
        <link rel="stylesheet" href="../../Public/css/estilo_alterar_pagina.css">
        <link rel="stylesheet" href="../../Public/css/estilo_alterar_usuario.css">
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
                <main>
                <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-11">
                                <div class="card border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Sua conta de usuário</h3></div>
                                    <div class="card-body">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="m-2">
                                                    <p>Seu cadastro no nosso sistema foi realizado <?= date_format($dataCadastroSemForm, "d/m/Y")?>  seu último acesso foi <?= $_SESSION["data_hora_login"]; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" enctype="application/x-www-form-urlencoded" method="POST" accept-charset="utf8" autocomplete="on" name="form-alterar-usuario" id="form-alterar-usuario" title="Formulário de Atualização de conta de usuário.">
                                            <input type="hidden" name="operacao" value="atualizar">
                                            <input type="hidden" name="id_usuario" value="<?= $arrayUserDesserializado->getIdUsuario(); ?>" id="id_usuario">
                                            <input type="hidden" name="hash_senha" value="<?= $arrayUserDesserializado->getSenhaUsuario(); ?>" id="hash_senha">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputNome" type="text" placeholder="Entre com seu nome" value="<?= $arrayUserDesserializado->getNomeUsuario(); ?>" maxlength="70" required title="Preencha este campo com seu nome completo"/>
                                                <label for="inputNome">Nome Completo</label>
                                                <div class="alert alert-danger alert-limit-caracteres-nome" role="alert" style="display: none;"></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputCpf" type="text" placeholder="Entre com seu cpf somente numeros" value="<?= $arrayUserDesserializado->getCpfUsuario(); ?>" readonly title="Preecha com seu cpf"/>
                                                        <label for="inputCpf">CPF</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputTelefone" type="text" placeholder="Entre Com seu telefone somente numeros" value="<?= aplicaMascaraTelefone($arrayUserDesserializado->getCelularUsuario()); ?>" required maxlength="15" minlength="15" title="Preencha com seu telefone, somente numeros."/>
                                                        <label for="inputLastTelefone">Telefone</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputEmail" type="email" placeholder="Entre com seu email" value="<?= $arrayUserDesserializado->getEmailUsuario(); ?>" maxlength="100" required title="Preencha com seu email"/>
                                                        <label for="inputEmail">Email</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputCargo" type="text" placeholder="Entre Com seu cargo ou função" value="<?= $arrayUserDesserializado->getCargoUsuario(); ?>" maxlength="100" required title="Preenha com seu cargo ou função dentro da instituição"/>
                                                        <label for="inputCargo">Cargo ou função</label>
                                                        <div class="alert alert-danger alert-limit-caracteres-cargo" role="alert" style="display: none;">Atingiu</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select name="tipoUsuario" id="selectTipoUsuario" class="form-control" required title="Escolha o tipo de usuario ideal para seu perfil">
                                                            <option value="<?=$arrayUserDesserializado->getTipoUsuario(); ?>"><?=$arrayUserDesserializado->getTipoUsuario(); ?></option>
                                                        </select>
                                                        <label for="selectTipoUsuario">Tipo usuario</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" type="password" placeholder="Entre com sua senha" maxlength="12" minlength="6" title="Prencha este campo com sua senha de no minimo 6 caracteres e de no maximo 12 caracteres"/>
                                                        <label for="inputPassword">Senha</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <!--d-grid-->
                                                <div class="d-grid gap-2 col-6 mx-auto">
                                                    <input type="submit" value="Alterar usuário" class="mx-auto">
                                                    <a href="PainelControle.php" class="btn btn-primary btn-voltar mx-auto" target="_self" rel="next">Voltar</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!--
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.html">Have an account? Go to login</a></div>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row content-dinamico">

                    </div>
                </main>
            </div><!--layoutSidenav_nav-->
        </div><!--layoutSidenav-->
        <div class="conteiner-modal">
            <div class="conteiner-header-modal alert-success alert-warning">
                <h3 class="titulo-modal">Titulo Modal</h3>
            </div>
            <div class="modal-content alert-success alert-warning">
                <span class="close">&times;</span>
                <p class="msg-content">Mensagem do modal</p>
            </div>
            <div class="conteiner-footer-modal alert-success alert-warning">
                <a href="../utils/Logout.php" id="button-1-modal" target="_self" rel="next">Entrar</a>
                <a href="../utils/Logout.php" target="_self" rel="next" id="button-2-modal">Sair</a>
            </div>
        </div>
        <script>
            sessionStorage.setItem("id_usuario_logado", "<?php echo $arrayUserDesserializado->getIdUsuario(); ?>");
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../Public/scripts/scripts.js"></script>
        <!-- plugin de alertas bonitos -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript" charset="utf8"></script>
        <!-- script de deletar usuario -->
        <script src="../../Public/scripts/deletar-usuario.js"></script>
        <!-- alterar usuario -->  
        <script type="text/javascript" src="../../Public/scripts/jquery-1.2.6.pack.js"></script>
        <script type="text/javascript" src="../../Public/scripts/jquery.maskedinput-1.1.4.pack.js"></script>
        <script src="../../Public/scripts/alterar-usuario.js"></script>      
    </body>
</html>
