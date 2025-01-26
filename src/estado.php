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

            
        // Consultar o banco de dados para pegar os dados da publicação
        $sql = "SELECT * FROM estado ORDER BY nome";
        //$stmt = $conn->prepare($sql);
        $result = $conn->query($sql);


        // Executa a consulta
        //$stmt->execute();
        //$result = $stmt->get_result();

        // Converte os resultados para um array associativo
        //$publicacoes = [];
        if ($result->num_rows > 0) {
            echo "<option selected value=``>Selecione o estado</option>";
            while ($row = $result->fetch_assoc()) {
                //$publicacoes[] = $row;
                //echo "<h1>Informações do Usuário</h1>";
                //echo "<p>Titulo: " . $row['titulo'] . "<p>";
                
                echo "<option value=`" . $row['id_estado'] ."`>" . $row['sigla'] . "</option>";

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