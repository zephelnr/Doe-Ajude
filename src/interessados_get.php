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
            $sql = "SELECT interesse.id_interesse, publicacao.id_publicacao AS idpub, publicacao.titulo AS titulo, publicacao.telefone AS telefone, publicacao.status AS `status`, publicacao.data AS `data`, usuario.nomeCompleto AS nome, usuario.cpf AS cpf FROM interesse INNER JOIN publicacao ON interesse.publicacao_id_publicacao = publicacao.id_publicacao INNER JOIN usuario ON usuario.email = interesse.usuario_email WHERE  interesse.publicacao_id_publicacao IS NOT NULL AND publicacao.usuario_email = '$usuario_email' ORDER BY `data` DESC";

            $result = $conn->query($sql);
        } else {
            throw new Exception("Nenhuma Publicação encontrada");
        }

        if ($result->num_rows > 0) {            
            
            while ($row = $result->fetch_assoc()) {

                // Aplica a máscara do telefone
                if (strlen($row['telefone']) === 11) {
                    // Formato para celular com DDD: (XX) XXXXX-XXXX
                    $telefoneMascara = preg_replace('/(\d{2})(\d{5})(\d{4})/', '(\1) \2-\3', $row['telefone']);
                } elseif (strlen($row['telefone']) === 10) {
                    // Formato para telefone fixo com DDD: (XX) XXXX-XXXX
                    $telefoneMascara = preg_replace('/(\d{2})(\d{4})(\d{4})/', '(\1) \2-\3', $row['telefone']);
                }

                if ($row['status'] != "Arquivado") {
                    echo "<div>";
                        echo "<div class='card border border-dark-subtle'>";
                            echo "<div class='card-body'>";
                                echo "<div class='hstack gap-3'>";
                                
                                    echo "<div>";
                                        echo "<div class='p-2 bg-success-subtle rounded'>Titulo:</div>";
                                        echo "<div class='p-2 bg-secondary-subtle rounded' style='width: 200px;'><a href='visualizacaoDetalhada.php?id_publicacao=" . $row['idpub'] . "' class='link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'>" . $row['titulo'] . "</a></div>";
                                    echo "</div>";

                                    echo "<div>";
                                        echo "<div class='p-2 bg-success-subtle rounded'>Nome Completo</div>";
                                        echo "<input type='text' name='nomeCompleto' class='form-control rounded' id='nomeCompleto' value='" . $row['nome'] . "' disabled>";
                                    echo "</div> ";

                                    echo "<div>";
                                        echo "<div class='p-2 bg-success-subtle rounded'>Contato:</div>";
                                        echo "<input type='text' name='telefone' class='form-control rounded' id='telefone' value='" . $telefoneMascara . "' disabled>";
                                    echo "</div>";

                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                } else {
                    echo "<div>";
                        echo "<div class='card border border-dark-subtle'>";
                            echo "<div class='card-body'>";
                                echo "<div class='hstack gap-3'>";
                                
                                    echo "<div>";
                                        echo "<div class='p-2 bg-success-subtle rounded'>A publicação com título <I>" . $row['titulo'] . "</I> foi arquivada.</br>Se desejar publicá-la novamente, acesse a aba <I>Arquivados</I> e edite-a.</div>";                                        
                                    echo "</div>";

                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
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