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
        <title>Painel de controle</title>
        <!--style boostrap-->
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
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Painel de controle</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Painel controle</li>
                        </ol>
                        <div class="row mb-4">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="beneficiario-tab" data-toggle="tab" href="#beneficiario"  role="tab" aria-controls="beneficiario" aria-selected="false">Beneficiários</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="beneficio-tab" data-toggle="tab" role="tab" href="#beneficio" aria-controls="beneficio" aria-selected="false">Benefícios</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="forne-doad-tab" data-toggle="tab" role="tab" href="#fornecedores-doadores" aria-controls="fornecedores-doadores" aria-selected="false">Fornecedores e doadores</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="entrega-tab" data-toggle="tab" role="tab" href="#entregas" aria-controls="entregas" aria-selected="false">Entrega benefícios</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="usuarios-tab" data-toggle="tab" role="tab" href="#usuarios" aria-controls="usuarios" aria-selected="false">Usuários</a>
                                </li>
                            </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="beneficiario" role="tabpanel" aria-labelledby="beneficiario-tab">
                                        <?php
                                            #beneficiarios dados
                                            include("TabBeneficiario.php"); 
                                        ?>
                                    </div>
                                    <div class="tab-pane fade" id="beneficio" role="tabpanel" aria-labelledby="beneficio-tab">
                                        <?php 
                                            #beneficios e categorias
                                            include("TabBeneficios.php");    
                                        ?>
                                    </div>
                                    <div class="tab-pane fade" id="fornecedores-doadores" role="tabpanel" aria-labelledby="forne-doad-tab">
                                        <?php 
                                            #fornecedores e doadores
                                            include("TabFornecedoresDoadores.php");
                                        ?>
                                    </div>
                                    <div class="tab-pane fade" id="entregas" role="tabpanel" aria-labelledby="entrega-tab">
                                        <?php 
                                            # entregas de beneficios
                                            include("TabEntregas.php");        
                                        ?>
                                    </div>
                                    <div class="tab-pane fade" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
                                        <?php
                                           # usuarios
                                           include("TabUsuarios.php");
                                        ?>
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>Comparativo entrada e saída no estoque de benefícios</div>
                                    <div class="card-body">
                                        <canvas id="myChart" style="width: 100%;"></canvas>
                                    </div>
                                    <?php
                                        $date = new DateTime(null, new DateTimeZone('America/Sao_Paulo'));
                                    ?>
                                    <div class="card-footer small text-muted">Atualizado em <?php echo $date->format("d/m/Y");?> as <?php echo $date->format("G:i:s");?></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-pie me-1"></i> Benefícios por categoria
                                    </div>
                                    <div class="card-body">
                                        <canvas id="chartPizza" style="width: 100%;"></canvas>
                                    </div>
                                    <div class="card-footer small text-muted">Atualizado em <?php echo $date->format("d/m/Y");?> as <?php echo $date->format("G:i:s");?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php
                    include("Rodape.php");
                ?>
            </div><!--layoutSidenav_nav-->
        </div><!--layoutSidenav-->
        <script>
            sessionStorage.setItem("id_usuario_logado", "<?php echo $arrayUserDesserializado->getIdUsuario(); ?>");
        </script>
        <!-- boostrap script -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../Public/scripts/scripts.js" type="text/javascript" charset="utf8"></script>
        <!-- plugin de alertas bonitos -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript" charset="utf8"></script>
        <!-- JQUERY -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!--graficos plugin -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.js" integrity="sha512-7Fh4YXugCSzbfLXgGvD/4mUJQty68IFFwB65VQwdAf1vnJSG02RjjSCslDPK0TnGRthFI8/bSecJl6vlUHklaw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- script de ajax para solicitar dados para compor graficos -->
        <script src="../../Public/scripts/painel_controle/Ajax.js" type="text/javascript" charset="utf8"></script>  
        <!-- script de deletar usuario -->
        <script src="../../Public/scripts/deletar-usuario.js" type="text/javascript" charset="utf8"></script>  
        <!--scrip que manipula o grafico-->
        <script src="../../Public/scripts/painel_controle/charts-teste.js" type="text/javascript" charset="utf8"></script></script>    
        <!--script que manipula o JS do painel de controle-->
        <script src="../../Public/scripts/painel_controle/painel-controle.js" type="text/javascript" charset="utf8"></script>
    </body>
</html>
