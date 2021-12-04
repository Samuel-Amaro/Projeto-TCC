<!-- modal info tipo aquisição -->
<div class="modal fade" id="modalInfoTipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tipo aquisição</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div>
                        <b>Nome tipo:</b>
                        <span class="nome-tipo"></span>
                        <hr style="margin: 4px;">
                    </div>
                </div>    
            </div><!--Modal body-->    
            <div class="modal-footer">
                <!--data-dismiss="modal"-->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Clique aqui para fechar a modal de informação do tipo de aquisição">Fechar</button>
            </div>
        </div>
    </div>
</div><!--Info estoque-->

<!-- modal de alterar tipo aquisição -->
<div class="modal fade" id="modalAlterarTipoAquisicao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alteração Tipo Aquisição</h5>
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
                            <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="alterar-tipo" class="form-alterar-tipo" title="Se achar necessário altere as informações contidas neste formulário, de acordo com sua necessidade.">
                                <input type="hidden" name="id_tipo" value="" id="id_tipo">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="mb-3 mb-md-0">
                                            <label for="tipo" class="mb-1 required">Nome tipo</label>
                                            <input type="text" name="tipo" id="tipo" title="Altere o nome do tipo da aquisição" class="form-control" required maxlength="100">
                                            <div class="feedback-tipo"></div>
                                        </div>
                                    </div>     
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid gap-2 col-6 mx-auto">
                                        <input type="submit" value="Salvar Alteração" class="btn-update-tipo btn btn-primary" title="Clique aqui para alterar o benefício">
                                    </div>
                                </div>
                            </form>
                        </div><!-- card body -->
                    </div><!-- card -->    
                </div><!-- container fluid-->    
            </div><!--Modal body-->    
            <div class="modal-footer">
                <!--data-dismiss="modal"-->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Clique aqui para fechar a modal de alteração de tipo de aquisição">Fechar</button>
            </div>
        </div>
    </div>
</div>
