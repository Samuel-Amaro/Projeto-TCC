<!--modal info tipo beneficio-->
<div class="modal fade" id="modalInfoTipoBeneficio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tipo Benefício</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div>
                        <b>Tipo benefício:</b>
                        <span class="nome-tipo"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Unidade medida:</b>
                        <span class="um"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Categoria:</b>
                        <span class="cat"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Data hora entrada:</b>
                        <span class="data-hora"></span>
                        <hr style="margin: 4px;">                
                    </div>
                </div>    
            </div><!--Modal body-->    
            <div class="modal-footer">
                <!--data-dismiss="modal"-->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Clique aqui para fechar o modal de informação do tipo de benefício">Fechar</button>
            </div>
        </div>
    </div>
</div><!--modal infor tipo beneficio-->

<!-- modal de alterar tipo de beneficio -->
<div class="modal fade" id="modalAlterarTipoBeneficio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alteração tipo benefício</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid px-4">
                    <div class="card mb-1 border-0">
                        <div class="card-body">
                            <div class="alert alert-warning mb-0 text-lg-center" role="alert">Campos com * são de preenchimento obrigatório!</div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="text-center font-weight-light my-2">Alteração dos dados</h4>
                        </div>
                        <div class="card-body">
                            <form action="" accept-charset="utf8" enctype="application/x-www-form-urlencoded" autocomplete="on" method="POST" target="_self" rel="next" name="form-alterar-tipo-beneficio" class="form-alterar-tipo-beneficio" title="Se achar necessário altere as informações contidas neste formulário, de acordo com sua necessidade.">
                                <input type="hidden" name="id_tipo_beneficio" id="id_tipo_beneficio" value="" required>
                                <div class="row mb-1">
                                    <div class="col-md-12">
                                        <div class="mb-3 mb-md-0">
                                            <label for="tipoBeneficio" class="mb-1 required">Tipo benefício</label>
                                            <input type="text" name="tipoBeneficio" id="tipoBeneficioModal" title="Entre com um novo nome se desejar para o tipo de benefício" class="form-control" required maxlength="150">
                                            <div class="feedback-tipo-beneficio"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1">    
                                    <div class="col-md-6">
                                        <div class="mb-3 mb-md-0">
                                            <label for="um" class="mb-1 required">Unidade medida</label>
                                            <select name="um" id="umModal" required class="form-select" title="Selecione ou troque de unidade de medida">
                                                <option value="SELECIONE" selected>Selecione</option>
                                                <?php 
                                                    $unidadesMedidasModal =  new DaoUnidadesMedidas(new DataBase());
                                                    $unidadesResult = $unidadesMedidasModal->select();
                                                    if(is_array($unidadesResult)) {
                                                        foreach($unidadesResult as $chave => $valor) {
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
                                            <div class="feedback-um"></div>
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="mb-3 mb-md-0">
                                            <label for="categoria" class="mb-1 required">Categoria</label>
                                            <select name="categoria" id="categoria" required title="Selecione uma nova categoria" class="form-select">
                                                <option value="SELECIONE" selected>Selecione</option>
                                                <?php
                                                    $categoriasModal = new DaoCategoriaBeneficios(new DataBase());
                                                    $catResult = $categoriasModal->selectAll();
                                                    if(is_array($catResult)) {
                                                        foreach($catResult as $chave => $valor) {
                                                ?>
                                                            <option value="<?= $valor["id_categoria"];?>"><?= $valor["nome"];?></option>
                                                            <?php    
                                                        }
                                                    }else{
                                                ?>
                                                        <option value="nenhuma categoria disponivel"><?= $catResult;?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                            <div class="feedback-cat"></div>
                                        </div>
                                    </div>                
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid gap-2 col-6 mx-auto">
                                        <input type="submit" value="Salvar Alteração" class="btn-update-tipo-beneficio btn btn-primary" title="Clique aqui para alterar o tipo do benefício">
                                    </div>
                                </div>
                            </form>
                        </div><!-- card body -->
                    </div><!-- card -->    
                </div><!-- container fluid-->    
            </div><!--Modal body-->    
            <div class="modal-footer">
                <!--data-dismiss="modal"-->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Clique aqui para fechar a modal de alteração de tipo de benefício">Fechar</button>
            </div>
        </div>
    </div>
</div>