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
        if (isset($_GET['idpublicacao']) && isset($_GET['usuario_email'])) {
            $idpublicacao = $_GET['idpublicacao'];
            $usuario_email = $_GET['usuario_email'];
            print_r($_GET['usuario_email']);
            print_r($_GET['idpublicacao']);
            
            // Consultar o banco de dados para pegar os dados da publicação
            $sql = "SELECT * FROM publicacao WHERE idpublicacao = '$idpublicacao' AND usuario_email = '$usuario_email' AND `status` = 'Disponível' ORDER BY `data` DESC";
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
            
            while ($row = $result->fetch_assoc()) {
                //$publicacoes[] = $row;
                //echo "<h1>Informações do Usuário</h1>";
                //echo "<p>Titulo: " . $row['titulo'] . "<p>";

                // Converte e formata a data
                $data = new DateTime($row['data']);
                $dataFormatada = $data->format('d/m/Y');
                
                
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