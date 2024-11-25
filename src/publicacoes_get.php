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
            //$publicacoes[] = $row;
            //echo "<h1>Informações do Usuário</h1>";
            //echo "<p>Titulo: " . $row['titulo'] . "<p>";
            
            echo "<div class='col'>";
                echo "<div class='card shadow-sm'>";
                    echo "<svg class='bd-placeholder-img card-img-top' width='100%' height='225' xmlns='http://www.w3.org/2000/svg'
                aria-label='Placeholder: Thumbnail' preserveAspectRatio='xMidYMid slice' role='img' focusable='false'>";
                        echo "<title>" . $row['titulo'] . "</title>";
                        echo "<rect width='100%' height='100%' fill='#55595c' /><text x='50%' y='50%' fill='#eceeef'
                  dy='.3em'>" . $row['titulo'] . "</text>";
                    echo "</svg>";
                    echo "<div class='card-body'>";
                        echo "<h4 class='card-text'>" . $row['titulo'] ."</h4>";
                        echo "<p class='card-text'>Descrição: ". $row['descricao'] . " </br>Status: " . $row['status'] . "</p>";
                        echo "<div class='d-flex justify-content-between align-items-center'>";
                            echo "<div class='btn-group'>";
                                echo "<button type='button' class='btn btn-sm btn-outline-secondary'>Visualizar</button>";
                                echo "<button type='button' class='btn btn-sm btn-outline-secondary'>Editar</button>";
                            echo "</div>";
                            echo "<small class='text-muted'>" . $row['cidade'] . " , " . $row['estado'] . "</br>" .  $row['data'] . "</small>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        }
        //echo "<p>" . $publicacoes['titulo'] . "</p>";
        //print_r($publicacoes);
        //echo json_encode($publicacoes);
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