<?php

class ModelMovimentacoesEstoqueBeneficios{
    
    private int $idEstoque;
    private int $fkBeneficio;
    private int $qtdMovimentada;
    private string $dataHoraUltimaMovimentacao;
    private int $tipoMovimentacao;
    private int $fkUnidadeMedida;
    private int $qtdPorMedida;

    public function __construct()
    {
        
    }

    public function setIdEstoque(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idEstoque = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdEstoque() : int {
       return $this->idEstoque; 
    }
    public function setFkBeneficio(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->fkBeneficio = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getFkBeneficio() : int{
        return $this->fkBeneficio;
    }
    public function setQtdMovimentada(int $qtd) {
        $valor = filter_var($qtd, FILTER_VALIDATE_INT);
        $this->qtdMovimentada = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getQtdMovimentada() : int {
        return $this->qtdMovimentada;
    }
    public function setDataHoraUltimaMovimentacao(string $dataHora) {
        $this->dataHoraUltimaMovimentacao = $dataHora; 
    }
    public function getDataHoraUltimaMovimentacao() : string {
        return $this->dataHoraUltimaMovimentacao;
    }
    public function setTipoMovimentacao(int $tipo) {
       if($tipo === 0 || $tipo === 1) {
          $this->tipoMovimentacao = $tipo;  
       }
    }
    public function getTipoMovimentacao() : int{
       return $this->tipoMovimentacao; 
    }
    public function setFkUnidadeMedida(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->fkUnidadeMedida = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getFkUnidadeMedida() : int{
        return $this->fkUnidadeMedida;
    }
    public function setQtdPorMedida(int $qtd) {
        $valor = filter_var($qtd, FILTER_VALIDATE_INT);
        $this->qtdPorMedida = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getQtdPorMedida() : int {
        return $this->qtdPorMedida;
    }

}

?>