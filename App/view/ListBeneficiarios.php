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
        <link href="../../Public/css/styles.css" rel="stylesheet"/>
        <!-- ESTILO DA TABELA DO PLUGIN DATATABLES -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <!--EXTENSÃO DE BOTÕES PARA DATATABLES ESTILO DOS BOTÕES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
        <!-- estiliza botoões de alterar e exluir do datatables -->
        <link rel="stylesheet" href="../../Public/css/estilo_list_beneficiarios_buttons_table.css">
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
                        <h1 class="mt-4">Beneficiários</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="PainelControle.php">Painel controle</a></li>
                            <li class="breadcrumb-item active">Beneficiários</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">Beneficiários que possuem cadastro no nosso sistema.</div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Benefiários cadastrados
                            </div>
                            <div class="card-body">
                                <table id="dataTablesBeneficiarios" class="row-border cell-border hover">
                                    <thead>
                                        <tr>
                                            <!--<th>Id</th>-->
                                            <th>CPF</th>
                                            <th>Primeiro Nome</th>
                                            <th>Ultimo Nome</th>
                                            <th>Nis</th>
                                            <th>Celular</th>
                                            <!--<th>Celular</th>-->
                                            <!--<th>Endereço</th>-->
                                            <!--<th>Bairro</th>-->
                                            <th>Cidade</th>
                                            <th>UF</th>
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
                    <div class="row content-dinamico">

                    </div>
                </main>
            </div><!--layoutSidenav_nav-->
        </div><!--layoutSidenav-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-bs-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alteração de beneficiário</h5>
                    <!--data-dismiss="modal"-->
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-11">
                                    <div class="card border-0 rounded-lg">
                                        <div class="card-body">
                                            <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="formulario-cadastro-beneficiario" class="form-beneficiario">
                                                <input type="hidden" name="operacao" value="" id="operacao">
                                                <input type="hidden" name="id_usuario" value="<?= $arrayUserDesserializado->getIdUsuario() ?>" id="id_usuario">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="inputNomePrimeiro" class="mb-1">Primeiro Nome</label>
                                                        <input class="form-control" id="inputNomePrimeiro" type="text" placeholder="Entre com seu primeiro nome" required maxlength="35" title="Preencha esta campo com o primeiro nome do beneficiario" name="primeiroNome"/>
                                                        <div class="valid-feedback mb-01 valid-feedback-primeiro-nome"></div>
                                                        <div class="valid-feedback feedback-verifica-nome"></div>
                                                    </div>    
                                                    <div class="col-md-6">
                                                        <label for="inputNomeUltimo" class="mb-1">Ultimo Nome</label>
                                                        <input class="form-control" id="inputNomeUltimo" type="text" placeholder="Entre com seu ultimo nome" required maxlength="35" title="Preencha esta campo com o ultimo nome do beneficiario" name="ultimoNome"/>
                                                        <div class="valid-feedback valid-feedback-ultimo-nome"></div>
                                                    </div>    
                                                </div>
                                                <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <div class="mb-3 mb-md-0">
                                                                <label for="inputCpf" class="mb-1">CPF</label>
                                                                <input class="form-control" id="inputCpf" type="text" placeholder="Entre com seu cpf, somente numeros" required maxlength="15" title="Preencha este campo com o numero de cpf do beneficiário, informando somente numeros" name="cpf" readonly/>
                                                                <div class="valid-feedback valid-feedback-cpf"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="">
                                                                <label for="inputFone" class="mb-1">Telefone</label>
                                                                <input class="form-control" id="inputFone" type="text" placeholder="Entre com seu telefone, somente numeros" required maxlength="15" title="Preencha este campo com o numero de telefone do beneficiário, informando somente números." name="telefoneObrigatorio"/>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="">
                                                                <label for="inputFoneOpcional" class="mb-1">Telefone Opcional</label>
                                                                <input class="form-control" id="inputFoneOpcional" type="text" placeholder="Entre com seu telefone, somente numeros" maxlength="15" title="Preencha este campo com o numero de telefone do beneficiário, informando somente números." name="telefoneOpcional"/>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <div class="">
                                                            <label for="inputCep" class="mb-1">Cep</label>
                                                            <input class="form-control" id="inputCep" type="text" placeholder="Entre com seu Cep" maxlength="9" size="10" name="cep" title="Informe um CEP valido para ser realizada a busca"/>
                                                            <div class="invalid-feedback-cep"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="">
                                                            <label for="btn" class="mb-1">Clique aqui para consultar cep</label>
                                                            <input type="button" value="Consultar Cep" class="btn btn-primary align-middle btn-busca-cep form-control" title="Clique aqui para buscar o CEP">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <div>
                                                            <label for="inputEmail">Email Opcional</label>
                                                            <input type="email" class="form-control" id="inputEmailOpcional" placeholder="Entre com o email do beneficiario, se ele possuir" title="Informe um endereço eletrônico valido como nome@dominio.com" name="email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label for="inputEndereco" class="mb-1">Endereço - Logradouro</label>
                                                        <input class="form-control" id="inputEndereco" type="text" placeholder="Entre com seu endereço" required name="endereco" title="Informe um endereço"/>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="inputComplemento" class="mb-1">Complemento</label>
                                                    <input class="form-control" id="inputComplemento" type="text" placeholder="Entre com um complemento referente ao endereço" required name="complemento" title="Informe o complemento de endereço do beneficiário" />
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="mb-3 mb-md-0">
                                                            <label for="inputCidade" class="mb-1">Cidade</label>
                                                            <input class="form-control" id="inputCidade" type="text" placeholder="Entre com uma cidade" required name="cidade" title="Informe uma cidade onde o beneficiário reside"/>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3 mb-md-0">
                                                            <label for="inputEstado" class="mb-1">Estado</label>
                                                            <select id="inputEstado" class="form-select" title="Selecione o estado onde o beneficiario reside" required name="estado">
                                                                <option value="ac">AC</option>
                                                                <option value="al">AL</option>
                                                                <option value="df">DF</option>
                                                                <option value="go">GO</option>
                                                                <option value="ap">AP</option>
                                                                <option value="am">AM</option>
                                                                <option value="ba">BA</option>
                                                                <option value="ce">CE</option>
                                                                <option value="es">ES</option>
                                                                <option value="ma">MA</option>
                                                                <option value="mt">MT</option>
                                                                <option value="ms">MS</option>
                                                                <option value="mg">MG</option>
                                                                <option value="pb">PB</option>
                                                                <option value="pr">PR</option>
                                                                <option value="pe">PE</option>
                                                                <option value="pi">PI</option>
                                                                <option value="rj">RJ</option>
                                                                <option value="nr">RN</option>
                                                                <option value="rs">RS</option>
                                                                <option value="ro">RO</option>
                                                                <option value="rr">RR</option>
                                                                <option value="sc">SC</option>
                                                                <option value="sp">SP</option>
                                                                <option value="se">SE</option>
                                                                <option value="to">TO</option>
                                                            </select>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="">
                                                            <label for="inputBairro" class="mb-1">Bairro</label>
                                                            <input class="form-control" id="inputBairro" type="text" placeholder="Entre com seu bairro" required name="bairro" title="Informe o bairro do beneficiário"/>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="mb-3 mb-md-0">
                                                            <label for="inputNis" class="mb-1">Numero nis</label>
                                                            <input class="form-control" id="inputNis" type="text" placeholder="Entre com um número de nis valido, informando somente números." required maxlength="14" title="Preencha este campo com o número de nis do beneficiário" name="nis"/>
                                                            <div class="invalid-feedback-nis"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3 mb-md-0">
                                                            <label for="inputQtdPessoasHome" class="mb-1">N.º Pessoas Residencia</label>
                                                            <input class="form-control" id="inputQtdPessoasHome" type="number" placeholder="Entre com a quantidade de pessoas que residem na mesma residencia que o beneficiário" min="1" max="10" required name="qtdPessoasResidencia" title="Informe a quantidade de pessoas que residem na mesma residencia que o beneficiário"/>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3 mb-md-0">
                                                            <label for="inputRenda" class="mb-1">Renda por cabeça</label>
                                                            <input class="form-control" id="inputRenda" type="text" placeholder="Informe a renda por cabeça relacionada ao beneficiário" required data-prefix="R$ "  data-affixes-stay="false" data-decimal="." name="rendaPerCapita" title="Informe a renda percapita deste beneficiário"/>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        <div class="mb-3 mb-md-0">
                                                            <label for="floatingTextarea" class="mb-1">Observações importantes para compor cadastro</label>
                                                            <textarea class="form-control obs" placeholder="Descreva aqui alguma observação importante, relacionada a este beneficiário" title="Informe aqui alguma observação importante relacionada a este beneficiario" id="floatingTextarea" name="obs" id="obs"></textarea>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="">
                                                            <label for="inputTipoCras" class="mb-1">Abrangência crás</label>
                                                            <select id="inputTipoCras" class="form-select" required name="abrangencia" title="Selecione o crás que esta na abrangência de bairro">
                                                                <option value="cras1" selected>Cras 1</option>
                                                                <option value="cras2">Cras 2</option>
                                                            </select>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 mb-0">
                                                    <div class="d-grid gap-2 col-6 mx-auto">
                                                        <input type="submit" value="Cadastrar" class=" btn-cadastrar-beneficiario btn btn-primary" title="Clique aqui para cadastrar o beneficiário">
                                                        <!--
                                                        <a class="btn btn-primary btn-block" href="PainelControle.php" target="_self" rel="next" title="Clique aqui para voltar ao painel de controle">Voltar</a>
                                                        -->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!--
                                        <div class="card-footer text-center py-3">
                                            <div class="small"><a href="login.html">Have an account? Go to login</a></div>
                                        </div>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--data-dismiss="modal"-->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Salvar Alteração</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            sessionStorage.setItem("id_usuario_logado", "<?php echo $arrayUserDesserializado->getIdUsuario(); ?>");
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <!-- plugin de alertas bonitos -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript" charset="utf8"></script>
        <script src="../../Public/scripts/scripts.js"></script>
        <!-- script de deletar usuario -->
        <script src="../../Public/scripts/deletar-usuario.js"></script>
         <!--JQUERY VERSION 3.6.0-->
         <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
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
        <!--<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/b-2.0.1/r-2.2.9/datatables.min.js"></script>-->
        <!-- SCRIPT QUE MANIPULA O PLUGIN JS -->
        <script type="text/javascript" charset="utf8" src="../../Public/scripts/DataTablesListBeneficiarios.js"></script>        
    </body>
</html>
