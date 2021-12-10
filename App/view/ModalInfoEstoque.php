<!-- modal info estoque -->
<div class="modal fade" id="modalInfoEstoque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Benefício movimentado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div>
                        <b>Nome tipo:</b>
                        <span class="nome-tipo-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Unidade medida:</b>
                        <span class="um"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Categoria:</b>
                        <span class="categoria"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Saldo atual:</b>
                        <span class="saldo-atual"></span>
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


<!-- modal de add movimentacao sem associar a uma entrega beneficio -->
<div class="modal fade" id="modalAddMovimentacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Movimentar estoque benefício</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid px-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="text-center font-weight-light my-2">Adicionar movimentação</h4>
                        </div>
                        <div class="card-body">
                            <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="alterar-beneficio" class="form-add-movimentacao" title="Este formulário e para adicionar uma nova movimentação no benefício">
                                <input type="hidden" name="operacao" value="" id="operacao">
                                <input type="hidden" name="id_tipo_beneficio" value="" id="id_tipo_beneficio">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="alert alert-warning mb-1" role="alert">Campos com * são de preenchimento obrigatório!</div>
                                        <div class="alert alert-info mb-0" role="alert">Se haver necessidade de realizar uma movimentação no estoque sem distribuição do benefício realize por aqui</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3 mb-md-0">
                                            <label for="tipoMovimentacao" class="mb-1 required">Movimentação</label>
                                            <select name="tipoMovimentacao" id="tipoMovimentacao" title="Escolha o tipo da movimentação a ser efetuada" class="form-select" required>
                                                <option value="SELECIONE">Selecione</option>
                                                <option value="0">Saida</option>
                                                <option value="1">Entrada</option>
                                            </select>
                                            <div class="feedback-tipo-movimentacao"></div>
                                        </div>   
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 mb-md-0">
                                            <label for="quantidade" class="required mb-1">Quantidade</label>
                                            <input type="number" name="quantidade" id="quantidade" title="Informe a quantidade para ser movimentada" class="form-control" required>
                                            <div class="feedback-quantidade"></div>
                                        </div>   
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="mb-3 mb-md-0">
                                            <label for="descricao" class="mb-1 required">Descrição</label>
                                            <textarea class="form-control descricao" placeholder="Informe aqui uma descrição objetiva, descrevendo o motivo pela qual a movimentação sera efetuada" title="Informe aqui uma descrição, que seja bem objetiva e suscinta e importante relacionada ao motivo da movimentação do beneficio" name="descricao" id="descricao" maxlength="300"></textarea>
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