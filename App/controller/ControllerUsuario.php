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
            case "listar":
                $this->listar($this->methodHttp);
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
                        $date = new DateTime(null, new DateTimeZone('America/Sao_Paulo'));
                        //caso o objeto do usuario não esteja salvo na seção
                        if(!isset($_SESSION["usuario_logado"])) {
                            //passa objeto model para session serializado e depois quando for usar desserializar ele
                            //hora e data na ao entrar no sistema marcados na session
                            $_SESSION["usuario_logado"] = serialize($this->mdUser);
                            $_SESSION["data_hora_login"] = $date->format("d/m/Y H:m:i");
                            //Retorna a representação JSON de um valor como um response
                            echo json_encode($usuario);
                            exit;
                        }else if(json_encode($usuario) != ''){
                            //if(session_destroy()) {
                                $_SESSION["usuario_logado"] = serialize($this->mdUser);
                                $_SESSION["data_hora_login"] = $date->format("d/m/Y H:m:i");
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
           $this->mdUser = new ModelUsuario(0, $_POST["cpf"], $_POST["telefone"], $_POST["email"], $_POST["cargo"], $_POST["tipo"], $_POST["senha"], $_POST["nome"]);
           if($this->mdUser->cadastrarUsuario()) {
               try {
                   $date = new DateTime(null, new DateTimeZone('America/Sao_Paulo'));
                   $responseJson = ['computedString' => "Usuário com cpf " . $this->mdUser->getCpfUsuario() . " foi cadastrado com sucesso, no dia e  horário. " . $date->format("d/m/Y H:m:i")];
                   echo json_encode($responseJson);
               } catch (Exception $th) {
                   echo "<pre>{$th->getMessage()}</pre>";
               }
           }else{
                $responseJson = ['computedString' => "Usuário não foi cadastrado no banco de dados houve um erro do sistema!"];
                echo json_encode($responseJson); 
           }
        }else{
            $responseJson = ['computedString' => "Usuário não foi cadastrado! method http não e do tipo POST!"];
            echo json_encode($responseJson); 
        }
    }

    private function validaEmail(string $email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            return true;
        }else{
            return false;
        }
    }

    public function listar($methodHttp) {
        if($methodHttp === "POST") {
            //include("../utils/DataBase.php");
            require_once("../dao/DaoUsuario.php");
            $db = new DataBase();
            $dao = new DaoUsuario($db);
            $arrayResult = $dao->selectUsuarios();
            if($arrayResult == false) {
                $responseJson = ['resultUsuarios' => "Sem resultados a mostrar!"];
                echo json_encode($responseJson);
            }else{
                if(json_encode($arrayResult) != '') {
                    echo json_encode($arrayResult);
                }else{
                    $responseJson = ['resultUsuarios' => "Erro ao buscar usuarios no banco!"];
                    echo json_encode($responseJson);
                }
            }
        }else{
            echo "Metodo HTTP não captado! </br>";
        }
    }

    
}

?>