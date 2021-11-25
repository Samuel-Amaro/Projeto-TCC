<?php

require_once("../model/ModelUsuario.php");
require_once("../dao/DaoCategoriaBeneficios.php");
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
        $categorias = new DaoCategoriaBeneficios(new DataBase());
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
        <meta name="description" content="Pagina de cadastro de beneficios e doações"/>
        <meta name="author" content="Samuel Amaro"/>
        <title>Cadastrar Beneficios</title>
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
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Beneficios</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">
                                <a href="PainelControle.php">Painel controle</a>
                            </li>
                            <li class="breadcrumb-item active">Cadastrar</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">Cadastrar novos Beneficios</div>
                        </div>
                    </div>
                    <!-- autocomplete com ajax -->
                    <div class="container-fluid px-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="alert alert-info mb-0" role="alert">Pesquise por um fornecedor ou doador cadastrado. Informando o CPF(caso de pessoa física) ou CNPJ(caso de pessoa jurídica, como empresas, comércios, etc.), ao escolher clique no opção que deseja, e vera o nome do fornecedor ou doador escolhido</div>
                            </div>
                            <div class="card-body">
                                <form action="#" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="fornecedor-doador-autocomplete" class="form-forn-doad-autocomplete">
                                    <input type="hidden" name="idFornDoador" id="idFornDoador" value="">
                                    <div class="row">
                                        <div class="col-md-6">
                                           <div class="mb-md-0">
                                                <label for="nomeFornecedorDoador" class="mb-1">Nome Fornecedor/Doador</label>
                                                <input type="text" title="Aqui vai o nome do fornecedor ou doador escolhido de acordo com o campo do autocomplete" name="nomeFornDoado" id="nomeFornDoador" class="form-control" readonly/>
                                           </div> 
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="mb-md-0">
                                                <label for="fornecedorDoador" class="mb-1 required">Nª CPF/CNPJ de Fornecedores/Doadores</label>
                                                <!--<div class="input-group mb-1">-->
                                                    <!-- type="search" -->
                                                <input class="form-control" type="number" placeholder="Fornecedor/Doador" title="Preencha este campo com o nome do fornecedor ou da pessoa que vai fazer uma doação." name="fornecedorDoador" id="autoCompleteFornecedorDoador" maxlength="14" min="1" required/>
                                                    <!--<button class="btn btn-primary" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></butt>-->
                                                <!--</div>-->
                                                <div class="feedback-autocomplete"></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- campos fixos -->
                    <div class="container-fluid px-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                    <div class="alert alert-warning mb-1">Campos com * são de preenchimento obrigatório!</div>
                                    <div class="alert alert-info mb-0" role="alert">
                                        <p>* Se desejar cadastrar mais de um benefício em uma ação só, preencha o formulário abaixo e clique em adicionar beneficio, logo em seguida repita a tarefa novamente, e quando estiver terminado de adicionar os benefícios a serem cadastrados, clique em cadastrar logo abaixo da tabela onde esta os benefícios.</p>
                                        <p>* Beneficios que possuem nomes diferentes possui controle de estoque diferentes.</p>
                                        <p>* Beneficios com mesmo nome, pertencem ao mesmo controle de estoque.</p>
                                    </div>
                            </div>
                            <div class="card-body">
                                <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="formulario-beneficio" class="form-beneficio">
                                    <input type="hidden" name="id_usuario" value="<?= $arrayUserDesserializado->getIdUsuario() ?>" id="id_usuario">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div>
                                                <div class="mb-3 mb-md-0">
                                                    <label for="descricao-beneficio" class="mb-1 required">Descrição Beneficio</label>
                                                    <input type="text" class="form-control descricao-beneficio" placeholder="Informe aqui, uma descrição sobre este novo beneficio." title="Entre com uma descrição que ajude a indentificar e descrever este beneficio da melhor forma" id="descricao-beneficio" name="descricao-beneficio" maxlength="70" minlength="3" required/>
                                                    <div class="feedback-descricao"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="nomeBeneficio" class="mb-1 required">Nome</label>
                                            <input class="form-control" id="nomeBeneficio" type="text" placeholder="Entre com o nome beneficio" title="Preencha esta campo com o nome do beneficio." name="nomeBeneficio" maxlength="70" minlength="3" required/>
                                            <div class="feedback-nome"></div>
                                        </div>    
                                        <div class="col-md-2">
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
                                        <div class="col-md-4">
                                            <label for="formaAquisicao" class="mb-1 required">Forma de Aquisição</label>
                                            <select id="formaAquisicao" class="form-select" title="Informe como foi adquirido o beneficio" name="formaAquisicao" required>
                                                <option value="SELECIONE" selected>Selecione</option>
                                                <option value="licitacao">Licitação</option>
                                                <option value="doacao">Doação</option>
                                                <option value="compra">Compra</option>
                                            </select>
                                            <div class="feedback-aquisicao"></div>
                                        </div>  
                                    </div>
                                    <div class="row mb-2">
                                            <div class="col-md-2">
                                                <div class="mb-3 mb-md-0">
                                                    <label for="qtdTotal" class="mb-1 required">Quantidade Total</label>
                                                    <input class="form-control" id="qtdTotal" type="number" title="Preencha este campo com o quantidade total do beneficio" name="qtdTotal" minlength="0" min="0" required/>
                                                    <div class="feedback-qtd-total"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3 mb-md-0">
                                                    <label for="unidadeMedida" class="mb-1 required">Unidade Medida</label>
                                                    <select name="unidadeMedida" id="unidadeMedida" class="form-select" title="Escolha a melhor unidade de medida que seja adequanda para quantificar e contalizar o beneficio." required>
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
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3 mb-md-0">
                                                    <label for="qtdPorMedida" class="mb-1 required">Quantidade por medida</label>
                                                    <input name="qtdPorMedida" id="qtdPorMedida" class="form-control"  title="Informe a quantidade do beneficio de acordo com a medida escolhida." type="number" minlength="0" min="0" required>
                                                    <div class="feedback-qtd-por-medida"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="qtdMaxima" class="mb-1 required">Quantidade máxima</label>
                                                <input type="number" name="qtdMaxima" id="qtdMaxima" class="form-control" title="Informe a quantidade maxima do beneficio que pode ser armazenada no estoque" min="0" minlength="0" required>
                                                <div class="feedback-qtd-max"></div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="qtdMinima" class="mb-1 required">Quantidade mínima</label> 
                                                <input type="number" name="qtdMinima" id="qtdMinima" class="form-control" title="Informe a quantidade minima do beneficio que pode haver no estoque" min="0" minlength="0" required> 
                                                <div class="feedback-qtd-min"></div>          
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
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="alert alert-dark mb-0" role="alert">Benefícios a serem cadastrados no sistema!</div>
                            </div><!-- card header-->
                            <div class="card-body">
                                <table id="dataTablesBeneficio" class="row-border cell-border hover" >
                                    <thead>
                                        <tr>
                                            <th>Descrição</th>
                                            <th>Nome</th>
                                            <th>Categoria</th>
                                            <th>Forma de Aquisição</th>
                                            <th>Quantidade Total</th>
                                            <th>Unidade de Medida</th>
                                            <th>Quantidade por medida</th>
                                            <th>Quantidade mínima</th>
                                            <th>Quantidade máxima</th>
                                            <th>Nome Fornecedor/Doador</th>
                                            <th>CNPJ ou CPF fornecedor/doador</th>
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
