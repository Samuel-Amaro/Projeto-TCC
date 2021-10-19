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
        <meta name="description" content="Pagina de cadastro de beneficios e doações"/>
        <meta name="author" content="Samuel Amaro"/>
        <title>Cadastrar Beneficios</title>
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
                    <div class="row content-dinamico"></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-11">
                                <div class="card border-0 rounded-lg">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Cadastrar Beneficios</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="formulario-cadastro-beneficiario" class="form-beneficiario">
                                            <input type="hidden" name="operacao" value="cadastro" id="operacao">
                                            <input type="hidden" name="id_usuario" value="<?= $arrayUserDesserializado->getIdUsuario() ?>" id="id_usuario">
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <div>
                                                        <div class="mb-3 mb-md-0">
                                                            <label for="floatingTextarea" class="mb-1">Descrição Beneficio</label>
                                                            <textarea class="form-control descricao-beneficio" placeholder="Informe aqui, uma descrição sobre este novo beneficio." title="Entre com uma descrição que ajude a indentificar e descrever este beneficio da melhor forma" id="floatingTextarea" name="descricao-beneficio"></textarea>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="nomeBeneficio" class="mb-1">Nome</label>
                                                    <input class="form-control" id="nomeBeneficio" type="text" placeholder="Entre com o nome deste beneficio" title="Preencha esta campo com o nome do beneficio." name="nomeBeneficio"/>
                                                    <div class="valid-feedback"></div>
                                                </div>    
                                                <div class="col-md-6">
                                                    <label for="categoriaBeneficio" class="mb-1">Categoria</label>
                                                    <select id="categoriaBeneficio" class="form-select" title="Selecione a categoria em que o beneficio, se enquandra adequandamente." name="categoriaBeneficio">
                                                        <option value="saude">Saude</option>
                                                        <option value="higiene">Higiene</option>
                                                        <option value="alimenticia">Alimenticia</option>
                                                        <option value="vestimenta">Vestimenta</option>
                                                    </select>
                                                    <div class="valid-feedback"></div>
                                                </div>    
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="fornecedorDoador" class="mb-1">Fornecedores/Doadores</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="search" placeholder="Fornecedor/Doador" title="Preencha este campo com o nome do fornecedor ou da pessoa que vai fazer uma doação." name="fornecedorDoador"/>
                                                        <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                                                    </div>
                                                    <div class="valid-feedback"></div>
                                                </div>    
                                                <div class="col-md-6">
                                                    <label for="formaAquisicao" class="mb-1">Forma de Aquisição</label>
                                                    <select id="formaAquisicao" class="form-select" title="Informe como foi adquirido o beneficio" name="formaAquisicao">
                                                        <option value="licitacao">Licitação</option>
                                                        <option value="doacao">Doação</option>
                                                        <option value="compra">Compra</option>
                                                    </select>
                                                    <div class="valid-feedback"></div>
                                                </div>    
                                            </div>
                                            <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="mb-3 mb-md-0">
                                                            <label for="qtdTotal" class="mb-1">Quantidade Total</label>
                                                            <input class="form-control" id="qtdTotal" type="text" placeholder="Entre com a quantidade total." title="Preencha este campo com o quantidade total do beneficio" name="qtdTotal"/>
                                                            <div class="valid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3 mb-md-0">
                                                            <label for="unidadeMedida" class="mb-1">Unidade Medida</label>
                                                            <select name="unidadeMedida" id="unidadeMedida" class="form-select" placeholder="Escolha a unidade de medida para ser associada ao beneficio." title="Escolha a melhor unidade de medida que seja adequanda para quantificar e contalizar o beneficio.">
                                                                <option value="areaMetrosQuadrados">Área - Metro(m²)</option>
                                                                <option value="areaCentimetrosQuadrados">Área - Centímetro(cm²)</option>
                                                                <option value="comprimentoMetro">Comprimento - Metro(m)</option>
                                                                <option value="comprimentoCentimetro">Comprimento - Centímetro(cm)</option>
                                                                <option value="pesoKilograma">Peso - Quilograma(kg)</option>
                                                                <option value="pesoGrama">Peso - Grama(g)</option>
                                                                <option value="pesoSaca60">Peso - Saca 60kg(SC60)</option>
                                                                <option value="pesoMiligrama">Peso - Miligrama(mg)</option>
                                                                <option value="embalagemUnidade">Embalagem - Unidade(UN)</option>
                                                                <option value="embalagemCartela">Embalagem - Cartela(CT)</option>
                                                                <option value="embalagemCaixa">Embalagem - Caixa(CX)</option>
                                                                <option value="embalagemDuzia">Embalagem - Dúzia(DZ)</option>
                                                                <option value="emabalagemPar">Embalagem - Par(PA)</option>
                                                                <option value="embalagemPeca">Embalagem - Peça(PÇ)</option>
                                                                <option value="embalagemPacote">Embalagem - Pacote(PT)</option>
                                                                <option value="embalagemRolo">Embalagem - Rolo(RL)</option>
                                                                <option value="volumeLitro">Volume - Litro(L)</option>
                                                            </select>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3 mb-md-0">
                                                            <label for="qtdPorMedida" class="mb-1">Quantidade por medida</label>
                                                            <input name="qtdPorMedida" id="qtdPorMedida" class="form-control" placeholder="Informe a quantidade por medida" title="Informe a quantidade do beneficio de acordo com a medida escolhida." type="text">
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid gap-2 col-6 mx-auto">
                                                    <input type="submit" value="Cadastrar" class=" btn-cadastrar-beneficio btn btn-primary" title="Clique aqui para cadastrar o beneficio">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
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
    </body>
</html>
