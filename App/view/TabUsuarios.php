<?php
require_once("../dao/DaoUsuario.php");
$daoUser = new DaoUsuario(new DataBase());
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
                                $resul = $daoUser->select("SELECT COUNT(id_usuario) AS total_usuarios 
                                FROM usuario;");
                                if(is_array($resul)) {
                                    $valor = $resul[0];
                            ?>
                                    <span class="text-dark"><?= $valor["total_usuarios"]; ?></span>       
                            <?php
                                }else{
                            ?>
                                    <span class="text-dark">0</span>
                            <?php
                                }
                            ?>  
                            </h3>
                            <span>Usuários ativos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$daoEntrega = new DaoEntregaBeneficios(new DataBase());
$result2 = $daoEntrega->select("SELECT COUNT(id_usuario) as qtd_usuario, tipo_usuario FROM usuario GROUP BY tipo_usuario;");    
if(is_array($result2)) {
   foreach($result2 as $chave => $valor2) {
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
                                <span class="text-dark"><?= $valor2["qtd_usuario"]; ?></span>       
                            </h3>
                            <span>Usuários tipo <?= $valor2["tipo_usuario"]; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
   }
}else{
    //fas nada 
}
?>
</div>