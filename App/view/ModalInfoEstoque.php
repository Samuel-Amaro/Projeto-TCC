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
                        <b>Nome:</b>
                        <span class="nome-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Tipo Movimentação:</b>
                        <span class="tipo-mov-estoque"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Quantidade mínima:</b>
                        <span class="qtd-minima-estoque"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Quantidade máxima:</b>
                        <span class="qtd-maxima-estoque"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Data Hora ultima movimentação:</b>
                        <span class="data-hora-estoque"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Unidade de medida:</b>
                        <span class="um-estoque"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Quantidade por medida:</b>
                        <span class="qtd-medida"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Quantidade movimentada:</b>
                        <span class="qtd-mov"></span>
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