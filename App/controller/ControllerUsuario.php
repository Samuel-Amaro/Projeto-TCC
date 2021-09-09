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
           //usuario existe
           if($this->mdUser->buscarUsuario()) {
                $usuario = ['cpf' => $cpfUsuario, 'senha' => $senhaUsuario, 'computedString' => 'Ola, ' . $this->mdUser->getNomeUsuario(), 'location' => 'PainelControle.php'];  
                //pode logar usuario na sessão 
                if(json_encode($usuario) != '') {
                    //abre a sessão
                    if(session_start()){
                        //caso o objeto do usuario não esteja salvo na seção
                        if(!isset($_SESSION["usuario_logado"])) {
                            //passa objeto model para session serializado e depois quando for usar desserializar ele
                            //add essa informação do usuario na seção atual
                            //não pode serializar objet pdo
                            $_SESSION["usuario_logado"] = serialize($this->mdUser);
                            //Retorna a representação JSON de um valor como um response
                            //echo serialize($this->mdUser);
                            echo json_encode($usuario);
                            exit;
                        }else if(json_encode($usuario) != ''){
                            //echo $this->mdUser->getEmailUsuario();
                            //se o objeto ja tiver salvo
                            //echo serialize($this->mdUser);
                            echo json_encode($usuario);
                        }   
                    }else if(json_encode($usuario) != '') {
                        //seção não abriu houve algum erro
                        echo "Erro ao abrir seção! </br>";
                    }       
                }
           }else{
               //usuario não existe ou dados incorretos
               $erroStrJson = ['erro' => 'usuario incorreto, preencha os campos corretamente!', 'error' => true];
               echo json_encode($erroStrJson);
           }
        }else{
            $erroStrJson = ['erro' => 'ControllerUsuario não captou a request!', 'error' => true];
            echo json_encode($erroStrJson);
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