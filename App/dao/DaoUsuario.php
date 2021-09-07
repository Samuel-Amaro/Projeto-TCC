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
            print "Conexão com o SGBD não iniciada! </br>";
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
                    echo "Inseriu {$stmt->rowCount()} linhas na tabela usuario! </br>";
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
                print "Error!: falha ao preparar consulta insert usuario: " . $e->getMessage() . "</br>";
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
               print "Error!: falha ao executar consulta select usuario: " . $e->getMessage() . "</br>";
               return false;
            }finally{
                $stmt = null;
                $this->connection = null;
            }
        }
    }

}

?>