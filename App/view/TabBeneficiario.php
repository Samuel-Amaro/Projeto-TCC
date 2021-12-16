<?php 
require_once("../dao/DaoBeneficiario.php");
$dao = new DaoBeneficiario(new DataBase());
$resultado = $dao->selectCountBeneficiarios();
if(is_array($resultado)) {
    $valor = $resultado[0];
?>
    <div class="row m-lg-3">
        <div class="col-xl-3 col-sm-6 col-12 linkcard mb-2">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="align-self-center col-3">
                                <i class="fas fa-users fs-1"></i>
                            </div>
                            <div class="col-9 text-end">
                                <h3>
                                    <span class="text-dark"><?=$valor["qtd"];?></span>        
                                </h3>
                                <span>Beneficíarios</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div> 
<?php 
}    
?>