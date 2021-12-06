<?php

require_once("../dao/DaoCategoriaBeneficios.php");
require_once("../model/ModelUsuario.php");
require_once("../dao/DaoUnidadesMedidas.php");

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
        $unidadesMedidas =  new DaoUnidadesMedidas(new DataBase());
        $categorias = new DaoCategoriaBeneficios(new DataBase());
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content="Pagina de criar tipos de beneficios"/>
        <meta name="author" content="Samuel Amaro"/>
        <title>Tipo Benefícios</title>
        <!--BOOSTRAP-->
        <link href="../../Public/css/styles.css" rel="stylesheet"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <!-- ESTILO DA TABELA DO PLUGIN DATATABLES -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <!-- RESPONSIVO DO DATATABLES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"> 
        <!-- estilo dos required e options do form-->
        <link rel="stylesheet" href="../../Public/css/estilo_form_avisos_required_opcional.css">
        <!-- JQUERY -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
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
                        <h1 class="mt-4">Benefícios</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">
                                <a href="PainelControle.php">Painel controle</a>
                            </li>
                            <li class="breadcrumb-item active">Benefícios</li>
                            <li class="breadcrumb-item active">Tipo Benefício</li>
                        </ol>
                        <div class="card border-0 mb-0 pb-0">
                            <div class="card-body pb-0">
                                <div class="alert alert-info mb-0 pb-1" role="alert">
                                    <p>Aqui você poderá criar um tipo de benefício, que possua um nome, uma unidade de medida e uma categoria.
                                    <b>Observação:</b> Ao cria um tipo de benefício, não e especificamente e diretamente um beneficio, e somente um tipo de benefício. não confunda. 
                                    </p>   
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 mb-0">
                            <div class="card-body">
                                <div class="alert alert-warning mb-0" role="alert">Campos com * são de preenchimento obrigatório!</div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="text-center font-weight-light my-2">Criar tipo de benefício</h4>
                            </div>
                            <div class="card-body">
                                <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="formulario-tipo-beneficio" class="form-tipo-beneficio">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="tipo" class="mb-1 required">Nome benefício</label>
                                            <input class="form-control" id="nomeBeneficio" type="text" placeholder="Entre com um tipo de benefício" required  title="Preencha esta campo com um nome de beneficío" name="nomeBeneficio" minlength="1" maxlength="150"/>
                                            <div class="feedback-nomeBeneficio"></div>
                                        </div>        
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="unidadeMedida" class="mb-1 required">Unidade de medida</label>
                                            <select name="unidadeMedida" id="unidadeMedida" class="form-select" title="Escolha uma unidade de medida" required>
                                                <option value="SELECIONE" selected>Selecione</option>
                                                <?php 
                                                    $uni = $unidadesMedidas->select();
                                                    if(is_array($uni)) {
                                                        foreach($uni as $chave => $valor) {
                                                ?>
                                                        <option value="<?= $valor["id_unidade"];?>"><?= $valor["descricao"]?>-<?= $valor["sigla"];?></option> 
                                                <?php
                                                        }  
                                                    }else{
                                                ?>
                                                    <option value="Nenhuma Unidade disponivel">Nenhuma unidade Cadastrada</option>
                                                <?php 
                                                    }  
                                                ?>
                                            </select>
                                            <div class="feedback-unidade-medida"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="categoriaBeneficio" class="mb-1 required">Categoria</label>
                                            <select id="categoriaBeneficio" class="form-select" title="Selecione a categoria em que o beneficio, se enquandra adequandamente." name="categoriaBeneficio" required>
                                                <option value="SELECIONE" selected>Selecione</option>
                                                <?php
                                                $cat = $categorias->selectAll();
                                                if(is_array($cat)) {
                                                    foreach($cat as $chave => $valor) {
                                                        ?>
                                                        <option value="<?= $valor["id_categoria"];?>"><?= $valor["nome"];?></option>
                                                        <?php    
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="nenhuma categoria disponivel"><?= $cat;?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="feedback-categoria"></div> 
                                        </div>
                                    </div>
                                    <div class="mt-4 mb-0">
                                        <div class="d-grid gap-2 col-2 mx-auto">
                                            <input type="submit" value="Cadastrar" class="btn-cadastrar-tipo btn btn-primary" title="Clique aqui para cadastrar o tipo de benefício">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="text-center font-weight-light my-2">Tipos de benefício cadastrados</h4>
                            </div>
                            <div class="card-body">
                                <table id="dataTablesTipoBeneficio" class="row-border cell-border hover compact" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tipo benefício</th>
                                            <th>Unidade medida</th>
                                            <th>Categoria</th>
                                            <th>Ações</th>
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
                    #rodape
                    include("Rodape.php");    
                ?>
            </div><!--layoutSidenav_nav-->
        </div><!--layoutSidenav-->
        <?php 
            #modais
            include("ModalTipoBeneficio.php");
        ?>
        <script>
            sessionStorage.setItem("id_usuario_logado", "<?php echo $arrayUserDesserializado->getIdUsuario(); ?>");
        </script>
        <!-- SCRIPTS BOOSTRAP -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../Public/scripts/scripts.js"></script>
        <!-- plugin de alertas bonitos -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript" charset="utf8"></script>
        <!-- script de deletar usuario -->
        <script src="../../Public/scripts/deletar-usuario.js" type="text/javascript" charset="utf8"></script>   
        <!-- DATA TABLES-->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>    
        <!-- RESPONSIVO DATA TABLES -->
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js" type="text/javascript" charset="utf8"></script>
        <!--data tables-->
        <script src="../../Public/scripts/tipo_beneficio/Data-Tables.js" type="text/javascript" charset="utf8"></script>
        <!-- script formulario, aplica validações, e tratamento de dados-->
        <script src="../../Public/scripts/tipo_beneficio/Formulario.js" type="text/javascript" charset="utf8"></script>
        <!--ajax-->
        <script src="../../Public/scripts/tipo_beneficio/Ajax.js" type="text/javascript" charset="utf8"></script>
        <!-- script que manipula as operações de ajax -->
        <script src="../../Public/scripts/tipo_beneficio/Operacoes-Ajax.js" type="text/javascript" charset="utf8"></script>
        <!-- modais -->
        <script src="../../Public/scripts/tipo_beneficio/Modais.js" type="text/javascript" charset="utf8"></script>
    </body>
</html>