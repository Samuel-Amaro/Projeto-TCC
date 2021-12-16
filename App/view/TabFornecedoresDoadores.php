<?php 
require_once("../dao/DaoFornecedoresDoadores.php");
$dao = new DaoFornecedoresDoadores(new DataBase());
# lista a quantidade de fornecedores e doadores
$resultado = $dao->selectCountFornDoad();
if(is_array($resultado)) {
?>
<div class="row m-lg-3">
<?php
    foreach($resultado as $chave => $valor) {
?>
    <div class="col-xl-3 col-sm-6 col-12 linkcard mb-2">
        <div class="card">
         <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="align-self-center col-3">
                        <i class="fas fa-user-alt fs-1"></i>
                    </div>
                    <div class="col-9 text-end">
                        <h3>
                            <span class="text-dark"><?= $valor["qtd"];?></span>  
                        </h3>
                        <span><?= $valor["identificacao"];?></span>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   
<?php
    }    
?>
</div>
<?php
}
?>
