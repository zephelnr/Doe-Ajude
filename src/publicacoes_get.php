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
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Verificar se a conexão foi bem-sucedida
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);   
        }
    
        // Verificar se o parâmetro 'email' foi passado via GET
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            //print_r($_GET['email']);
            
            // Consultar o banco de dados para pegar os dados da publicação
            $sql = "SELECT * FROM publicacao WHERE usuario_email = '$email'";
            $stmt = $conn->prepare($sql);
            
        } else {
            throw new Exception("Nenhuma Publicação encontrada");
        }

        // Executa a consulta
        $stmt->execute();
        $result = $stmt->get_result();

        // Converte os resultados para um array associativo
        $publicacoes = [];
        while ($row = $result->fetch_assoc()) {
            $publicacoes[] = $row;
        }

        print_r($publicacoes);
        // Fecha a conexão
        $stmt->close();
    
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