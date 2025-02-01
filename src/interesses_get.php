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
        if (isset($_GET['usuario_email'])) {
            $usuario_email = $_GET['usuario_email'];
            //print_r($_GET['email']);
            
            // Consultar o banco de dados para pegar os dados da publicação
            $sql = "SELECT interesse.id_interesse, publicacao.titulo AS titulo, publicacao.telefone AS telefone, publicacao.data AS `data`, municipio.nome AS cidade, estado.sigla AS estado, usuario.nomeCompleto AS nome, usuario.cpf AS cpf FROM interesse INNER JOIN publicacao ON interesse.publicacao_id_publicacao = publicacao.id_publicacao INNER JOIN municipio ON publicacao.cidade = municipio.id_municipio INNER JOIN estado ON publicacao.estado = estado.id_estado INNER JOIN usuario ON usuario.email = publicacao.usuario_email WHERE interesse.usuario_email = '$usuario_email' ORDER BY `data` DESC";
            //$stmt = $conn->prepare($sql);
            $result = $conn->query($sql);
        } else {
            throw new Exception("Nenhuma Publicação encontrada");
        }

        if ($result->num_rows > 0) {
            
            while ($row = $result->fetch_assoc()) {               
                echo "<div>";
                    echo "<div class='card border border-dark-subtle'>";
                        echo "<div class='card-body'>";
                            echo "<div class='hstack gap-3'>";
                            
                                echo "<div>";
                                    echo "<div class='p-2 bg-success-subtle rounded'>Titulo:</div>";
                                    echo "<input type='text' name='titulo' class='form-control rounded' id='titulo' value='" . $row['titulo'] . "' disabled>";
                                echo "</div>";

                                echo "<div>";
                                    echo "<div class='p-2 bg-success-subtle rounded'>Nome Completo</div>";
                                    echo "<input type='text' name='nomeCompleto' class='form-control rounded' id='nomeCompleto' value='" . $row['nome'] . "' disabled>";
                                echo "</div> ";

                                echo "<div>";
                                    echo "<div class='p-2 bg-success-subtle rounded'>CPF:</div>";
                                    echo "<input type='text' name='cpf' class='form-control rounded' id='cpf' value='" . $row['cpf'] . "' disabled>";
                                echo "</div>";

                                echo "<div>";
                                    echo "<div class='p-2 bg-success-subtle rounded'>Localização:</div>";
                                    echo "<input type='text' name='localizacao' class='form-control rounded' id='localizacao' value='" . $row['cidade'] . "' disabled>";
                                echo "</div>";

                                echo "<div>";
                                    echo "<div class='p-2 bg-success-subtle rounded'>Contato:</div>";
                                    echo "<input type='text' name='telefone' class='form-control rounded' id='telefone' value='" . $row['telefone'] . "' disabled>";
                                echo "</div>";

                                echo "<div class='vr'></div>";
                                echo "<div class='mb-3 d-grid gap-5 d-md-flex justify-content-md-left p-2'>";
                                    echo "<a class='btn btn-success rounded-pill' href='' role='button'>Desfazer Interesse</a>";
                                echo "</div>";

                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }
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