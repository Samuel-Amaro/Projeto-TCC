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
        <meta name="description" content="Pagina de categorias de beneficios"/>
        <meta name="author" content="Samuel Amaro"/>
        <title>Categorias de Beneficios</title>
        <!--BOOSTRAP-->
        <link href="../../Public/css/styles.css" rel="stylesheet"/>
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
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Benefícios</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">
                                <a href="PainelControle.php">Painel controle</a>
                            </li>
                            <li class="breadcrumb-item active">Categoria de benefícios</li>
                        </ol>
                        <div class="card mb-1">
                            <div class="card-body">Adicionar, modificar, ou excluir novas categorias de benefícios</div>
                        </div>
                        <div class="card border-0 mb-0">
                            <div class="card-body">
                                <div class="alert alert-warning mb-0" role="alert">Campos com * são de preenchimento obrigatório!</div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">Cadastrar categoria de benefícios</h3>
                            </div>
                            <div class="card-body">
                                <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="formulario-cadastro-categoria" class="form-categoria">
                                    <input type="hidden" name="operacao" value="cadastro" id="operacao">
                                    <input type="hidden" name="id_usuario" value="<?= $arrayUserDesserializado->getIdUsuario() ?>" id="id_usuario">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="nomeCategoria" class="mb-1 required">Nome Categoria</label>
                                            <input class="form-control" id="nomeCategoria" type="text" placeholder="Entre com o nome da categoria" required maxlength="100" title="Preencha esta campo com o nome da categoria" name="nomeCategoria"/>
                                            <div class="feedback-nome-categoria"></div>
                                        </div>    
                                        <div class="col-md-8">
                                            <label for="descricaoCategoria" class="mb-1 required">Descrição Categoria</label>
                                            <input class="form-control" id="descricaoCategoria" type="text" placeholder="Entre com uma descrição para a categoria" required maxlength="300" title="Preencha esta campo com uma descrição." name="descricaoCategoria"/>
                                            <div class="feedback-descricao"></div>
                                        </div>    
                                    </div>
                                    <div class="mt-4 mb-0">
                                        <div class="d-grid gap-2 col-6 mx-auto">
                                            <input type="submit" value="Cadastrar" class=" btn-cadastrar-categoria btn btn-primary" title="Clique aqui para cadastrar a categoria">
                                        </div>
                                    </div>
                                </form>
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
        <!-- script para o formulario de cadastrar categoria-->
        <script src="../../Public/scripts/categorias_beneficios/Formulario.js" charset="utf8" type="text/javascript"></script>    
    </body>
</html>
