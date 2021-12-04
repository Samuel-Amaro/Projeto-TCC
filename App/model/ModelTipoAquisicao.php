<?php 

class ModelTipoAquisicao{
    private int $id;
    private string $tipo;

    public function __construct()
    {
        
    }

    public function setId(int $id) {
        $this->id = filter_var($id, FILTER_VALIDATE_INT);
    }
    public function getId() : int{
        return $this->id;
    }
    public function setTipo(string $tipo) {
        $this->tipo = filter_var($tipo, FILTER_SANITIZE_STRING);
    }
    public function getTipo() : string{
        return $this->tipo;
    }
}

?>