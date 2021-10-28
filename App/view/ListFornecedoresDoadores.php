<?php
require_once("../model/ModelUsuario.php");
if(session_start()) {
    if(!isset($_SESSION["usuario_logado"])) {
        header("Location: ../../index.php");
        exit;
    }else{
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
        <meta name="description" content="Pagina de listagem de fornecedores e doadores de beneficios"/>
        <meta name="author" content="Samuel Amaro"/>
        <title>Listar Fornecedores/Doações</title>
        <!-- BOOSTRAP -->
        <link href="../../Public/css/styles.css" rel="stylesheet"/>
        <!-- ESTILO DA TABELA DO PLUGIN DATATABLES -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <!-- RESPONSIVO DO DATATABLES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        <!--EXTENSÃO DE BOTÕES PARA DATATABLES ESTILO DOS BOTÕES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
        <!-- estiliza botoões de alterar e exluir do datatables -->
        <link rel="stylesheet" href="../../Public/css/estilo_list_beneficiarios_buttons_table.css">
        <!-- ICONES -->
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
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Fornecedores/Doadores</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">
                                <a href="PainelControle.php">Painel controle</a>
                            </li>
                            <li class="breadcrumb-item active">Listagem</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">Listagem de fornecedores/doadores</div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="text-center font-weight-light my-4">Fornecedores e Doadores</h4>
                            </div>
                            <div class="card-body">
                                <table id="dataTablesFornecedoresDoadores" class="row-border cell-border hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Descrição</th>
                                            <th>Identificação</th>
                                            <th>Tipo</th>
                                            <th>CPF</th>
                                            <th>CNPJ</th>
                                            <th>CEP</th>
                                            <th>Editar Beneficiário</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <?php
                 # rodape
                 include("Rodape.php")
                ?>
            </div><!--layoutSidenav_nav-->
        </div><!--layoutSidenav-->
        <script>
            sessionStorage.setItem("id_usuario_logado", "<?php echo $arrayUserDesserializado->getIdUsuario(); ?>");
        </script>
        <!--BOOSTRAP-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../Public/scripts/scripts.js"></script>
        <!-- plugin de alertas bonitos -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript" charset="utf8"></script>
        <!-- script de deletar usuario -->
        <script src="../../Public/scripts/deletar-usuario.js" type="text/javascript" charset="utf8"></script>
        <!-- JQUERY -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- DATA TABLES-->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
        <!-- EXTENSÃO DE BOTOÕES PARA DATATABLES PLUGIN script-->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
        <!--CONTROLE DE VISIBILIDADE DA COLUNA-->
        <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js" text="text/javascript" charset="utf8"></script>
        <!-- Botões de exportação HTML5 -->
        <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js" text="text/javascript" charset="utf8">
        </script>
        <!--Botão de impressão--->
        <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js" type="text/javascript" charset="utf8"></script>
        <!-- SCRIPT PDFMAKE -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js" integrity="sha512-Yf733gmgLgGUo+VfWq4r5HAEaxftvuTes86bKvwTpqOY3oH0hHKtX/9FfKYUcpaxeBJxeXvcN4EY3J6fnmc9cA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- SCRIPT JZIP JS BUTTON -->
        <script src="../../Public/scripts/jszip.js" type="text/javascript" charset="utf8"></script>
        <!-- RESPONSIVO DATA TABLES -->
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js" type="text/javascript" charset="utf8"></script> 
        <!-- DATATABLES FORNECEDORES DOADORES -->
        <script src="../../Public//scripts/fornecedores_doacoes/Data-Tables-Fornecedores-Doadores.js" type="text/javascript" charset="utf8"></script>     
    </body>
</html>