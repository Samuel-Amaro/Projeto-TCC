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
        <meta name="author" content=""/>
        <title>Usuários cadastrados</title>
        <!--ESTILO DO PLUGIN DATA TABLES, SEM DEPENDENCIA DE JQURY-->
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
        <link href="../../Public/css/styles.css" rel="stylesheet"/>
        <!-- estilo do painel de controle-->
        <link rel="stylesheet" href="../../Public/css/estilo_painel_controle.css">
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
                    <div class="row content-dinamico">

                    </div>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Usuários</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="PainelControle.php">Painel controle</a></li>
                            <li class="breadcrumb-item active">Usuários</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">Usuários ativos no sistema.</div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <p>Se achar necessario fazer o download da tabela mostrada abaixo, selecione uma das opções abaixo e clique no botão azul!</p>
                            </div>
                            <div class="card-body">
                                <div class="m-2">
                                    <label for="tipo">Formato Arquivo:</label>
                                    <select name="tipo" id="tipo-file">
                                        <option value="sql">SQL</option>
                                        <option value="json">JSON</option>
                                        <option value="csv">CSV</option>
                                        <option value="txt">TXT</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary m-2 baixa-tabela" type="button">Fazer Download Arquivo</button>
                                <div class="alert alert-danger" role="danger" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Usuários Ativos.
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>CPF</th>
                                            <th>Celular</th>
                                            <th>Email</th>
                                            <th>Cargo</th>
                                            <th>Tipo</th>
                                            <th>Nome</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>CPF</th>
                                            <th>Celular</th>
                                            <th>Email</th>
                                            <th>Cargo</th>
                                            <th>Tipo</th>
                                            <th>Nome</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <?php
                    include("Rodape.php");
                ?>
            </div><!--layoutSidenav_nav-->
        </div><!--layoutSidenav-->

        <!--modal excluir-->
        <!--<div class="conteiner-modal">
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../Public/scripts/scripts.js"></script>
        <!-- plugin de alertas bonitos -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript" charset="utf8"></script>
        <!-- script de deletar usuario -->
        <script src="../../Public/scripts/deletar-usuario.js"></script>     
        <!-- Data tables-->
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>   
        <!-- lista usuarios ajax -->
        <script src="../../Public/scripts/usuarios.js" type="text/javascript"></script>
    </body>
</html>
