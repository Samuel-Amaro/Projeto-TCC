<?php

require_once("../dao/DaoFornecedoresDoadores.php");
require_once("../utils/DataBase.php");

//verifica qual o tipo de metodo e operação a se fazer
if($_SERVER["REQUEST_METHOD"] == "POST") { //Postagem de recursos no server
    $operacao = $_POST["operacao"];
    $ctr = new ControllerFornecedoresDoadores($operacao, "POST");
}

class ControllerFornecedoresDoadores{

    private string $operacao;
    private string $methodHttp;
    private ModelFornecedorDoador $modelFornDoador;
    private DaoFornecedoresDoadores $daoForneDoador;
    private array $responseJson;

    public function __construct(string $operacao, string $methodHttp)
    {
        $this->operacao = $operacao;
        $this->methodHttp = $methodHttp;
        switch($this->operacao) {
            case "cadastrar":
                $this->cadastrarFornecedorDodador($this->methodHttp);
                break;
            case "listar": 
                $this->listarFornecedoresDoadores($this->methodHttp);
                break;
            case "alterar": 
                $this->alterarFornecedorDoador($this->methodHttp);
                break;
            case "deletar":
                $this->excluirFornecedorDoador($this->methodHttp);
                break;
            case "busca":
                $this->buscarFornecedorDoador($this->methodHttp);
                break;
            default:
                break;
        }
    }

    /**
     * * Esta função e responsavel por cadastrar um fornecedor ou doador no sistema, chamando a camada model responsavel junto com a dao
     */
    public function cadastrarFornecedorDodador(string $methodHttp) {
        if($methodHttp === "POST") {
            $this->modelFornDoador = new ModelFornecedorDoador();
            $this->modelFornDoador->setNome($_POST["nome"]); //nome
            $this->modelFornDoador->setDescricao(empty($_POST["descricao"]) ? null : $_POST["descricao"]); //descrição
            $this->modelFornDoador->setTipoPessoa($_POST["tipoPessoa"]); //Tipo Pessoa
            $this->modelFornDoador->setIdentificacao($_POST["identificacao"]); //Identificação
            $this->modelFornDoador->setCpf(empty($_POST["cpf"]) ? null : $_POST["cpf"]); //cpf
            $this->modelFornDoador->setCnpj(empty($_POST["cnpj"]) ? null : $_POST["cnpj"]); //cnpj
            $this->modelFornDoador->setCep(empty($_POST["cep"]) ? null : $_POST["cep"]); //cep
            $this->modelFornDoador->setEndereco($_POST["endereco"]); //endereço
            $this->modelFornDoador->setComplemento(empty($_POST["complemento"]) ? null : $_POST["complemento"]); //complemento
            $this->modelFornDoador->setBairro($_POST["bairro"]); //bairro
            $this->modelFornDoador->setCidade($_POST["cidade"]); //cidade
            $this->modelFornDoador->setUf($_POST["estado"]); //estado
            $this->modelFornDoador->setTelefoneCelular($_POST["telefoneCelular"]); //telefone celular
            $this->modelFornDoador->setTelefoneFixo($_POST["telefoneFixo"]); //telefone fixo
            $this->modelFornDoador->setEmail(empty($_POST["email"]) ? null : $_POST["email"]); //email
            $this->daoForneDoador = new DaoFornecedoresDoadores(new DataBase());
            if($this->daoForneDoador->insertFornecedorDoador($this->modelFornDoador)) {
                if($this->modelFornDoador->getIdentificacao() === "DOADOR") {
                    $this->setResponseJson("response", "Ótimo você acaba de cadastrar um doador.");
                    echo $this->getResponseJson();
                }else{
                    $this->setResponseJson("response", "Ótimo você acaba de cadastrar um fornecedor.");
                    echo $this->getResponseJson();
                }
            }else{
                $this->setResponseJson("response", "Ops.. temos um problema interno em nosso servidor, tenta ação novamente.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Ops.. request method HTTP não e do tipo POST");
            echo $this->getResponseJson();
        }
    }

    /**
     * * Esta função busca todos fornecedores e doadores cadastrados
     */
    public function listarFornecedoresDoadores(string $methodHttp) {
        if($methodHttp === "POST") {
           $this->daoForneDoador = new DaoFornecedoresDoadores(new DataBase()); 
           $listaResultadoFornecedoresDoadores = $this->daoForneDoador->selectFornecedoresDoadores();
           if(is_array($listaResultadoFornecedoresDoadores)) {
              //verificar a forma como arrumar esses dados e formatados em json para o front end
              $lista = array();
              foreach($listaResultadoFornecedoresDoadores as $chave => $valor) {
                 array_push($lista, $valor);
              } 
              $response = array("data" => $lista);
              echo json_encode($response);
           }else{
              $this->setResponseJson("response", "Sem Fornecedores e Doadores Cadastrados");
              echo $this->getResponseJson();
           }
        }else{
            $this->setResponseJson("response", "Ops.. request method HTTP não e do tipo POST");
            echo $this->getResponseJson();
        }
    }

    /**
     * * Esta funçaõ e reposanvel por tratar a requisção para alteração de registro de um fornecedor e doador
     */
    public function alterarFornecedorDoador(string $methodHttp) {
        if($methodHttp == "POST") {
            $this->modelFornDoador = new ModelFornecedorDoador();
            $this->modelFornDoador->setId($_POST["id"]); //id
            $this->modelFornDoador->setNome($_POST["nome"]); //nome
            $this->modelFornDoador->setDescricao(empty($_POST["descricao"]) ? null : $_POST["descricao"]); //descrição
            $this->modelFornDoador->setTipoPessoa($_POST["tipoPessoa"]); //Tipo Pessoa
            $this->modelFornDoador->setIdentificacao($_POST["identificacao"]); //Identificação
            $this->modelFornDoador->setCpf(empty($_POST["cpf"]) ? null : $_POST["cpf"]); //cpf
            $this->modelFornDoador->setCnpj(empty($_POST["cnpj"]) ? null : $_POST["cnpj"]); //cnpj
            $this->modelFornDoador->setCep(empty($_POST["cep"]) ? null : $_POST["cep"]); //cep
            $this->modelFornDoador->setEndereco($_POST["endereco"]); //endereço
            $this->modelFornDoador->setComplemento(empty($_POST["complemento"]) ? null : $_POST["complemento"]); //complemento
            $this->modelFornDoador->setBairro($_POST["bairro"]); //bairro
            $this->modelFornDoador->setCidade($_POST["cidade"]); //cidade
            $this->modelFornDoador->setUf($_POST["estado"]); //estado
            $this->modelFornDoador->setTelefoneCelular($_POST["telefoneCelular"]); //telefone celular
            $this->modelFornDoador->setTelefoneFixo($_POST["telefoneFixo"]); //telefone fixo
            $this->modelFornDoador->setEmail(empty($_POST["email"]) ? null : $_POST["email"]); //email
            $this->daoForneDoador = new DaoFornecedoresDoadores(new DataBase());
            if($this->daoForneDoador->updateFornecedorDoador($this->modelFornDoador)) {
                $this->setResponseJson("response", "Alteração realizada com sucesso.");
                echo $this->getResponseJson();
            }else{
                $this->setResponseJson("response", "Alteração não realizada. tivemos um problema interno em nosso servidor, por favor tente mais tarde essa ação.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Ops.. request method HTTP não e do tipo POST");
            echo $this->getResponseJson();
        }
    }

    /**
     * * ESTA FUNÇÃO CONTROLA O PEDIDO DA REQUISIÇÃO PARA EXCLUIR UM FORNECEDOR OU DOADOR, CONTROLA AÇÃO E ENVIA PARA A CAMADA CORRETA
     */
    public function excluirFornecedorDoador(string $methodHttp) {
       if($methodHttp === "POST") {
           $id = $_POST["id"]; 
           $this->daoForneDoador = new DaoFornecedoresDoadores(new DataBase());
           if($this->daoForneDoador->deleteFornecedorDoador($id)) {
                $this->setResponseJson("response", "Exclusão realizada com sucesso.");
                echo $this->getResponseJson();
           }else{
                $this->setResponseJson("response", "Exclusão não realizada. tivemos um problema interno em nosso servidor, por favor tente mais tarde essa ação.");
                echo $this->getResponseJson();
           }
       }else{
            $this->setResponseJson("response", "Ops.. request method HTTP não e do tipo POST");
            echo $this->getResponseJson();
       } 
    }

    /**
     * * ESTA FUNÇÃO CONTROLA A REQUISIÇÃO DE BUSCA PARA REGISTROS DE FORNECEDORES E DOADORES, CONTROLA A FUNÇÃO E A REQUISIÇÃO PARA RETORNAR OS DADOS SOLICITADOS
     * 
     */
    public function buscarFornecedorDoador(string $methodHttp) {
        if($methodHttp === "POST") {
            $cpfOuCnpj = $_POST["termo"];
            $this->daoForneDoador = new DaoFornecedoresDoadores(new DataBase());
            $resultado = $this->daoForneDoador->search($cpfOuCnpj);
            if(is_array($resultado)) {
                $lista = array();
                foreach($resultado as $chave => $valor) {
                    //element 0 (um registro) $chave
                    /*foreach($valor as $chave => $valorResu) {
                        //valor e um array com uma linha de registro    
                        if($chave == "cpf") {
                            //se cpf for null não seta na lista
                            if(is_null($valorResu)) {
                              //faz nada
                            }else{
                                $elementoArrayCpf = array("value" => $valorResu);
                                array_push($lista, $elementoArrayCpf);
                            }
                        }else if($chave == "cnpj"){
                            if(is_null($valorResu)) {
                                //faz nada
                            }else{
                                $elementoArrayCnpj = array("value" => $valorResu);
                                array_push($lista, $elementoArrayCnpj);
                            }
                        }else if($chave == "nome"){
                            //nome
                            $elemento = array("value" => $valorResu);
                            array_push($lista, $elemento);
                        } 
                    }*/
                    if(is_null($valor["cpf"])) {
                        $elementoArrayCnpj = array("value" => $valor["cnpj"] . "-" . $valor["nome"]);
                        array_push($lista, $elementoArrayCnpj);
                    }else if(is_null($valor["cnpj"])){
                        $elementoArrayCpf = array("value" => $valor["cpf"] . "-" . $valor["nome"]);
                        array_push($lista, $elementoArrayCpf);    
                    }        
                } 
                //$response = array("data" => $lista);
                //echo json_encode(array($lista));
                echo json_encode($lista);
            }else{
                $this->setResponseJson("response", "Nenhum fornecedor/doador foi encontrado com o cpf ou cnpj informado. verifique por favor e tente novamente.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Method de solicitação HTTP não e do tipo post.");
            echo $this->getResponseJson();
        }
    }

    public function setOperacao(string $op) {
        $this->operacao = $op;
    } 
    public function getOperacao() : string{
        return $this->operacao;
    }
    public function setMetodoHttp(string $metHt) {
        $this->methodHttp = $metHt;
    }
    public function getMetodoHttp() : string{
        return $this->methodHttp;
    }
    public function setModel(ModelFornecedorDoador $model) {
        $this->modelBenef = $model;
    }
    public function getModel() : ModelFornecedorDoador{
        return $this->modelBenef;
    }
    public function setDao(DaoFornecedoresDoadores $dao) {
        $this->daoBenef = $dao;
    }
    public function getDao() : DaoFornecedoresDoadores{
        return $this->daoBenef;
    }
    public function setResponseJson(string $chave, string $responseValor) {
        $res = array($chave => $responseValor);
        $this->responseJson = $res;
    }
    public function getResponseJson() {
        if(empty($this->responseJson)) {
            return null;
        }else{
            if(empty(json_encode($this->responseJson))) {
                return null;
            }else{
                return json_encode($this->responseJson);
            }
        }
    } 
}
?>