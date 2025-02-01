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
        if (isset($_GET['id_publicacao']) && isset($_GET['email'])) {
            $id_publicacao = $_GET['id_publicacao'];
            $email = $_GET['email'];
            //print_r($_GET['email']);
            //print_r($_GET['id_publicacao']);
            
            // Consultar o banco de dados para pegar os dados do usuário
            $sql = "SELECT publicacao.titulo, publicacao.descricao, publicacao.foto, publicacao.status, publicacao.data, publicacao.usuario_email, municipio.nome AS cidade, estado.nome AS estado FROM publicacao INNER JOIN municipio ON publicacao.cidade = municipio.id_municipio INNER JOIN estado ON publicacao.estado = estado.id_estado WHERE id_publicacao = '$id_publicacao'";
            $result = $conn->query($sql);
    
            // Verificar se o usuário existe
            if ($result->num_rows > 0) {
                // Converte e formata a data
                //$data = new DateTime($row['data']);
                //$dataFormatada = $data->format('d/m/Y');

                // Exibir os dados do usuário
                $row = $result->fetch_assoc();
                echo "<h1>Informações da Publicação</h1>";
                //echo "<p>email: " . $row['email'] . "<p><br>";
                echo "<h2>" . $row['titulo'] ."</h2><br>";
                echo "<h3>" . $row['descricao'] ."</h3><br>";
                echo "<h4>" . $row['cidade'] . "</h4><br>";
                echo "<h5>" . $row['estado'] . "</h5><br>";
                echo "<h6>" . $row['status'] . "</h6><br>";
                echo "<h7>" . $row['data'] . "</h7><br>";
                echo "<h8>" . $row['usuario_email'] . "</h8><br>";
                echo "<h9>" . $row['foto'] . "</h9><br>";

                if ($email != $row['usuario_email']){
                    $consultaSql = "SELECT * FROM `interesse` WHERE usuario_email = '$email' AND publicacao_id_publicacao ='$id_publicacao'; ";
                    $resultado = $conn->query($consultaSql);
                    if ($resultado->num_rows == 0){                        
                        echo "<a>Demonstrar</a>";
                    } else {
                        echo "<a>Desfazer</a>";
                    }
                    
                } else {
                    echo "<a>Dono da publicação</a>";
                }
            } else {
                throw new Exception("Nenhuma publicação encontrada com esse id.");
            }
        } else {
            //throw new Exception("Por favor, informe um email de usuário.");
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