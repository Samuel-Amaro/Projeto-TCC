<?php

class ModelBeneficio{
    
    private int $idBeneficio;
    private string $descricao;
    private string $nome;
    private int $fkCategoria;
    private string $formaAquisicao;
    private int $fkFornecedorDoador;
    private string $dataHora;
    private int $qtdMinima;
    private int $qtdMaxima;

    public function __construct()
    {
        
    }

    public function setId(int $id) {
       $this->idBeneficio = $id; 
    }
    public function getId() : int {
        return $this->idBeneficio;
    }
    public function setDescricao(string $description) {
        $this->descricao = filter_var($description, FILTER_SANITIZE_STRING);
    }
    public function getDescricao() : string{
       return $this->descricao;   
    }
    public function setNome(string $nome) {
        $this->nome = filter_var($nome, FILTER_SANITIZE_STRING);
    }
    public function getNome() : string{
        return $this->nome;
    }
    public function setFkCategoria(int $id) {
        $this->fkCategoria = filter_var($id, FILTER_VALIDATE_INT);
    }
    public function getFkCategoria() : int{
        return $this->fkCategoria;
    }
    public function setFormaAquisicao(string $fa) {
        $this->formaAquisicao = filter_var($fa, FILTER_SANITIZE_STRING);
    }
    public function getFormaAquisicao() : string{
        return $this->formaAquisicao;
    }
    public function setFkFornecedorDoador(int $id) {
        $this->fkFornecedorDoador = filter_var($id, FILTER_VALIDATE_INT);
    }
    public function getFkFornecedorDoador() : int {
        return $this->fkFornecedorDoador;
    }
    public function setDataHora(string $dh) {
        $this->dataHora = filter_var($dh, FILTER_SANITIZE_STRING);
    }
    public function getDataHora() : string{
        return $this->dataHora;
    }
    public function setQtdMinima(int $qtd) {
        $this->qtdMinima = filter_var($qtd, FILTER_VALIDATE_INT);
    }
    public function getQtdMinima() : int{
        return $this->qtdMinima;
    }
    public function setQtdMaxima(int $qtd) {
        $this->qtdMaxima = filter_var($qtd, FILTER_VALIDATE_INT);
    }
    public function getQtdMaxima() : int{
        return $this->qtdMaxima;
    }
}

?>