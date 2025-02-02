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
    
        // Verificar se o parâmetro 'email' foi passado via GET
        if (isset($_GET['id_publicacao']) && isset($_GET['usuario_email'])) {
            $idpublicacao = $_GET['id_publicacao'];
            $usuario_email = $_GET['usuario_email'];
            print_r($_GET['usuario_email']);
            print_r($_GET['id_publicacao']);
            
            // Consultar o banco de dados para pegar os dados da publicação
            $sql = "SELECT publicacao.id_publicacao, publicacao.titulo, publicacao.descricao, publicacao.telefone, publicacao.foto, publicacao.status, publicacao.data, publicacao.usuario_email, municipio.id_municipio AS idCidade, municipio.nome AS cidade, estado.id_estado AS estado,estado.sigla AS sigla FROM publicacao INNER JOIN municipio ON publicacao.cidade = municipio.id_municipio INNER JOIN estado ON publicacao.estado = estado.id_estado WHERE id_publicacao = '$idpublicacao' AND usuario_email = '$usuario_email'";
            $result = $conn->query($sql);

            // Verificar se o usuário existe
            if ($result->num_rows > 0) {           
                 // Exibir os dados do usuário
                $row = $result->fetch_assoc();
                echo "<h1>Informações do Usuário</h1>";
                echo "<h2>" . $row['titulo'] . "<h2><br>";
                echo "<h3>" . $row['descricao'] ."</h3><br>";
                echo "<h4>" . $row['cidade'] ."</h4><br>";
                echo "<h5>" . $row['sigla'] . "<h5><br>";
                echo "<h6>" . $row['telefone'] ."</h6><br>";
                echo "<h7>" . $row['foto'] ."</h7><br>";
                echo "<h8>" . $row['estado'] . "</h8><br>";
                echo "<h9>" . $row['idCidade'] . "</h9><br>";
            }
        } else {
            throw new Exception("Nenhuma Publicação encontrada");
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