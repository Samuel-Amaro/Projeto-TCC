<?php
require_once("../model/ModelUsuario.php");
if(session_start()) {
    if(!isset($_SESSION["usuario_logado"])) {
        header("Location: ../../index.php");
        exit;
    }else{
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
        <meta name="description" content="Pagina de listagem de fornecedores e doadores de beneficios"/>
        <meta name="author" content="Samuel Amaro"/>
        <title>Listar Fornecedores/Doações</title>
        <!-- BOOSTRAP -->
        <link href="../../Public/css/styles.css" rel="stylesheet"/>
        <!-- ESTILO DA TABELA DO PLUGIN DATATABLES -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <!-- RESPONSIVO DO DATATABLES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        <!--EXTENSÃO DE BOTÕES PARA DATATABLES ESTILO DOS BOTÕES-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
        <!-- ICONES -->
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
                        <h1 class="mt-4">Fornecedores/Doadores</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">
                                <a href="PainelControle.php">Painel controle</a>
                            </li>
                            <li class="breadcrumb-item active">Listagem</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">Listagem de fornecedores/doadores</div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="text-center font-weight-light my-4">Fornecedores e Doadores</h4>
                            </div>
                            <div class="card-body">
                                <table id="dataTablesFornecedoresDoadores" class="row-border cell-border hover compact" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <!--<th>Descrição</th>-->
                                            <th>Identificação</th>
                                            <th>Tipo</th>
                                            <th>CPF</th>
                                            <th>CNPJ</th>
                                            <!--<th>CEP</th>-->
                                            <th>Opções</th>
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
                 # rodape
                 include("Rodape.php")
                ?>
            </div><!--layoutSidenav_nav-->
        </div><!--layoutSidenav-->
        <div class="modal fade" id="modalFornecedorDoador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-bs-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alteração Fornecedor ou Doador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid px-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4 class="text-center font-weight-light my-4">Alteração dos dados</h4>
                                </div>
                                <div class="card-body">
                                    <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="formulario-cadastro-fornecedores" class="form-fornecedor">
                                        <input type="hidden" name="operacao" value="cadastrar" id="operacao">
                                        <input type="hidden" name="id_usuario" value="<?= $arrayUserDesserializado->getIdUsuario() ?>" id="id_usuario">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div>
                                                    <div class="mb-3 mb-md-0">
                                                        <label for="floatingTextarea" class="mb-1 required">Nome</label>
                                                        <input class="form-control nome-fornecedor-doador" placeholder="Informe aqui, o nome do fornecedor ou doador do beneficio." title="Entre com um nome para identificar o fornecedor ou doador do beneficio" id="nome-fornecedor-doador" name="nome-fornecedor-doador" type="text" required maxlength="70" minlength="1"/>
                                                        <div class="feedback-nome"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                    <div class="mb-3 mb-md-0">
                                                        <label for="floatingTextarea" class="mb-1 opcional">Descrição</label>
                                                        <textarea class="form-control descricao-fornecedor-doador" placeholder="Informe aqui uma descrição que ajude a indentificar este fornecedor ou doador." title="Entre com uma descrição que ajude a indentificar e descrever este fornecedor ou doador da melhor forma" id="descricao" name="descricao-fornecedor-doador" maxlength="300"></textarea>
                                                        <div class="feedback-descricao"></div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="mb-3 mb-md-0">
                                                    <label for="tipoIdentificacao" class="mb-1 required">Escolha a indentificação apropriada</label>
                                                    <select name="tipoIdentificacao" id="tipoIdentificacao" class="form-select required" title="Escolha o tipo de idenficação correta." required>
                                                        <option value="SELECIONE">SELECIONE</option>
                                                        <option value="DOADOR">Doador</option>
                                                        <option value="FORNECEDOR">Fornecedor</option>
                                                    </select>
                                                    <div class="valid-feedback invalid-feedback-descricao"></div>
                                                </div>
                                            </div>    
                                            <div class="col-md-6">
                                                <div class="mb-3 mb-md-0">
                                                    <label for="tipoPessoa" class="mb-1 required">Escolha o tipo de Pessoa</label>
                                                    <select name="tipoPessoa" id="tipoPessoa" class="form-select" title="Escolha o tipo de pessoa correta, para ser associado a identificação escolhida." required>
                                                        <option value="SELECIONE">SELECIONE</option>
                                                        <option value="FISICA">Pessoa Física</option>
                                                        <option value="JURIDICA">Pessoa Jurídica</option>
                                                    </select>
                                                    <div class="valid-feedback invalid-feedback-tipo-pessoa"></div>
                                                </div>
                                            </div> 
                                        </div>
                                        <!-- estão como opcionanais mas não são fazer validação por javascript, são obrigatorios -->
                                        <div class="row mb-3 container-cpf" style="display: none;">
                                            <div class="col-md-6">
                                                <div class="mb-3 mb-md-0">
                                                    <label for="cpf" class="mb-1 required">CPF</label>
                                                    <input type="text" class="form-control" title="Informe o cpf da pessoa física." placeholder="Entre com o cpf, somente numeros." id="cpf" minlength="14" maxlength="14">
                                                    <div class="invalid-feedback invalid-feedback-cpf"></div>
                                                </div>   
                                            </div>
                                        </div>
                                        <div class="row mb-3 container-cnpj" style="display: none;">
                                            <div class="col-md-6">
                                                <div class="mb-3 mb-md-0">
                                                    <label for="cnpj" class="mb-1 required">CNPJ</label>
                                                    <input type="text" class="form-control" title="Informe o cnpj da pessoa jurídica" placeholder="Entre com o cnpj, somente numeros." id="cnpj" minlength="18" maxlength="18">
                                                    <div class="invalid-feedback invalid-feedback-cnpj"></div>
                                                </div>   
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="">
                                                    <label for="inputCep" class="mb-1 opcional">Cep</label>
                                                    <input class="form-control" id="inputCep" type="text" placeholder="Entre com seu Cep" maxlength="9" size="10" name="cep" title="Informe um CEP valido para ser realizada a busca"/>
                                                    <div class="invalid-feedback invalid-feedback-cep"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="">
                                                    <label for="btn" class="mb-1 opcional">Clique aqui para consultar cep</label>
                                                    <input type="button" value="Consultar Cep" class="btn btn-primary align-middle btn-busca-cep form-control" title="Clique aqui para buscar o CEP">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="endereco" class="mb-1 required">Endereco</label>
                                                <input class="form-control mb-3" type="text" placeholder="Entre com o logradouro" id="inputEndereco" title="Preencha este campo com o endereço do doador ou do fornecedor" name="endereco" required minlength="1" maxlength="70"/>
                                                <div class="feedback-endereco"></div>
                                            </div>  
                                            <div class="col-md-12">
                                                <label for="complemento" class="mb-1 required">Complemento</label>
                                                <input type="text" class="form-control" placeholder="Entre com o complemento do endereço." id="inputComplemento" title="Preencha este campo com o complemento do endereço." name="complemento" minlength="1" maxlength="30">
                                                <div class="feedback-complemento"></div>
                                            </div>    
                                        </div>
                                        <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <div class="mb-3 mb-md-0">
                                                        <label for="bairro" class="mb-1 required">Bairro</label>
                                                        <input class="form-control" id="inputBairro" type="text" placeholder="Entre com o bairro." title="Preencha este campo com o bairro" name="bairro" required minlength="1" maxlength="50"/>
                                                        <div class="feedback-bairro"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3 mb-md-0">
                                                        <label for="cidade" class="mb-1 required">Cidade</label>
                                                        <input type="text" name="cidade" class="form-control" id="inputCidade" placeholder="Entre com a cidade." title="Informe a cidade." id="inputCidade" required minlength="1" maxlength="150">
                                                        <div class="feedback-cidade"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3 mb-md-0">
                                                        <label for="estado" class="mb-1 required">Escolha Estado</label>
                                                        <select id="inputEstado" class="form-select" title="Selecione o estado." name="estado" required>
                                                            <option value="SELECIONE">SELECIONE</option>
                                                            <option value="AC">AC</option>
                                                            <option value="AL">AL</option>
                                                            <option value="DF">DF</option>
                                                            <option value="GO">GO</option>
                                                            <option value="AP">AP</option>
                                                            <option value="AM">AM</option>
                                                            <option value="BA">BA</option>
                                                            <option value="CE">CE</option>
                                                            <option value="ES">ES</option>
                                                            <option value="MA">MA</option>
                                                            <option value="MT">MT</option>
                                                            <option value="MS">MS</option>
                                                            <option value="MG">MG</option>
                                                            <option value="PB">PB</option>
                                                            <option value="PR">PR</option>
                                                            <option value="PE">PE</option>
                                                            <option value="PI">PI</option>
                                                            <option value="RJ">RJ</option>
                                                            <option value="NR">RN</option>
                                                            <option value="RS">RS</option>
                                                            <option value="RO">RO</option>
                                                            <option value="RR">RR</option>
                                                            <option value="SC">SC</option>
                                                            <option value="SP">SP</option>
                                                            <option value="SE">SE</option>
                                                            <option value="TO">TO</option>
                                                        </select>
                                                        <div class="valid-feedback invalid-feedback-estado"></div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="telefone01" class="mb-1 required">Telefone Celular</label>
                                                <input type="text" name="telefone01" class="form-control" id="telefone01" placeholder="Entre com o telefone, informando somente numeros." title="Entre com o numero de telefone principal, informando somente numeros" required minlength="13" maxlength="13">
                                                <div class="feedback-celular"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="telefone02" class="mb-1 required">Telefone Fixo</label>
                                                <input type="text" name="telefone02" class="form-control" id="telefone02" placeholder="Entre com o telefone, informando somente numeros." title="Entre com o numero de telefone opcional, informando somente numeros." required minlength="12" maxlength="12">
                                                <div class="invalid-feedback invalid-feedback-fixo"></div>
                                            </div>   
                                            <div class="col-md-4">
                                                <label for="email" class="mb-1 required">Email</label>
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Informe um email, para entrar em contato." title="Informe um endereço eletrônico, como um email no formato email@example.com" maxlength="70" minlength="1" required>       
                                                <div class="feedback-email"></div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid gap-2 col-6 mx-auto">
                                                <input type="submit" value="Cadastrar" class=" btn-cadastrar-fornecedor-doacoes btn btn-primary" title="Clique aqui para cadastrar o fornecedor ou doador do beneficio.">
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- card body -->
                                <div class="card-footer">

                                </div>    
                            </div><!-- card -->    
                        </div><!-- container fluid-->    
                    </div><!--Modal body-->    
                    <div class="modal-footer">
                        <!--data-dismiss="modal"-->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Clique aqui para fechar a modal de alteração de beneficiario">Fechar</button>
                        <!--
                        <button type="button" class="btn btn-primary">Salvar Alteração</button>
                        -->
                        <!--
                        <input type="submit" value="Cadastrar" class="btn-alterar-beneficiario btn btn-primary" title="Clique aqui para salvar o beneficiário">
                        -->
                    </div>
                </div>
            </div>
        </div>
        <script>
            sessionStorage.setItem("id_usuario_logado", "<?php echo $arrayUserDesserializado->getIdUsuario(); ?>");
        </script>
        <!--BOOSTRAP-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <!-- MANIPULA JS BOOSTRAP-->
        <script src="../../Public/scripts/scripts.js"></script>
        <!-- plugin de alertas bonitos -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" type="text/javascript" charset="utf8"></script>
        <!-- script de deletar usuario -->
        <script src="../../Public/scripts/deletar-usuario.js" type="text/javascript" charset="utf8"></script>
        <!-- JQUERY -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- DATA TABLES-->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
        <!-- RESPONSIVO DATA TABLES -->
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js" type="text/javascript" charset="utf8"></script> 
        <!-- DATATABLES FORNECEDORES DOADORES -->
        <script src="../../Public//scripts/fornecedores_doacoes/Data-Tables-Fornecedores-Doadores.js" type="text/javascript" charset="utf8"></script>     
    </body>
</html>