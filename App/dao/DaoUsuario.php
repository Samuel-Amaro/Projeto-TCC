<?php 


/**
 * DaoUsuario, representa os metodos de read, insert, delete, update relacionados a uma usuario 
*/
class DaoUsuario{

    private $connection;

    public function __construct(DataBase $con) {
        $this->connection = $con->conexaoSGBD;
    }

    /**
     * este metodo e responsavel por inserir uma linha de registro na tabela usuario do banco de dados
    */
    public function insertUsuario(string $cpf, string $celular, string $email, string $cargo, string $tipo, string $senha, string $nome) : ?bool  {
        if(is_null($this->connection)) {
            //print "Conexão com o SGBD não iniciada! </br>";
            return false;
            die();
        }else{
            try {
                $sql = "INSERT INTO usuario (cpf_usuario, celular_usuario, email_usuario, cargo_usuario, tipo_usuario, senha_usuario, nome_usuario) VALUES (?, ?, ?, ?, ?, ?, ?);";
                //Prepara uma instrução para execução e retorna um objeto de instrução
                $stmt = $this->connection->prepare($sql);
                $valores = array($cpf, $celular, $email, $cargo, $tipo, $senha, $nome);
                //Executa uma instrução preparada
                $stmt->execute($valores);
                //executou consulta com sucesso
                if($stmt) {
                    //echo "Inseriu {$stmt->rowCount()} linhas na tabela usuario! </br>";
                    $stmt = null;
                    $this->connection = null;
                    return true;
                }else{
                    //falha ao executar consulta
                    return false;
                }
            } catch (PDOException $e) {
                $stmt = null;
                $this->connection = null;
                echo "Error!: falha ao preparar consulta INSERT usuario: <pre>" . $e->getMessage() . "</pre> </br>";
                return null;
                //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                die();
            }
        }
    }

    /**
     * este metodo e responsavel por buscar um usuario na tabela usuario, com seu respectivo cpf e senha 
    */
    public function selectUsuario(string $cpf, string $senha) {
        if(is_null($this->connection)) {
            return false;
            die();
        }else{
            try {
                $sql = "SELECT * FROM usuario WHERE cpf_usuario = ? AND senha_usuario = ?;";
                $stmt = $this->connection->prepare($sql);
                $valores = array($cpf, $senha);
                if($stmt->execute($valores)) {
                    $resultado = $stmt->fetchAll();
                    if(empty($resultado)) {
                        $stmt = null;
                        $this->connection = null;
                        return false;
                    }else{
                        $stmt = null;
                        $this->connection = null;
                        return $resultado;
                    }
                }else{
                   $stmt = null;
                   $this->connection = null;
                   return false; 
                }
            } catch (PDOException $e) {
               echo "Error!: falha ao executar consulta SELECT usuario: <pre>" . $e->getMessage() . "</pre></br>";
               return false;
            }finally{
                $stmt = null;
                $this->connection = null;
            }
        }
    }

    /**
     * retorna todos as linhas de resultado na tabela usuario 
    */
    public function selectUsuarios() {
        if(is_null($this->connection)) {
            return false;
            die();
        }else{
            try {
                $sql = "SELECT cpf_usuario, celular_usuario, email_usuario, cargo_usuario, tipo_usuario, nome_usuario FROM usuario;";
                $stmt = $this->connection->prepare($sql);
                if($stmt->execute()) {
                    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if(empty($resultado)) {
                        $stmt = null;
                        $this->connection = null;
                        return false;
                    }else{
                        $stmt = null;
                        $this->connection = null;
                        return $resultado;
                    }
                }else{
                   $stmt = null;
                   $this->connection = null;
                   return false; 
                }
            } catch (PDOException $e) {
               echo "Error!: falha ao executar consulta SELECT usuario: <pre>" . $e->getMessage() . "</pre></br>";
               return false;
            }finally{
                $stmt = null;
                $this->connection = null;
            }
        }
    }

    /**
     * este metodo atualiza um registro na tabela usuario 
    */
    public function updateUsuario(int $id, string $telefone, string $email, string $cargo, string $tipo, string $senha, string $nome) {
        if(is_null($this->connection)) {
            return false;
            die();
        }else{
            try {
                $sql = "UPDATE usuario SET celular_usuario=?, email_usuario=?, cargo_usuario=?, tipo_usuario=?, senha_usuario=?, nome_usuario=?  WHERE id_usuario = ?;";
                $stmt = $this->connection->prepare($sql);
                $valores = array($telefone, $email, $cargo, $tipo, $senha, $nome, $id);
                if($stmt->execute($valores)) {
                    $stmt = null;
                    $this->connection = null;
                    return true;
                }else{
                   $stmt = null;
                   $this->connection = null;
                   return false; 
                }
            } catch (PDOException $e) {
                $stmt = null;
                $this->connection = null;
                echo "Error!: falha ao executar consulta UPDATE usuario: <pre>" . $e->getMessage() . "</pre></br>";
               return false;
            }finally{
                $stmt = null;
                $this->connection = null;
            }
        }
    }

    public function deleteUsuario(int $idUser) {
        if(is_null($this->connection)) {
            return false;
            die();
        }else{
            try {
                $sql = "DELETE FROM usuario WHERE id_usuario = ?;";
                $stmt = $this->connection->prepare($sql);
                $valores = array($idUser);
                if($stmt->execute($valores)) {
                    $stmt = null;
                    $this->connection = null;
                    return true;
                }else{
                   $stmt = null;
                   $this->connection = null;
                   return false; 
                }
            } catch (PDOException $e) {
                $stmt = null;
                $this->connection = null;
                echo "Error!: falha ao executar consulta DELETE usuario: <pre>" . $e->getMessage() . "</pre></br>";
               return false;
            }finally{
                $stmt = null;
                $this->connection = null;
            }
        }
    }

}

?>