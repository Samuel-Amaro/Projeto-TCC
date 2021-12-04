<?php 

class ModelTipoBeneficio{

    private int $idTipoBeneficio;
    private string $nomeTipo;
    private int $idUnidadeMedida;
    private int $idCategoria;

    public function __construct()
    {
        
    }

    public function setIdTipoBeneficio(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idTipoBeneficio = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdTipoBeneficio() : int{
        return $this->idTipoBeneficio;
    }
    public function setNomeTipo(string $nome) {
        $this->nomeTipo = filter_var($nome, FILTER_SANITIZE_STRING);
    }
    public function getNomeTipo() : string{
        return $this->nomeTipo;
    }
    public function setIdUnidadeMedida(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idUnidadeMedida = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdUnidadeMedida() : int {
       return $this->idUnidadeMedida; 
    }
    public function setIdCategoria(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idCategoria = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdCategoria() : int{
        return $this->idCategoria;
    }
    
}

?>