<?php 
require_once("../dao/DaoBeneficio.php");
$daoBeneficio = new DaoBeneficio(new DataBase());
?>
<div class="row m-lg-3">
    <div class="col-xl-3 col-sm-6 col-12 linkcard mb-2">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="align-self-center col-3">
                            <i class="fas fa-boxes fs-1"></i>
                        </div>
                        <div class="col-9 text-end">
                            <h3>
                            <?php
                                #lista a quantidade de beneficios
                                $resul = $daoBeneficio->selectCountBeneficios();
                                if(is_array($resul)) {
                                    $valor = $resul[0];
                            ?>
                                    <span class="text-dark"><?= $valor["qtd_beneficios"]; ?></span>       
                            <?php
                                }else{
                            ?>
                                    <span class="text-dark">0</span>
                            <?php
                                }
                            ?>  
                            </h3>
                            <span>Benefícios</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                  
