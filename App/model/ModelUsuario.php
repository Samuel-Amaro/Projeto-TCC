<?php

include("../dao/DaoUsuario.php");
require_once("../utils/DataBase.php");

class ModelUsuario{

    private int $id_usuario;
    private string $cpf_usuario;
    private string $celular_usuario;
    private string $email_usuario;
    private string $cargo_usuario;
    private string $tipo_usuario;
    private string $senha_usuario;
    private string $data_cadastro_usuario;
    private string  $nome_usuario;
    private DaoUsuario $daoUser;
    private DataBase $db;

    public function __construct(int $id, string $cpf, string $celular, string $email, string $cargo, string $tipo, string $senha, string $nome) {
        $this->id_usuario = $id;
        $this->cpf_usuario = $cpf;
        $this->celular_usuario = $celular;
        $this->email_usuario = $email;
        $this->cargo_usuario = $cargo;
        $this->tipo_usuario = $tipo;
        $this->senha_usuario = $senha;
        $this->nome_usuario = $nome;
        $this->db = new DataBase();
    }

    public function getDataCadastroUsuario() {
        return $this->data_cadastro_usuario;
    }
    public function setIdUsuario(int $id) {
        $this->id_usuario = $id;
    }
    public function getIdUsuario() {
        return $this->id_usuario;
    }
    public function setCpfUsuario(string $cpf) {
        $this->cpf_usuario = $cpf;
    }
    public function getCpfUsuario() {
        return $this->cpf_usuario;    
    }
    public function setCelularUsuario(string $numeroCelular) {
        $this->celular_usuario = $numeroCelular; 
    }
    public function getCelularUsuario() {
        return $this->celular_usuario;
    }
    public function setEmailUsuario(string $email) {
        $this->email_usuario = $email;
    }
    public function getEmailUsuario() {
        return $this->email_usuario;
    }
    public function setCargoUsuario(string $cargo) {
        $this->cargo_usuario = $cargo;      
    }
    public function getCargoUsuario() {
        return $this->cargo_usuario;
    }
    public function setTipoUsuario(string $tipo) {
        $this->tipo_usuario = $tipo;
    }
    public function getTipoUsuario() {
        return $this->tipo_usuario;
    }
    public function setSenhaUsuario(string $senha) {
        $this->senha_usuario = $senha;
    }
    public function getSenhaUsuario() {
        return $this->senha_usuario;
    }
    public function setNomeUsuario(string $nome) {
        $this->nome_usuario = $nome;
    }
    public function getNomeUsuario() {
        return $this->nome_usuario;
    }

    /**
     * cadastrar um usuario
    */
    public function cadastrarUsuario() {
        $this->daoUser = new DaoUsuario($this->db);
        $passwordHash = md5($this->senha_usuario);
        $resultInsert = $this->daoUser->insertUsuario($this->cpf_usuario, $this->celular_usuario, $this->email_usuario, $this->cargo_usuario, $this->tipo_usuario, $this->tipo_usuario, $this->senha_usuario, $passwordHash);
        if($resultInsert) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * metodo magico para visualizar propriedades da classe
    */
    public function __toString()
    {
        $str = "
                <p>Objeto ModelUsuario</p>
                [
                id_usuario => {$this->id_usuario}, </br>
                cpf_usuario => {$this->cpf_usuario}, </br>
                celular_usuario => {$this->celular_usuario}, </br>
                email_usuario => {$this->email_usuario}, </br>
                cargo_usuario => {$this->cargo_usuario}, </br>
                tipo_usuario => {$this->cargo_usuario}, </br>
                senha_usuario => {$this->senha_usuario}, </br>
                nome_usuario => {$this->nome_usuario}, </br>
                data_cadastro_usuario => {$this->data_cadastro_usuario}
               ] 
        ";
        return $str;
    }

    public function buscarUsuario() {
        $this->daoUser = new DaoUsuario($this->db);
        //$passwordHash = md5($this->senha_usuario);
        #$cpfSemForm = $this->tirarMascaraCpf($this->cpf_usuario);
        $resultado = $this->daoUser->selectUsuario($this->cpf_usuario, $this->senha_usuario);
        if(is_array($resultado)) {
            foreach($resultado as $item) {
                if($this->cpf_usuario == $item["cpf_usuario"] && $this->senha_usuario == $item["senha_usuario"]) {
                    $this->id_usuario = $item["id_usuario"];
                    $this->cpf_usuario = $item["cpf_usuario"];
                    $this->celular_usuario = $item["celular_usuario"];
                    $this->email_usuario = $item["email_usuario"];
                    $this->cargo_usuario = $item["cargo_usuario"];
                    $this->tipo_usuario = $item["tipo_usuario"];
                    $this->senha_usuario = $item["senha_usuario"];
                    $this->data_cadastro_usuario = $item["data_cadastro_usuario"];
                    $this->nome_usuario = $item["nome_usuario"];
                    return true;    
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }

    private function tirarMascaraCpf(string $cpf) {
        $cpfComForm = $cpf;
        $cpfParte1 = substr($cpfComForm, 0, 3);
        $cpfParte2 = substr($cpfComForm, 4, 3);
        $cpfParte3 = substr($cpfComForm, 8, 3);
        $cpfParte4 = substr($cpfComForm, 12, 2);
        $cpfSemForm = $cpfParte1 . $cpfParte2 . $cpfParte3 . $cpfParte4;
        return  $cpfSemForm;
    }
   
}

?>