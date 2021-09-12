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
                            //hora e data na ao entrar no sistema marcados na session
                            $_SESSION["usuario_logado"] = serialize($this->mdUser);
                            //Retorna a representação JSON de um valor como um response
                            echo json_encode($usuario);
                            exit;
                        }else if(json_encode($usuario) != ''){
                            //if(session_destroy()) {
                                $_SESSION["usuario_logado"] = serialize($this->mdUser);
                                //echo $this->mdUser->__toString();
                                //echo $this->mdUser->getEmailUsuario();
                                //se o objeto ja tiver salvo
                                //echo serialize($this->mdUser);
                                echo json_encode($usuario);
                           // }else{
                            //    print_r("Seção Não destruida!");
                           // }  
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
           $nomeUsuario = $_POST["nome"];
           $cpfUsuario = $_POST["cpf"];
           $telefoneUsuario = $_POST["telefone"];
           $emailUsuario = $_POST["email"];
           $cargoUsuario = $_POST["cargo"];
           $tipoUsuario = $_POST["tipo"];
           $senhaUsuario = $_POST["senha"];
           //chamar o model e fazer o cadastro, validar email com filter, e depois mandar o response com o json para o front e depois, implementar um ajax no email, para informar um email valido enquanto estiver digitando no input, issso e opcional, e depois implementar as funcionalidade de cadastrar e alterar usuario somente se o usuario logado for administrador, e usuario não adm não pode cadastrar, alterar ou visualizar usuario cadastrados, implementar uma view para visualizar os cadastros de usuarios;
        }else{

        }
    }

    
}

?>