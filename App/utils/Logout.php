<?php

if(session_start()) {
    //se o objeto do usuario não existe na seção
    if(!isset($_SESSION["usuario_logado"])) {
        //manda um redirecionamento para login
        header("Location: ../../index.php");
        exit;
    }else{
       if(session_destroy()) {
            unset($_SESSION["usuario_logado"]);
            unset($_SESSION["data_hora_login"]);
            header("Location: ../../index.php");
            exit;
       }else{
            //unset($_SESSION["usuario_logado"]);
            //unset($_SESSION["data_hora_login"]);
            header("Location: ../../index.php");
            exit;
       }
    }
}


?>