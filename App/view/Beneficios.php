<?php 

require_once("../model/ModelUsuario.php");
require_once("../dao/DaoBeneficio.php");
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
        $daoBeneficio = new DaoBeneficio(new DataBase());
        $unidadesMedidas =  new DaoUnidadesMedidas(new DataBase());
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
        <title>Benefícios</title>
        <!--BOOSTRAP-->
        <link href="../../Public/css/styles.css" rel="stylesheet"/>
        <!-- campos obrigatorios opcionais -->
        <link rel="stylesheet" href="../../Public/css/estilo_form_avisos_required_opcional.css">
        <!-- JQUERY -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- icones -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <!-- ESTILO DA TABELA DO PLUGIN DATATABLES -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <!-- RESPONSIVO DO DATATABLES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        <!--timeline-->
        <link rel="stylesheet" type="text/css" href="../../Public/css/timeline.css">
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
                    <div class="container-fluid px-4 mb-0">
                        <h1 class="mt-4">Benefícios</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">
                                <a href="PainelControle.php">Painel controle</a>
                            </li>
                            <li class="breadcrumb-item">Benefícios</li>
                            <li class="breadcrumb-item active">Visualizar</li>
                        </ol>
                    </div> 
                    <div class="row m-lg-2">
                        <h4>Estatísticas de benefícios</h4>
                    </div>
                    <div class="row m-lg-2">
                        <div class="col-xl-3 col-sm-6 col-12 linkcard mb-2">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="align-self-center col-3">
                                                <i class="fas fa-boxes fs-1"></i>
                                            </div>
                                            <div class="col-9 text-end">
                                                <h3>
                                                <?php
                                                # lista a quantidade de beneficios
                                                    $resul = $daoBeneficio->selectCountBeneficios();
                                                    if(is_array($resul)) {
                                                        $valor = $resul[0];
                                                ?>
                                                        <span class="text-dark"><?= $valor["qtd_beneficios_cadastrados"]; ?></span>       
                                                <?php
                                                    }else{
                                                ?>
                                                        <span class="text-dark">0</span>
                                                <?php
                                                    }
                                                ?>  
                                                </h3>
                                                <span>Quantidade de benefícios</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    # lista a quantidade de beneficios por categoria    
                    $daoBeneficio = new DaoBeneficio(new DataBase());
                    $result2 = $daoBeneficio->selectCountBeneficiosCategoria();
                    if(is_array($result2)) {
                    ?>
                    <div class="row m-lg-2">
                        <h4>Benefícios por categoria</h4>
                    </div>    
                    <div class="row m-lg-2">
                    <?php
                        foreach($result2 as $chave => $valorArray) {
                    ?>
                        <div class="col-xl-3 col-sm-6 col-12 linkcard mb-2">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="align-self-center col-3">
                                                <i class="fas fa-boxes fs-1"></i>
                                            </div>
                                            <div class="col-9 text-end">
                                                <h3>
                                                    <span class="text-dark"><?=$valorArray["qtd_beneficio_categoria"];?></span>         
                                                </h3>
                                                <span><?=$valorArray["nome"];?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    <?php
                        }
                    ?>
                    </div>                  
                    <?php
                    }
                    ?>
                    <div class="row m-lg-2">
                        <h4>Benefícios cadastrados no sistema</h4>
                    </div>
                    <div class="row mt-2 m-lg-3 p-1">
                        <div class="tabela bg-light rounded-1 p-3" style="border: 1px solid rgba(0, 0, 0, 0.125);">
                            <table id="dataTablesListBeneficios" class="row-border cell-border hover" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <!--<th>Forma aquisição</th>-->
                                        <th>Qtd Maxima</th>
                                        <th>Qtd Minima</th>
                                        <!--<th>Categoria</th>-->
                                        <th>Saldo em estoque</th>
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
                    include("ModalBeneficios.php");
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
        <script src="../../Public/scripts/beneficios/Modais.js" type="text/javascript" charset="utf8"></script>  
        <!-- script que manipula datatables-->
        <script src="../../Public/scripts/beneficios/Data-Tables-List-Beneficios.js" type="text/javascript" charset="utf8"></script>
        <!--script que manipula alteração do beneficio-->
        <script src="../../Public/scripts/beneficios/Alterar-Beneficio.js" type="text/javascript" charset="utf8"></script>
        <!-- script que manipula a nova movimentaçaõ do beneficio -->
        <script src="../../Public/scripts/beneficios/Movimentacao-Beneficio.js" type="text/javascript" charset="utf8"></script>
    </body>
</html>