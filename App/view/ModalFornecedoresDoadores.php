<!-- modal de informação fornecedor doador -->
<div class="modal fade" id="modalInfoFornecedorDoador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Fornecedores e Doadores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div>
                        <b>Nome:</b>
                        <span class="nome"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Identificação:</b>
                        <span class="identificacao"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Tipo pessoa:</b>
                        <span class="tipo-pessoa"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Descrição:</b>
                        <span class="descricao"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Data Hora inserção no sistema:</b>
                        <span class="data-hora"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Email:</b>
                        <span class="email"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>CNPJ:</b>
                        <span class="cnpj"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>CPF:</b>
                        <span class="cpf"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Telefone celular:</b>
                        <span class="fone-celular"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Telefone fixo:</b>
                        <span class="fone-fixo"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Endereço:</b>
                        <span class="endereco"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>CEP:</b>
                        <span class="cep"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Cidade:</b>
                        <span class="cidade"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Bairro:</b>
                        <span class="bairro"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Complemento:</b>
                        <span class="complemento"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>UF:</b>
                        <span class="uf"></span>
                        <hr style="margin: 4px;">
                    </div>
                </div>    
            </div><!--Modal body-->    
            <div class="modal-footer">
                <!--data-dismiss="modal"-->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Clique aqui para fechar a modal de alteração de categoria">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- modal de alterar fornecedor doador -->
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
                            <div class="alert alert-warning mb-0" role="alert">Campos com * são de preenchimento obrigatório!</div>
                        </div>
                        <div class="card-body">
                            <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="formulario-alterar-fornecedores-doadores" class="form-fornecedor-doador-alterar" title="Se achar necessário altere as informações contidas neste formulário, de acordo com sua necessidade.">
                                <input type="hidden" name="operacao" value="alterar" id="operacao">
                                <input type="hidden" name="id_usuario" value="<?= $arrayUserDesserializado->getIdUsuario() ?>" id="id_usuario">
                                <input type="hidden" name="id_fornecedor_doador" value="" id="id_forn_doado">
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
                                        <input type="submit" value="Salvar Alteração" class=" btn-cadastrar-fornecedor-doacoes btn btn-primary" title="Clique aqui para alterar o fornecedor ou doador">
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