<?php 
require_once("../dao/DaoEntregaBeneficios.php");
$daoEntrega = new DaoEntregaBeneficios(new DataBase());
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
                                #lista a quantidade de entregas ja realizadas
                                $resul = $daoEntrega->select("SELECT COUNT(id_entrega_beneficio) AS total_entregas FROM entregas_beneficios;");
                                if(is_array($resul)) {
                                    $valor = $resul[0];
                            ?>
                                    <span class="text-dark"><?= $valor["total_entregas"]; ?></span>       
                            <?php
                                }else{
                            ?>
                                    <span class="text-dark">0</span>
                            <?php
                                }
                            ?>  
                            </h3>
                            <span>Entregas realizadas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
# lista quantidade de beneficios entregues
$daoEntrega = new DaoEntregaBeneficios(new DataBase());
$result2 = $daoEntrega->select("SELECT SUM(quantidade_entregue) AS qtd_total_entregue
FROM entregas_beneficios;");
?>
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
                                if(is_array($result2)) {
                                    $valor2 = $result2[0];
                            ?>
                                <span class="text-dark"><?= $valor2["qtd_total_entregue"]; ?></span>   
                            <?php 
                                }else{
                            ?>
                                    <span class="text-dark">0</span> 
                            <?php 
                                }
                            ?>
                            </h3>
                            <span>Total ja entregue</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 