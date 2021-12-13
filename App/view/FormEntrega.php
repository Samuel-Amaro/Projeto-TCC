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
        <meta name="description" content="Pagina de registro de entrega de benefícios"/>
        <meta name="author" content="Samuel Amaro"/>
        <title>Registrar entregas</title>
        <!-- BOOSTRAP -->
        <link href="../../Public/css/styles.css" rel="stylesheet"/>
        <!-- ESTILO FORM VALIDAÇÃO -->
        <link rel="stylesheet" href="../../Public/css/estilo_form_avisos_required_opcional.css">
        <!-- JQUERY UI STYLE -->
        <link rel="stylesheet" href="../../Public/scripts/jquery-ui/jquery-ui.css">
        <!-- ESTILO DA TABELA DO PLUGIN DATATABLES -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <!-- RESPONSIVO DO DATATABLES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"> 
        <!-- ICONES -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
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
                    <div class="container-fluid px-4 mb-2">
                        <h2 class="mt-4">Registrar entregas</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">
                                <a href="PainelControle.php">Painel controle</a>
                            </li>
                            <li class="breadcrumb-item active">Entrega benefícios</li>
                            <li class="breadcrumb-item active">Registrar entrega</li>
                        </ol>
                    </div>
                    <!-- autocomplete com ajax para tipo beneficio -->
                    <div class="container-fluid px-4 pb-0 mb-0">
                        <div class="card mb-1 border-0 pb-0 mb-0">
                            <div class="card-body mb-0">
                                <div class="alert alert-info mb-1 pb-0 p-2" role="alert">
                                    <p>Informe um nome para um beneficiário ou um nome para uma categoria de benefício para obter uma lista de tipo de benefícios e uma lista de beneficiários.</p>  
                                </div>
                                <div class="alert alert-warning mb-0 pb-0">
                                    <p>Campos com * são de preenchimento obrigatório!</p> 
                                </div>
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header">
                                <h4 class="text-center font-weight-light my-2">Registrar entrega</h4>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST" ccept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" target="_self" rel="next" name="form-registro-entrega" class="form-registro-entrega">
                                    <input type="hidden" name="idTipoBeneficio" id="idTipoBeneficio" value="">
                                    <input type="hidden" name="idBeneficiario" id="idBeneficiario" value="">
                                    <input type="hidden" name="id_usuario" value="<?= $arrayUserDesserializado->getIdUsuario() ?>" id="id_usuario">
                                    <div class="row">   
                                        <div class="col-md-5">
                                            <div class="mb-md-0">
                                                <label for="tipoBeneficio" class="mb-1 required">Nome tipo beneficio</label>
                                                <input class="form-control autocomplete-tipo-beneficio" type="text" placeholder="Informe um nome de tipo benefício" title="Preencha este campo com o nome do tipo de benefício que sera entregue" name="tipoBeneficio" id="tipoBeneficio" maxlength="150" min="1" required/>
                                                <div class="feedback-autocomplete-tipo-beneficio"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-md-0">
                                                <label for="beneficiario" class="mb-1 required">Nome beneficiário</label>
                                                <input type="text" name="beneficiario" id="beneficiario" title="Informe um nome para o beneficiario que ira receber o benefício" placeholder="Informe um nome de beneficíario" class="form-control  autocomplete-beneficiario" maxlength="70" required/>
                                                <div class="feedback-autocomplete-nome-beneficiario"></div>
                                            </div>    
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-md-0">
                                                <label for="qtd" class="mb-1 required">Quantidade</label>
                                                <input type="number" name="qtd" id="qtd" title="Informe a quantidade de benefício a ser entregue" placeholder="Informe a quantidade a ser entregue" class="form-control" min="1" required/>
                                                <div class="feedback-quantidade"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 mb-0">
                                        <div class="col-lg-12" style="text-align: right;">
                                            <button type="submit" class="btn-add-registro btn btn-primary" title="Clique aqui para adicionar o registro de entrega a lista de registros a serem cadastrados"><i class="fas fa-plus"></i> Adicionar registro</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid px-4">
                        <div class="card mb-1 border-0">
                            <div class="card-body">
                                <div class="alert alert-dark mb-0 text-center" role="alert">Entregas a serem registradas</div>
                            </div>                    
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="dataTablesRegistroEntregas" class="row-border cell-border hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tipo benefício</th>
                                            <th>Beneficiario</th>
                                            <th>Quantidade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div><!--card body-->
                            <div class="card-footer">
                                <div class="col-lg-12" style="text-align: right;">
                                    <button type="submit" class="btn-registrar btn btn-primary" title="Clique aqui para registrar as entregas"><i class="fas fa-plus"></i> Registrar</button>
                                </div>
                            </div> <!-- card footer-->
                        </div><!-- card -->
                    </div><!--container-fluid-->
                </main>
                <?php
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
        <!-- JQUERY UI AUTOCOMPLETE -->
        <script src="../../Public/scripts/jquery-ui/jquery-ui.js" type="text/javascript" charset="utf8"></script>
        <!-- DATA TABLES-->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>    
        <!-- RESPONSIVO DATA TABLES -->
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js" type="text/javascript" charset="utf8"></script>
        <!--data tables registros entregas a cadastrar-->
        <script src="../../Public/scripts/entregas-beneficios/Data-Tables.js" type="text/javascript" charset="utf8"></script>
        <!-- script autocomplete-->
        <script src="../../Public/scripts/entregas-beneficios/Autocomplete.js" type="text/javascript" charset="utf8"></script>
        <!--validações de formulario -->
        <script src="../../Public/scripts/entregas-beneficios/Formulario.js" type="text/javascript" charset="utf8"></script>
        <!--ajax-->
        <script src="../../Public/scripts/entregas-beneficios/Ajax.js" type="text/javascript" charset="utf8"></script>
        <!--operações ajax-->
        <script src="../../Public/scripts/entregas-beneficios/Operacoes-Ajax.js" type="text/javascript" charset="utf8"></script>
    </body>
</html>
