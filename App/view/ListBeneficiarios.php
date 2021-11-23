<?php 

require_once("../model/ModelUsuario.php");
require_once("../dao/DaoBeneficiario.php");

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
        $dao = new DaoBeneficiario(new DataBase());
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content="Pagina de listagem de beneficiarios"/>
        <meta name="author" content="Samuel Amaro"/>
        <title>Painel de controle</title>
        <link href="../../Public/css/styles.css" rel="stylesheet"/>
        <!-- ESTILO DA TABELA DO PLUGIN DATATABLES -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <!--EXTENSÃO DE BOTÕES PARA DATATABLES ESTILO DOS BOTÕES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
        <!-- estiliza botoões de alterar e exluir do datatables -->
        <link rel="stylesheet" href="../../Public/css/estilo_buttons_list_table.css">
        <!-- RESPONSIVO DO DATATABLES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"> 
        <!--ICONES-->
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
                    <div class="container-fluid px-4 mb-2">
                        <h1 class="mt-4">Beneficiários</h1>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="PainelControle.php">Painel controle</a></li>
                            <li class="breadcrumb-item active">Beneficiários</li>
                        </ol>
                        <div class="card mb-2">
                            <div class="card-body">Beneficiários que possuem cadastro no nosso sistema.</div>
                        </div>
                    </div>    
                    <?php 
                      $resultado = $dao->selectCountBeneficiarios();
                      if(is_array($resultado)) {
                    ?>
                    <div class="row m-lg-2">
                        <h4>Quantidade de beneficiários</h4>
                    </div>
                    <div class="row m-lg-2">
                    <?php 
                        $valor = $resultado[0];
                    ?>    
                        <div class="col-xl-3 col-sm-6 col-12 linkcard mb-2">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="align-self-center col-3">
                                                <i class="fas fa-users fs-1"></i>
                                            </div>
                                            <div class="col-9 text-end">
                                                <h3>
                                                    <span class="text-dark"><?=$valor["qtd"];?></span>        
                                                </h3>
                                                <span>Beneficíarios</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <?php
                      }
                    ?>
                    <div class="container-fluid px-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Benefiários cadastrados
                            </div>
                            <div class="card-body">
                                <table id="dataTablesBeneficiarios" class="row-border cell-border hover compact" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <!--<th>Id</th>-->
                                            <th>CPF</th>
                                            <th>Primeiro Nome</th>
                                            <th>Ultimo Nome</th>
                                            <!--<th>Nis</th>-->
                                            <th>Celular</th>
                                            <!--<th>Celular</th>-->
                                            <!--<th>Endereço</th>-->
                                            <!--<th>Bairro</th>-->
                                            <th>Cidade</th>
                                            <!--<th>UF</th>-->
                                            <th>Nª Pessoas Residencia</th>
                                            <th>Renda Per Capita</th>
                                            <!--<th>Observação</th>-->
                                            <!--<th>Email</th>-->
                                            <!--<th>CEP</th>-->
                                            <!--<th>Complemento</th>-->
                                            <!--<th>Abrangencia Cras</th>-->
                                            <th>Editar Beneficiário</th>
                                        </tr>
                                    </thead>
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
        # lista modais de info beneficiario e alterar
        include("ModalBeneficiario.php");    
        ?>
        <script>
            sessionStorage.setItem("id_usuario_logado", "<?php echo $arrayUserDesserializado->getIdUsuario(); ?>");
        </script>
        <!--BOOSTRAP --->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <!-- plugin de alertas bonitos -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript" charset="utf8"></script>
        <script src="../../Public/scripts/scripts.js"></script>
        <!-- script de deletar usuario -->
        <script src="../../Public/scripts/deletar-usuario.js"></script>
        <!--JQUERY VERSION 3.6.0-->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
        <!-- formata cpf e renda -->
        <script type="text/javascript" src="../../Public/scripts/jquery.maskedinput-1.1.4.pack.js"></script>
        <script type="text/javascript" src="../../Public/scripts/jquery.maskMoney.min.js"></script>
        <!-- modal info-->
        <script src="../../Public/scripts/beneficiarios/Modal-Info-Beneficiario.js" charset="utf8" type="text/javascript"></script>
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
        <!-- modal excluir beneficiario -->
        <!--<script src="../../Public/scripts/Modal-Excluir-Beneficiario.js" charset="utf8" type="text/javascript"></script>-->
        <!-- RESPONSIVO DATA TABLES -->
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js" type="text/javascript" charset="utf8"></script>
        <!-- SCRIPT QUE MANIPULA O PLUGIN DATATABLES JS -->
        <script type="text/javascript" charset="utf8" src="../../Public/scripts/DataTablesListBeneficiarios.js"></script>        
        <!--SCRIPT QUE FAZ BUSCA DE CEP NO MODAL -->
        <script src="../../Public/scripts/consulta-cep.js" type="text/javascript" charset="utf8"></script>
        <!-- modal alterar beneficiario -->
        <script src="../../Public/scripts/Modal-Alterar-Beneficiario.js" charset="utf8" type="text/javascript"></script>
    </body>
</html>
