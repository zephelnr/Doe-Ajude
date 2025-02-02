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

            $result = $conn->query($sql);
        } else {
            throw new Exception("Nenhuma Publicação encontrada");
        }

        // Converte os resultados para um array associativo
        if ($result->num_rows > 0) {
            echo "<option selected value='" . $id_cidade . "'>" . $nome . "</option>";
            echo "<option></option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id_municipio'] ."'>" . $row['nome'] . "</option>";
            }
        }
    
        // Fechar a conexão com o banco de dados
        $conn->close();
    } catch (Exception $e) {
        echo json_encode(["Erro!" . $e->getMessage()]);
    } finally {
        $conn = null;
    }
    
 }
?>