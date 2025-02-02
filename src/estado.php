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

            
        // Consultar o banco de dados para pegar os dados da publicação
        $sql = "SELECT * FROM estado ORDER BY nome";
        //$stmt = $conn->prepare($sql);
        $result = $conn->query($sql);

        // Converte os resultados para um array associativo
        if ($result->num_rows > 0) {
            echo "<option selected value=''>Selecione o estado</option>";
            while ($row = $result->fetch_assoc()) {                
                echo "<option value='" . $row['id_estado'] ."'>" . $row['sigla'] . "</option>";
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