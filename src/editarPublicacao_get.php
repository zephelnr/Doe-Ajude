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
    
        // Verificar se o parâmetro 'email' foi passado via GET
        if (isset($_GET['id_publicacao']) && isset($_GET['usuario_email'])) {
            $idpublicacao = $_GET['id_publicacao'];
            $usuario_email = $_GET['usuario_email'];
            print_r($_GET['usuario_email']);
            print_r($_GET['id_publicacao']);
            
            // Consultar o banco de dados para pegar os dados da publicação
            $sql = "SELECT publicacao.id_publicacao, publicacao.titulo, publicacao.descricao, publicacao.telefone, publicacao.foto, publicacao.status, publicacao.data, publicacao.usuario_email, municipio.nome AS cidade, estado.nome AS estado FROM publicacao INNER JOIN municipio ON publicacao.cidade = municipio.id_municipio INNER JOIN estado ON publicacao.estado = estado.id_estado WHERE id_publicacao = '$idpublicacao' AND usuario_email = '$usuario_email'";
            $result = $conn->query($sql);

            // Verificar se o usuário existe
            if ($result->num_rows > 0) {           
                 // Exibir os dados do usuário
                $row = $result->fetch_assoc();
                echo "<h1>Informações do Usuário</h1>";
                echo "<h2>" . $row['titulo'] . "<h2><br>";
                echo "<h3>" . $row['descricao'] ."</h3><br>";
                echo "<h4>" . $row['cidade'] ."</h4><br>";
                echo "<h5>" . $row['estado'] . "<h5><br>";
                echo "<h6>" . $row['telefone'] ."</h6><br>";
                echo "<h7>" . $row['foto'] ."</h7><br>";
            }
        } else {
            throw new Exception("Nenhuma Publicação encontrada");
        }

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