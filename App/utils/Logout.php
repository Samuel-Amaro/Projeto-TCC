<?php

if(session_start()) {
    //se o objeto do usuario não existe na seção
    if(!isset($_SESSION["usuario_logado"])) {
        //manda um redirecionamento para login
        header("Location: ../../index.php");
        exit;
    }else{
       if(session_destroy()) {
            header("Location: ../../index.php");
            exit;
       }else{
            header("Location: ../../index.php");
            exit;
       }
    }
}


?>