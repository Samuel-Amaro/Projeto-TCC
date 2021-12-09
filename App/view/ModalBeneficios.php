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
                        <b>Descrição benefício:</b>
                        <span class="descricao-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Quantidade inicial benefício:</b>
                        <span class="qtd-inicial-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Data hora cadastro:</b>
                        <span class="data-hora-beneficio"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Nome fornecedor/Doador</b>
                        <span class="nome-fornecedor-doador-beneficio"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Identificação  (fornecedor/doador):</b>
                        <span class="identificacao-forn-doad-beneficio"></span>
                        <hr style="margin: 4px;">                
                    </div>
                    <div>
                        <b>Tipo pessoa(fornecedor/doador):</b>
                        <span class="tipo-pessoa-forn-doador"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>CPF (fornecedor/doador):</b>
                        <span class="cpf-forn-doador"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>CNPJ (fornecedor/doador):</b>
                        <span class="cnpj-forn-doador"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Tipo aquisição:</b>
                        <span class="tipo-aquisica-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Tipo benefício:</b>
                        <span class="tipo-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Unidade medida:</b>
                        <span class="um-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Categoria benefício:</b>
                        <span class="categoria-beneficio"></span>
                        <hr style="margin: 4px;">
                    </div>
                    <div>
                        <b>Email (fornecedor/doador):</b>
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

