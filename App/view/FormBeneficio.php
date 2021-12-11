<?php

require_once("../model/ModelUsuario.php");
require_once("../dao/DaoTipoBeneficio.php");
require_once("../dao/DaoTipoAquisicao.php");

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
        $daoTipoBeneficio = new DaoTipoBeneficio(new DataBase());
        $daoTipoAquisicao = new DaoTipoAquisicao(new DataBase());
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content="Pagina de cadastro de beneficios e doações"/>
        <meta name="author" content="Samuel Amaro"/>
        <title>Cadastrar Benefícios</title>
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
                        <h1 class="mt-4">Beneficios</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">
                                <a href="PainelControle.php">Painel controle</a>
                            </li>
                            <li class="breadcrumb-item active">Cadastrar</li>
                        </ol>
                    </div>

                    <!-- autocomplete com ajax -->
                    <div class="container-fluid px-4 pb-0 mb-0">
                        <div class="card mb-1 border-0 pb-0 mb-0">
                            <div class="card-body mb-0">
                                <div class="alert alert-info mb-0 pb-0" role="alert">
                                    <p>Pesquise por um fornecedor ou doador cadastrado. Informando o CPF(caso de pessoa física) ou CNPJ(caso de pessoa jurídica, como empresas, comércios, etc.), ao escolher clique no opção que deseja, e vera o nome do fornecedor ou doador escolhido</p>  
                                </div>
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header">
                                <h4 class="text-center font-weight-light my-2">Pesquisar por fornecedor/doador</h4>
                            </div>
                            <div class="card-body">
                                <form action="#" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="fornecedor-doador-autocomplete" class="form-forn-doad-autocomplete">
                                    <input type="hidden" name="idFornDoador" id="idFornDoador" value="">
                                    <div class="row">
                                        <div class="col-md-4">
                                           <div class="mb-md-0">
                                                <label for="nomeFornecedorDoador" class="mb-1 required">Nome Fornecedor/Doador</label>
                                                <input type="text" title="Aqui vai o nome do fornecedor ou doador escolhido de acordo com o campo do autocomplete" name="nomeFornDoado" id="nomeFornDoador" class="form-control" readonly/>
                                           </div> 
                                        </div>    
                                        <div class="col-md-4">
                                            <div class="mb-md-0">
                                                <label for="fornecedorDoador" class="mb-1 required">Nª CPF/CNPJ de Fornecedores/Doadores</label>
                                                <input class="form-control" type="number" placeholder="Fornecedor/Doador somente numeros" title="Preencha este campo com o nome do fornecedor ou da pessoa que vai fazer uma doação." name="fornecedorDoador" id="autoCompleteFornecedorDoador" maxlength="14" min="1" required/>
                                                <div class="feedback-autocomplete"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-md-0">
                                                <label for="formaAquisicao" class="mb-1 required">Tipo aquisição</label>
                                                <select name="tipoAquisicao" id="tipoAquisicao" title="Escolha um tipo de aquisição" class="form-select" required>
                                                    <option value="SELECIONE" selected>Selecione</option>
                                                    <?php
                                                    $modalResultAquisicao = $daoTipoAquisicao->select();
                                                    if(is_array($modalResultAquisicao)) {
                                                        foreach($modalResultAquisicao as $chave => $valor) {
                                                            ?>
                                                            <option value="<?= $valor["id_tipo_aquisicao"];?>"><?= $valor["tipo"];?></option>
                                                            <?php    
                                                        }
                                                    }else{
                                                        ?>
                                                        <option value="nenhum tipo de aquisição disponivel"><?= $modalResultTipo;?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>    
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- campos fixos -->
                    <div class="container-fluid px-4 mb-1">
                        <div class="card mb-0 border-0 pb-0">
                            <div class="card-body pb-0">
                                <div class="alert alert-warning mb-0 pb-0">
                                    <p>Campos com * são de preenchimento obrigatório!</p> 
                                </div>
                            </div>
                        </div>
                        <div class="card mb-0 border-0">
                            <div class="card-body mb-0">
                                    <div class="alert alert-info mb-0 pb-0" role="alert">
                                        <p>* Se desejar cadastrar mais de um benefício em uma ação só, preencha o formulário abaixo e clique em adicionar beneficio, logo em seguida repita a tarefa novamente, e quando estiver terminado de adicionar os benefícios a serem cadastrados, clique em cadastrar logo abaixo da tabela onde esta os benefícios.</p>
                                        <p>* Beneficios que possuem nomes diferentes possui controle de estoque diferentes.</p>
                                        <p>* Beneficios com mesmo nome, pertencem ao mesmo controle de estoque.</p>
                                    </div>
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header">
                                <h4 class="text-center font-weight-light my-2">Inserir novo benefício</h4>
                            </div>
                            <div class="card-body">
                                <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="formulario-beneficio" class="form-beneficio">
                                    <input type="hidden" name="id_usuario" value="<?= $arrayUserDesserializado->getIdUsuario() ?>" id="id_usuario">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div>
                                                <div class="mb-3 mb-md-0">
                                                    <label for="descricao-beneficio" class="mb-1 required">Descrição</label>
                                                    <input type="text" class="form-control descricao-beneficio" placeholder="Informe aqui, uma descrição sobre este novo beneficio." title="Entre com uma descrição que ajude a indentificar e descrever este beneficio da melhor forma" id="descricao-beneficio" name="descricao-beneficio" maxlength="300" minlength="3"/>
                                                    <div class="feedback-descricao"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="tipoBeneficio" class="mb-1 required">Tipo benefício</label>
                                            <select name="tipoBeneficio" id="tipoBeneficio" title="Escolha um tipo de benefício" class="form-select" required>
                                                <option value="SELECIONE" selected>Selecione</option>
                                                <?php
                                                $modalResultTipo = $daoTipoBeneficio->selectAll();
                                                if(is_array($modalResultTipo)) {
                                                    foreach($modalResultTipo as $chave => $valor) {
                                                        ?>
                                                        <option value="<?= $valor["id_tipo_beneficio"];?>"><?= $valor["nome_tipo"];?></option>
                                                        <?php    
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="nenhum tipo benefício disponivel"><?= $modalResultTipo;?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>  
                                        <div class="col-md-6">
                                            <div class="mb-3 mb-md-0">
                                                <label for="qtd" class="mb-1 required">Quantidade inicial</label>
                                                <input class="form-control" id="qtd" type="number" title="Preencha este campo com o quantidade do beneficio" name="qtd" minlength="1" min="1" required/>
                                                <div class="feedback-qtd"></div>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="mt-3 mb-0">
                                        <div class="col-lg-12" style="text-align: right;">
                                            <button type="submit" class="btn-add-beneficio-lista btn btn-primary" title="Clique aqui para adicionar o benefício a lista abaixo para ser cadastrado"><i class="fas fa-plus"></i> Adicionar benefício</button>
                                        </div>
                                    </div>
                                </form><!--form-->
                            </div><!--card body-->
                        </div><!--card-->
                    </div><!--container-fluid px-4-->
                    <!-- beneficios que vão ser cadastrados -->
                    <div class="container-fluid px-4">
                        <div class="card mb-1 border-0">
                            <div class="card-body">
                                <div class="alert alert-dark mb-0 text-center" role="alert">Benefícios a serem cadastrados</div>
                            </div>                    
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="dataTablesBeneficio" class="row-border cell-border hover" >
                                    <thead>
                                        <tr>
                                            <th>Tipo benefício</th>
                                            <th>Fornecedor/Doador</th>
                                            <th>Forma de Aquisição</th>
                                            <th>Quantidade</th>
                                            <th>CNPJ ou CPF fornecedor/Doador</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div><!--card body-->
                            <div class="card-footer">
                                <div class="col-lg-12" style="text-align: right;">
                                    <button type="submit" class="btn-cadastrar-beneficio btn btn-primary" title="Clique aqui para cadastrar os beneficios, add a tabela acima."><i class="fas fa-plus"></i> Cadastrar</button>
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
        <!--APLICAR MASCARAS DE QUALQUER TIPO-->
        <script src="../../Public/scripts/mascara/inputMask.js" type="text/javascript" charset="utf8"></script>
        <!-- DATA TABLES-->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>    
        <!-- RESPONSIVO DATA TABLES -->
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js" type="text/javascript" charset="utf8"></script>
        <!-- script do autocomplete jquery ui -->
        <script src="../../Public/scripts/jquery-ui/jquery-ui.js" type="text/javascript" charset="utf8"></script>
        <!-- script que faz o autocomplete de fornecedores/doadores -->
        <script src="../../Public/scripts/beneficios/AutoComplete-Fornecedores-Doadores.js" type="text/javascript" charset="utf8"></script>
        <!-- script do formulario de beneficios, que manipula e valida campos -->
        <script src="../../Public/scripts/beneficios/Formulario-Beneficios.js" type="text/javascript" charset="utf8"></script>
        <!-- script que manipula o plugin dataTables -->
        <script src="../../Public/scripts/beneficios/Data-Tables-Beneficios.js" type="text/javascript" charset="utf8"></script>
        <!-- script que contem funções de ajax -->
        <script src="../../Public/scripts/beneficios/Ajax.js" type="text/javascript" charset="utf8"></script>
        <!-- script que faz o tratamento de dados antes de cadastrar por ajax -->
        <script src="../../Public/scripts/beneficios/Form-Beneficio-Submit.js" type="text/javascript" charset="utf8"></script>
        <!-- script que faz a manipulação do ajax para cadastrar-->
        <script src="../../Public/scripts/beneficios/Cadastrar-Beneficio.js" type="text/javascript" charset="utf8"></script>
    </body>
</html>
