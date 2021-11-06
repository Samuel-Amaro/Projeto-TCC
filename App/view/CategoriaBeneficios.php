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
        <!-- ESTILO DA TABELA DO PLUGIN DATATABLES -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <!-- RESPONSIVO DO DATATABLES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"> 
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
                                    <input type="hidden" name="id_usuario" value="<?= $arrayUserDesserializado->getIdUsuario() ?>" id="id_usuario">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="nomeCategoria" class="mb-1 required">Nome Categoria</label>
                                            <input class="form-control" id="nomeCategoria" type="text" placeholder="Entre com o nome da categoria" required maxlength="100" title="Preencha esta campo com o nome da categoria" name="nomeCategoria" minlength="3"/>
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
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">Categoria de Beneficios cadastrados</h3>
                            </div>
                            <div class="card-body">
                                <table id="dataTablesCategoria" class="row-border cell-border hover compact" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
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
        <div class="modal fade" id="modalCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alteração categoria benefício</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid px-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4 class="text-center font-weight-light my-4">Alteração dos dados</h4>
                                    <div class="alert alert-warning mb-0" role="alert">Campos com * são de preenchimento obrigatório!</div>
                                </div>
                                <div class="card-body">
                                    <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="formulario-alterar-categoria" class="form-alterar-categoria" title="Se achar necessário altere as informações contidas neste formulário, de acordo com sua necessidade.">
                                        <input type="hidden" name="idCategoria" id="idCategoria" value=""/>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div>
                                                    <div class="mb-3 mb-md-0">
                                                        <label for="mdNomeCategoria" class="mb-1">Nome categoria</label>
                                                        <input class="form-control mdNomeCategoria" placeholder="Informe aqui, o nome da categoria do beneficio." title="Entre com um nome para identificar a categoria do beneficio" id="nomeCategoria" name="nomeCategoria" type="text" required maxlength="100" minlength="3"/>
                                                        <div class="feedback-nome"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 mb-md-0">
                                                    <label for="mdDescricaoCategoria" class="mb-1">Descrição categoria</label>
                                                    <input type="text" class="form-control mdDescricaoCategoria" placeholder="Informe aqui uma descrição para a categoria do beneficio." title="Entre com uma descrição que ajude a indentificar e descrever esta categoria da melhor forma" id="descricao" name="descricaoCategoria" maxlength="300"/>
                                                    <div class="feedback-descricao"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid gap-2 col-6 mx-auto">
                                                <input type="submit" value="Salvar Alteração" class="btn-alterar-categoria btn btn-primary" title="Clique aqui para alterar a categoria">
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- card body -->    
                            </div><!-- card -->    
                        </div><!-- container fluid-->    
                    </div><!--Modal body-->    
                    <div class="modal-footer">
                        <!--data-dismiss="modal"-->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Clique aqui para fechar a modal de alteração de categoria">Fechar</button>
                    </div>
                </div>
            </div>
        </div><!--modal categoria alterar-->
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
        <!-- modais de alterar-->
        <script src="../../Public/scripts/categorias_beneficios/Modais.js" charset="utf8" type="text/javascript"></script>
        <!-- DATA TABLES-->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>    
        <!-- RESPONSIVO DATA TABLES -->
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js" type="text/javascript" charset="utf8"></script>
        <!-- DATA TABLES CATEGORIA -->
        <script src="../../Public/scripts/categorias_beneficios/Data-Tables-Categoria.js" type="text/javascript" charset="utf8"></script>
        <!-- script para o formulario de cadastrar categoria-->
        <script src="../../Public/scripts/categorias_beneficios/Formulario.js" charset="utf8" type="text/javascript"></script>    
        <!-- script que que tem a função ajax-->
        <script src="../../Public/scripts/categorias_beneficios/Ajax.js" charset="utf8" type="text/javascript"></script>
        <!-- operacoes ajax, tipo cadastrar alterar, excluir, lista -->
        <script src="../../Public/scripts/categorias_beneficios/Operacoes-Ajax.js" type="text/javascript" charset="utf8"></script>    
    </body>
</html>
