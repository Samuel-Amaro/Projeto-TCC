<?php 

require_once("../model/ModelUsuario.php");
require_once("../dao/DaoMovimentacoesEstoqueBeneficios.php");

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
        <title>Estoque de Benefícios</title>
        <!--BOOSTRAP-->
        <link href="../../Public/css/styles.css" rel="stylesheet"/>
        <!-- JQUERY -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- icones -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <!-- ESTILO DA TABELA DO PLUGIN DATATABLES -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <!-- RESPONSIVO DO DATATABLES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        <!--estilo validações do forms-->
        <link rel="stylesheet" href="../../Public/css/estilo_form_avisos_required_opcional.css">
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
                    <div class="container-fluid px-4 mb-4">
                        <h2 class="mt-4">Benefícios</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">
                                <a href="PainelControle.php">Painel controle</a>
                            </li>
                            <li class="breadcrumb-item">Benefícios</li>
                            <li class="breadcrumb-item active">Movimentações</li>
                        </ol>
                    </div> 
                    <div class="row mt-2 m-lg-3 p-1">
                        <div class="tabela bg-light rounded-1 p-3" style="border: 1px solid rgba(0, 0, 0, 0.125);">
                            <table id="dataTablesEstoque" class="row-border cell-border hover compact" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nome tipo</th>
                                        <th>Unidade medida</th>
                                        <th>Categoria</th>
                                        <th>Saldo atual em estoque</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>            
                    </div>
                    <div class="container-fluid px-4"></div>
                </main>
                <?php
                    #modal info estoque
                    include("ModalInfoEstoque.php");
                    #rodape
                    include("Rodape.php");    
                ?>
            </div><!--layoutSidenav_nav-->
        </div><!--layoutSidenav-->
        <script>
            sessionStorage.setItem("id_usuario_logado", "<?php echo $arrayUserDesserializado->getIdUsuario(); ?>");
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../Public/scripts/scripts.js"></script>
        <!-- plugin de alertas bonitos -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript" charset="utf8"></script>
        <!-- script de deletar usuario -->
        <script src="../../Public/scripts/deletar-usuario.js" type="text/javascript" charset="utf8"></script>  
        <!--JQUERY VERSION 3.6.0-->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
        <!-- DATA TABLES-->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>    
        <!-- RESPONSIVO DATA TABLES -->
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js" type="text/javascript" charset="utf8"></script>
        <!-- modais -->
        <script src="../../Public/scripts/estoque_beneficios/Modais.js" type="text/javascript" charset="utf8"></script>  
        <!-- data tables estoque -->
        <script src="../../Public/scripts/estoque_beneficios/DataTablesEstoque.js" type="text/javascript" charset="utf8"></script>  
        <!--ajax-->
        <script src="../../Public/scripts/estoque_beneficios/Ajax.js" type="text/javascript" charset="utf8"></script>
        <!--operações ajax -->
        <script src="../../Public/scripts/estoque_beneficios/Operacoes-Ajax.js" type="text/javascript" charset="utf8"></script>   
    </body>
</html>