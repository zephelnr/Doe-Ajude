<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.php");
}
?>
<?php
require_once("conexao.php");
if ($_SERVER['REQUEST_METHOD']=='GET') {
    try {   
        // Conectar ao banco de dados
        //$conn = new mysqli($servername, $username, $password, $dbname);
    
        // Verificar se a conexão foi bem-sucedida
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);   
        }
    
        // Verificar se o parâmetro 'id_estado' foi passado via GET
        if (isset($_GET['id_estado']) && isset($_GET['id_municipio']) && isset($_GET['nome'])) {
            $id_estado = $_GET['id_estado'];
            $id_cidade = $_GET['id_municipio'];
            $nome = $_GET['nome'];
            //print_r($_GET['id_estado']);
            
            // Consultar o banco de dados para pegar os dados da publicação
            $sql = "SELECT * FROM municipio WHERE id_estado = '$id_estado' ORDER BY nome";
            //$stmt = $conn->prepare($sql);
            $result = $conn->query($sql);
        } else {
            throw new Exception("Nenhuma Publicação encontrada");
        }

        // Executa a consulta
        //$stmt->execute();
        //$result = $stmt->get_result();

        // Converte os resultados para um array associativo
        //$publicacoes = [];
        if ($result->num_rows > 0) {
            echo "<option selected value='" . $id_cidade . "'>" . $nome . "</option>";
            echo "<option></option>";
            while ($row = $result->fetch_assoc()) {
                //$publicacoes[] = $row;
                //echo "<h1>Informações do Usuário</h1>";
                //echo "<p>Titulo: " . $row['titulo'] . "<p>";

                echo "<option value='" . $row['id_municipio'] ."'>" . $row['nome'] . "</option>";
            }
        }
        //echo "<p>" . $publicacoes['titulo'] . "</p>";
        //print_r($publicacoes);
        //echo json_encode($publicacoes);
        // Fecha a conexão
        //$stmt->close();
    
        // Fechar a conexão com o banco de dados
        $conn->close();
    } catch (Exception $e) {
        //throw $e;
        echo json_encode(["Erro!" . $e->getMessage()]);
        //print_r(["Erro!" . $e->getMessage()]);
    } finally {
        $conn = null;
    }
    
 }
?>