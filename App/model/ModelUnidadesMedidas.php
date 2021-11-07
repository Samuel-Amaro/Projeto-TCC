<?php

class ModelUnidadesMedidas{
    
    private int $id;
    private string $sigla;
    private string $descricao;

    public function __construct()
    {
        
    }

    public function setId(int $id) {
        $this->id = $id;
    }
    public function getId() : int{
        return $this->id;
    }
    public function setSigla(string $sigla) {
        $this->sigla = $sigla;
    }
    public function getSigla() : string{
        return $this->sigla;
    }
    public function setDescricao(string $descricao) {
        $this->descricao = $descricao;
    }
    public function getDescricao() : string{
        return $this->descricao;
    }
}

?>