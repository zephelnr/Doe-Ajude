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
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            //print_r($_GET['email']);
            
            // Consultar o banco de dados para pegar os dados da publicação
            $sql = "SELECT publicacao.id_publicacao, publicacao.titulo, publicacao.descricao, publicacao.telefone, publicacao.foto, publicacao.status, publicacao.data, publicacao.usuario_email, municipio.nome AS cidade, estado.nome AS estado FROM publicacao INNER JOIN municipio ON publicacao.cidade = municipio.id_municipio INNER JOIN estado ON publicacao.estado = estado.id_estado WHERE usuario_email = '$email' AND (`status` = 'Publicado' OR `status` = 'Editado') ORDER BY `data` DESC";

            $result = $conn->query($sql);
        } else {
            throw new Exception("Nenhuma Publicação encontrada");
        }

        // Converte os resultados para um array associativo
        if ($result->num_rows > 0) {
            
            while ($row = $result->fetch_assoc()) {
                // Converte e formata a data
                $data = new DateTime($row['data']);
                $dataFormatada = $data->format('d/m/Y');
                
                echo "<div class='col'>";
                    echo "<div class='card shadow-sm'>";
                        if ($row['foto'] != NULL) {
                            echo "<img class='card-img-top' src='" . $row['foto'] . "' height='350'>";
                        } else {
                            echo "<svg class='bd-placeholder-img card-img-top' width='100%' height='350' xmlns='http://www.w3.org/2000/svg'
                        aria-label='Placeholder: Thumbnail' preserveAspectRatio='xMidYMid slice' role='img' focusable='false'>";
                                echo "<title>" . $row['titulo'] . "</title>";
                                echo "<rect width='100%' height='100%' fill='#55595c' /><text x='50%' y='50%' fill='#eceeef'
                        dy='.3em'>" . $row['titulo'] . "</text>";
                            echo "</svg>";
                        }
                        echo "<div class='card-body'>";
                            echo "<h4 class='card-text'>" . $row['titulo'] ."</h4>";

                            ///função para verificar o tamanho do texto
                            //strlen()
                            if(strlen($row['descricao']) > 33){
                                ///função para limitar caracteres mostrados
                                //substr(string, posição_inicial, comprimento)
                                ///função para truncar o texto sem cortar palavras
                                //strrpos()
                                echo "<p class='card-text'>Descrição: ". substr($row['descricao'], 0, strrpos(substr($row['descricao'], 0, 33), " ")) . "..." . "</p>";
                            } else {
                                echo "<p class='card-text'>Descrição: ". $row['descricao'] . "</p>";
                            }

                            echo "<div class='d-flex justify-content-between align-items-center'>";
                                echo "<div class='btn-group'>";
                                    echo "<a role='button' class='btn btn-sm btn-outline-success' href='editarPublicacao.php?id_publicacao=" . $row['id_publicacao'] . "&usuario_email=" . $row['usuario_email'] . "'>Editar</a>"; //?idpublicacao=" . $row['idpublicacao'] . "&usuario_email=" . $row['usuario_email'] . "
                                echo "</div>";
                                echo "<small class='text-muted'>" . $row['cidade'] . "</br>" . $row['estado'] . "</br>" . $row['status'] ." no dia: " .  $dataFormatada . "</small>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
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