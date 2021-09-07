<?php

require_once("../model/ModelUsuario.php");

//verifica qual o tipo de metodo e operação a se fazer
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $operacao = $_POST["operacao"];
    $ctr = new ControllerUsuario($operacao, "POST");
}


class ControllerUsuario{

    private string $operacao;
    private ModelUsuario $mdUser;
    private string $methodHttp;

    public function __construct(string $operacao, string $methodHttp) {
        $this->methodHttp = $methodHttp;
        $this->operacao = $operacao;
        switch($this->operacao) {
            case "login": 
                $this->login($this->methodHttp);
                break;
            case "cadastro":
                $this->cadastro($this->methodHttp);
                break;
            default:
                break;
        }
    }

    public function login($methodHttp) {
        if($methodHttp === "POST") {
           $cpfUsuario = $_POST["cpf"];
           $senhaUsuario = $_POST["senha"]; 
           $this->mdUser = new ModelUsuario(0, $cpfUsuario, "", "", "", "", $senhaUsuario, "");
           if($this->mdUser->buscarUsuario()) {
            $usuario = ['cpf' => $cpfUsuario, 'senha' => $senhaUsuario, 'computedString' => 'Ola, ' . $this->mdUser->getNomeUsuario()];  
             if(json_encode($usuario) != '') {
                //Retorna a representação JSON de um valor
                echo json_encode($usuario);
             }else{
                //echo "Usuario correto, Login efetuado, mas não codificou em json! </br>";
                $erroStrJson = ['erro' => 'usuario correto, Login efetuado, json não codificado!', 'error' => true];
                echo json_encode($erroStrJson);
             }   
           }else{
               $erroStrJson = ['erro' => 'usuario incorreto, se cadastre no sistema!', 'error' => true];
               echo json_encode($erroStrJson);
               //echo "Usuario incorreto, erro em algum lugar ou Usuario não esta cadastrado! </br>";
           }
        }else{
            $erroStrJson = ['erro' => 'ControllerUsuario não captou a request!', 'error' => true];
            echo json_encode($erroStrJson);
            //echo "Não consegui captar requisição! </br>";
        }
    }

    public function cadastro($methodHttp) {
        if($methodHttp === "POST") {
           $cpf = "001.432.123-00";  
           $tel = "61990123254";
           $email = "user@uol.com";
           $cargo = "colaborador";   
           $tipo_usuario = "comun";
           $senha = "123";
           $nome = "Dev Teste";
        }else{

        }
    }

    
}

?>