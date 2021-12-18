<?php

require_once("../model/ModelUsuario.php");
require_once("../dao/DaoFornecedoresDoadores.php");

if(session_start()) {
    if(!isset($_SESSION["usuario_logado"])) {
        header("Location: ../../index.php");
        exit;
    }else{
        $arrayUserDesserializado = unserialize($_SESSION["usuario_logado"]);
        $modelUser = new ModelUsuario($arrayUserDesserializado->getIdUsuario(), $arrayUserDesserializado->getCpfUsuario(), $arrayUserDesserializado-> getCelularUsuario(), $arrayUserDesserializado->getEmailUsuario(), $arrayUserDesserializado->getCargoUsuario(), $arrayUserDesserializado->getTipoUsuario(), $arrayUserDesserializado->getSenhaUsuario(), $arrayUserDesserializado->getNomeUsuario());
        $modelUser->setDataCadastroUsuario($arrayUserDesserializado->getDataCadastroUsuario());
        $dao = new DaoFornecedoresDoadores(new DataBase());
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
        <title>Listar Fornecedores e Doações</title>
        <!-- BOOSTRAP -->
        <link href="../../Public/css/styles.css" rel="stylesheet"/>
        <!-- ESTILO DA TABELA DO PLUGIN DATATABLES -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <!-- RESPONSIVO DO DATATABLES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        <!-- ESPECIFICAÇÕ DE CAMPOS REQUIRED OPCIONAIS FORM-->
        <link rel="stylesheet" href="../../Public/css/estilo_form_avisos_required_opcional.css">
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
                        <h2 class="mt-4">Fornecedores e Doadores</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">
                                <a href="PainelControle.php">Painel controle</a>
                            </li>
                            <li class="breadcrumb-item active">Fornecedores e Doadores</li>
                            <li class="breadcrumb-item active">Listagem</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="text-center font-weight-light my-2">Fornecedores e Doadores</h4>
                            </div>
                            <div class="card-body">
                                <table id="dataTablesFornecedoresDoadores" class="row-border cell-border hover compact" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <!--<th>Descrição</th>-->
                                            <th>Identificação</th>
                                            <th>Tipo</th>
                                            <th>CPF</th>
                                            <th>CNPJ</th>
                                            <!--<th>CEP</th>-->
                                            <th>Opções</th>
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
                 include("Rodape.php");
                ?>
            </div><!--layoutSidenav_nav-->
        </div><!--layoutSidenav-->
        <?php 
        # modais de alterar e info
        include("ModalFornecedoresDoadores.php");    
        ?>
        <script>
            sessionStorage.setItem("id_usuario_logado", "<?php echo $arrayUserDesserializado->getIdUsuario(); ?>");
        </script>
        <!--BOOSTRAP-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <!-- MANIPULA JS BOOSTRAP-->
        <script src="../../Public/scripts/scripts.js"></script>
        <!-- plugin de alertas bonitos -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript" charset="utf8"></script>
        <!-- script de deletar usuario -->
        <script src="../../Public/scripts/deletar-usuario.js" type="text/javascript" charset="utf8"></script>
        <!-- JQUERY -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- script de consultar cep -->
        <script src="../../Public/scripts/consulta-cep.js" type="text/javascript" charset="utf8"></script> 
        <!--APLICAR MASCARAS DE QUALQUER TIPO-->
        <script src="../../Public/scripts/mascara/inputMask.js" type="text/javascript" charset="utf8"></script>
        <!-- script de modal info -->
        <script src="../../Public/scripts/fornecedores_doacoes/Modal-Info.js" charset="utf8" type="text/javascript"></script>
        <!-- DATA TABLES-->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
        <!-- RESPONSIVO DATA TABLES -->
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js" type="text/javascript" charset="utf8"></script> 
        <!--validação form, e aplicar mascaras-->
        <script src="../../Public/scripts/fornecedores_doacoes/Formularios-Fornecedores-Doadores.js" type="text/javascript" charset="utf8"></script>
        <!--MODAL ALTERAR-->
        <script src="../../Public/scripts/fornecedores_doacoes/fornecedores-doadores-alterar.js" type="text/javascript" charset="utf8"></script>
        <!-- MOSTRA MODAL ALTERAR FORNECEDOR DOADOR -->
        <script src="../../Public/scripts/fornecedores_doacoes/fornecedores-doadores-delete.js" type="text/javascript" charset="utf8"></script>
        <!-- DATATABLES FORNECEDORES DOADORES -->
        <script src="../../Public/scripts/fornecedores_doacoes/Data-Tables-Fornecedores-Doadores.js" type="text/javascript" charset="utf8"></script>     
    </body>
</html>