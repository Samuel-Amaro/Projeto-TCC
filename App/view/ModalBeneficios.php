<!--modal info beneficios-->
<div class="modal fade" id="modalInfoBeneficios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Benefício</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div>
                        <b>Nome:</b>
                        <span class="nome-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Forma aquisição:</b>
                        <span class="forma-aqu-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Quantidade mínima:</b>
                        <span class="qtd-minima-beneficio"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Quantidade máxima:</b>
                        <span class="qtd-maxima-beneficio"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Quantidade atual estoque:</b>
                        <span class="saldo-beneficio"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Data Hora inserção no sistema:</b>
                        <span class="data-hora-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Descrição:</b>
                        <span class="descricao-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Categoria:</b>
                        <span class="categoria-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Nome Fornecedor/Doador:</b>
                        <span class="nome-fornecedor-doador-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>CNPJ/CPF:</b>
                        <span class="cpf-cnpj-fornecedor-doador-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Identificação fornecedor/Doador:</b>
                        <span class="identificacao-fornecedor-doador"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Tipo pessoa fornecedor/doador:</b>
                        <span class="tipo-pessoa-fornecedor-doador"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Email fornecedor/doador:</b>
                        <span class="email-fornecedor-doador"></span>
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
</div><!--Info estoque-->

<!-- modal de timeline que mostra as movimentações de um beneficio -->
<!--modal info timeline-->
<div class="modal fade" id="modalTimelineMovimentacoes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Movimentações benefício</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--<div>-->
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <h5 class="titulo-beneficio"></h5>
                            <ul class="timeline"></ul>
                        </div>
	                </div>
                <!--</div>-->    
            </div><!--Modal body-->    
            <div class="modal-footer">
                <!--data-dismiss="modal"-->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Clique aqui para fechar a modal de alteração de categoria">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal de alterar beneficio -->
<div class="modal fade" id="modalAlterarBeneficio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alteração Benefício</h5>
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
                            <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="alterar-beneficio" class="alterar beneficio" title="Se achar necessário altere as informações contidas neste formulário, de acordo com sua necessidade.">
                                <input type="hidden" name="operacao" value="" id="operacao">
                                <input type="hidden" name="id_beneficio" value="" id="id_beneficio">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="alert alert-info mb-0" role="alert">Se deseja modificar a capacidade do estoque para o benefício</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3 mb-md-0">
                                            <label for="qtdMinima" class="mb-1 required">Quantidade mínima</label>
                                            <input type="number" name="qtdMinima" id="qtdMinima" title="Quantidade mínima do benefício em estoque" class="form-control">
                                            <div class="feedback-qtd-minima"></div>
                                        </div>
                                    </div>    
                                    <div class="col-md-6">
                                        <div class="mb-3 mb-md-0">
                                            <label for="qtdMaxima" class="mb-1 required">Quantidade maxima</label>
                                            <input type="number" name="qtdMaxima" id="qtdMaxima" title="Quantidade máxima do benefício no estoque" class="form-control">
                                            <div class="feedback-qtd-maxima"></div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="alert alert-info mb-0" role="alert">Se haver necessidade de realizar uma movimentação no estoque sem distribuição do benefício realize por aqui</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3 mb-md-0">
                                            <label for="tipoMovimentacao" class="mb-1 required">Movimentação</label>
                                            <select name="tipoMovimentacao" id="tipoMovimentacao" title="Escolha o tipo da movimentação a ser efetuada" class="form-select">
                                                <option value="SELECIONE">Selecione</option>
                                                <option value="0">Saida</option>
                                                <option value="1">Entrada</option>
                                            </select>
                                            <div class="feedback-tipo-movimentacao"></div>
                                        </div>   
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 mb-md-0">
                                            <label for="quantidade" class="required">Quantidade</label>
                                            <input type="number" name="quantidade" id="quantidade" title="Informe a quantidade para ser movimentada" class="form-control">
                                            <div class="feedback-quantidade"></div>
                                        </div>   
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3 mb-md-0">
                                            <label for="um" class="mb-1 required">Unidade medida</label>
                                            <select name="um" id="um" title="Escolha a unidade de medida correta" class="form-select">
                                                <option value="SELECIONE">Selecione</option>
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
                                            <div class="feedback-um-medida"></div>
                                        </div>   
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 mb-md-0">
                                            <label for="qtdPorMedida" class="required">Quantidade por medida</label>
                                            <input type="number" name="qtdMedida" id="qtdMedida" title="Informe a quantidade de acordo com a unidade de medida" class="form-control">
                                            <div class="feedback-qtdMedida"></div>
                                        </div>   
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="mb-3 mb-md-0">
                                            <label for="descricao" class="mb-1 required">Descrição</label>
                                            <textarea class="form-control descricao" placeholder="Informe aqui uma descrição objetiva, descrevendo o motivo pela qual a movimentação sera efetuada" title="Informe aqui uma descrição, que seja bem objetiva e suscinta e importante relacionada ao motivo da movimentação do beneficio" id="floatingTextarea" name="descricao" id="descricao"></textarea>
                                            <div class="feedback-descricao"></div>
                                        </div>   
                                    </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid gap-2 col-6 mx-auto">
                                        <input type="submit" value="Salvar Alteração" class="btn-update-beneficio btn btn-primary" title="Clique aqui para alterar o benefício">
                                    </div>
                                </div>
                            </form>
                        </div><!-- card body -->
                    </div><!-- card -->    
                </div><!-- container fluid-->    
            </div><!--Modal body-->    
            <div class="modal-footer">
                <!--data-dismiss="modal"-->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Clique aqui para fechar a modal de alteração de beneficiario">Fechar</button>
            </div>
        </div>
    </div>
</div>