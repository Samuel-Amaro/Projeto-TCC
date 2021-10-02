<?php 

class ModelOperacaoUsuarioBeneficiario{

    private int $idOperacao;
    private int $fkBeneficiario;
    private int $fkUsuario;
    private string $tipoOperacao;
    private ?string $dataHoraOperacao;

    public function __construct()
    {
        
    }

    public function setIdOperacao(int $id) {
        $this->idOperacao = $id;
    }
    public function getIdOperacao() : int{
       return $this->idOperacao; 
    }
    public function setFkBeneficiario(int $fkBene) {
        $this->fkBeneficiario = $fkBene;
    }
    public function getFkBeneficiario() : int{
        return $this->fkBeneficiario;
    }
    public function setFkUsuario(int $fkUsu) {
        $this->fkUsuario = $fkUsu;
    }
    public function getFkUsuario() : int{
        return $this->fkUsuario;
    }
    public function setTipoOperacao(string $tipo) {
        $this->tipoOperacao = $tipo;
    }
    public function getTipoOperacao() : string{
        return $this->tipoOperacao;
    }
    public function setDataHoraOperacao(?string $dataHora) {
        $this->dataHoraOperacao = $dataHora;
    }
    public function getDataHoraOperacao() : ?string {
        return $this->dataHoraOperacao;
    }
}


?>