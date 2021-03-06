<!--modal info beneficiario -->
<div class="modal fade" id="modalInfoBeneficiario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Benefíciario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div>
                        <b>Nome:</b>
                        <span class="nome-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Observação:</b>
                        <span class="obs-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Renda per capita:</b>
                        <span class="renda-beneficiario"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Quantidade de pessoas na residencia:</b>
                        <span class="qtd-pessoa-home-beneficiario"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Numero do nis:</b>
                        <span class="numero-nis-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>UF:</b>
                        <span class="uf-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Cidade:</b>
                        <span class="cidade-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Bairro:</b>
                        <span class="bairro-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Endereço:</b>
                        <span class="endereco-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Celular:</b>
                        <span class="celular-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Telefone:</b>
                        <span class="telefone-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>CPF:</b>
                        <span class="cpf-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>CEP:</b>
                        <span class="cep-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Complemento endereço:</b>
                        <span class="complemento-endereco-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Abrangencia cras:</b>
                        <span class="abrangencia-cras-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Email:</b>
                        <span class="email-beneficiario"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Data Hora:</b>
                        <span class="data-hora-beneficiario"></span>
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
<!-- modal alterar beneficiario-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alteração de beneficiário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-11">
                                <div class="card border-0 rounded-lg">
                                    <div class="card-body">
                                        <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="formulario-alteracao-beneficiario" class="form-alterar-beneficiario">
                                            <input type="hidden" name="operacao" value="" id="operacao">
                                            <input type="hidden" name="id_usuario" value="<?= $arrayUserDesserializado->getIdUsuario(); ?>" id="id_usuario">
                                            <input type="hidden" name="id_beneficiario" id="id_beneficiario" value="">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="inputNomePrimeiro" class="mb-1">Primeiro Nome</label>
                                                    <input class="form-control" id="inputNomePrimeiro" type="text" placeholder="Entre com seu primeiro nome" required maxlength="35" title="Preencha esta campo com o primeiro nome do beneficiario" name="primeiroNome"/>
                                                    <div class="valid-feedback mb-01 valid-feedback-primeiro-nome"></div>
                                                    <div class="feedback-verifica-nome-primeiro"></div>
                                                </div>    
                                                <div class="col-md-6">
                                                    <label for="inputNomeUltimo" class="mb-1">Ultimo Nome</label>
                                                    <input class="form-control" id="inputNomeUltimo" type="text" placeholder="Entre com seu ultimo nome" required maxlength="35" title="Preencha esta campo com o ultimo nome do beneficiario" name="ultimoNome"/>
                                                    <div class="valid-feedback mb-01 valid-feedback-ultimo-nome"></div>
                                                    <div class="feedback-verifica-nome-ultimo"></div>
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
                                                            <div class="invalid-feedback  valid-feedback-telefone-required"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="">
                                                            <label for="inputFoneOpcional" class="mb-1">Telefone Opcional</label>
                                                            <input class="form-control" id="inputFoneOpcional" type="text" placeholder="Entre com seu telefone, somente numeros" maxlength="15" title="Preencha este campo com o numero de telefone do beneficiário, informando somente números." name="telefoneOpcional"/>
                                                            <div class="invalid-feedback valid-feedback-telefone-opcional"></div>
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
                                                    <div class="invalid-feedback-endereco"></div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputComplemento" class="mb-1">Complemento</label>
                                                <input class="form-control" id="inputComplemento" type="text" placeholder="Entre com um complemento referente ao endereço" name="complemento" title="Informe o complemento de endereço do beneficiário" />
                                                <div class="invalid-feedback-complemento"></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <div class="mb-3 mb-md-0">
                                                        <label for="inputCidade" class="mb-1">Cidade</label>
                                                        <input class="form-control" id="inputCidade" type="text" placeholder="Entre com uma cidade" required name="cidade" title="Informe uma cidade onde o beneficiário reside"/>
                                                        <div class="invalid-feedback-cidade"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3 mb-md-0">
                                                        <label for="inputEstado" class="mb-1">Estado</label>
                                                        <select id="inputEstado" class="form-select" title="Selecione o estado onde o beneficiario reside" required name="estado">
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
                                                            <option value="RN">RN</option>
                                                            <option value="RS">RS</option>
                                                            <option value="RO">RO</option>
                                                            <option value="RR">RR</option>
                                                            <option value="SC">SC</option>
                                                            <option value="SP">SP</option>
                                                            <option value="SE">SE</option>
                                                            <option value="TO">TO</option>
                                                        </select>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="">
                                                        <label for="inputBairro" class="mb-1">Bairro</label>
                                                        <input class="form-control" id="inputBairro" type="text" placeholder="Entre com seu bairro" required name="bairro" title="Informe o bairro do beneficiário"/>
                                                        <div class="invalid-feedback-bairro"></div>
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
                                                        <input class="form-control" id="inputRenda" type="text" placeholder="Informe a renda por cabeça relacionada ao beneficiário" required data-prefix="R$ "  data-affixes-stay="false" data-decimal="," name="rendaPerCapita" title="Informe a renda percapita deste beneficiário" data-thousands="." />
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
                                                            <option value="cras1">Cras 1</option>
                                                            <option value="cras2">Cras 2</option>
                                                        </select>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid gap-2 col-6 mx-auto">
                                                    <input type="submit" value="Salvar Alteração" class=" btn-alterar-beneficiario btn btn-primary" title="Clique aqui para alterar o beneficiário">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Clique aqui para fechar a modal de alteração de beneficiario">Fechar</button>
                    <!--
                    <button type="button" class="btn btn-primary">Salvar Alteração</button>
                    -->
                    <!--
                    <input type="submit" value="Cadastrar" class="btn-alterar-beneficiario btn btn-primary" title="Clique aqui para salvar o beneficiário">
                    -->
                </div>
            </div>
    </div><!--MODAL CONTAINER-->
</div>