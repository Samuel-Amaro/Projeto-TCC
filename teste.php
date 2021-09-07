<?php

//echo phpinfo();

//require_once("utils/DataBase.php");
include("dao/DaoUsuario.php");

$db = new DataBase();

if(is_null($db->conexaoSGBD)) {
    echo "Não conectou banco </br>"; 
}else{
    $daoUser = new DaoUsuario($db);
    //if($object != null) {
        var_dump($daoUser);
        $resultado = $daoUser->insereUsuario( "111.111.111-11", "61999999999", "email@dominio.com", "colaborador", "adm", "12345678", "Usuario teste");
        if($resultado) {
            echo "Usuario inserido com sucesso! </br>";
        }else{
            echo "Erro ao inserir usuario! </br>";
        }
        /*
        if(fecharBanco($object)) {
            echo "Conexão fechada! </br>";
        }else{
            echo "Conexão não fechada! </br>";
        }*/
    //}else{
    //    echo "Conexão não deu certo! </br>";
   // }
}





?>