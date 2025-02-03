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
            $sql = "SELECT interesse.id_interesse AS idint, interesse.publicacao_id_publicacao AS pubidpub, publicacao.id_publicacao AS idpub, publicacao.titulo AS titulo, publicacao.telefone AS telefone, publicacao.status AS `status`, publicacao.data AS `data`, municipio.nome AS cidade, estado.sigla AS estado, usuario.nomeCompleto AS nome, usuario.cpf AS cpf FROM interesse LEFT JOIN publicacao ON interesse.publicacao_id_publicacao = publicacao.id_publicacao LEFT JOIN municipio ON publicacao.cidade = municipio.id_municipio LEFT JOIN estado ON publicacao.estado = estado.id_estado LEFT JOIN usuario ON usuario.email = publicacao.usuario_email WHERE interesse.usuario_email = '$usuario_email' ORDER BY `data` DESC";

            $result = $conn->query($sql);
        } else {
            throw new Exception("Nenhuma Publicação encontrada");
        }

        if ($result->num_rows > 0) {
            
            while ($row = $result->fetch_assoc()) {
                if ($row['pubidpub'] != NULL) {
                    if ($row['status'] != "Arquivado") {            
                        echo "<div>";
                            echo "<div class='card border border-dark-subtle'>";
                                echo "<div class='card-body'>";
                                    echo "<div class='hstack gap-3'>";

                                        echo "<form action='' method='post' id='frmDesfazerInteresse'><p><input type='hidden' name='idInteresse' id='idInteresse' value='" . $row['idint'] . "'></p></form>";
                                    
                                        echo "<div>";
                                            echo "<div class='p-2 bg-success-subtle rounded'><a href='visualizacaoDetalhada.php?id_publicacao=" . $row['idpub'] . "' class='link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'>Titulo:</a></div>";
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
                                            echo "<input type='text' name='localizacao' class='form-control rounded' id='localizacao' value='" . $row['cidade'] . " , " . $row['estado'] . "' disabled>";
                                        echo "</div>";

                                        echo "<div>";
                                            echo "<div class='p-2 bg-success-subtle rounded'>Contato:</div>";
                                            echo "<input type='text' name='telefone' class='form-control rounded' id='telefone' value='" . $row['telefone'] . "' disabled>";
                                        echo "</div>";

                                        echo "<div class='vr'></div>";
                                        echo "<div class='mb-3 d-grid gap-5 d-md-flex justify-content-md-left p-2'>";
                                            echo "<button class='btn btn-success rounded-pill' type='button' onclick='BotaoDesfazerInteresse(" . $row['idint'] . ")'>Desfazer Interesse</button>";
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

                                        echo "<form action='' method='post' id='frmDesfazerInteresse'><input type='hidden' name='idInteresse' id='idInteresse' value='" . $row['idint'] . "'></form>";
                                    
                                        echo "<div>";
                                            echo "<div class='p-2 bg-success-subtle rounded'>Publicação Arquivada!</div>";                                        
                                        echo "</div>";

                                        echo "<div class='vr'></div>";
                                        echo "<div class='mb-3 d-grid gap-5 d-md-flex justify-content-md-left p-2'>";                                            
                                            echo "<button class='btn btn-success rounded-pill' type='button' onclick='BotaoDesfazerInteresse(" . $row['idint'] . ")'>Desfazer Interesse</button>";                                            
                                        echo "</div>";

                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div>";
                        echo "<div class='card border border-dark-subtle'>";
                            echo "<div class='card-body'>";
                                echo "<div class='hstack gap-3'>";

                                echo "<form action='' method='post' id='frmDesfazerInteresse'><p><input type='hidden' name='idInteresse' id='idInteresse' value='" . $row['idint'] . "'></p></form>";
                                
                                    echo "<div>";
                                        echo "<div class='p-2 bg-success-subtle rounded'>Publicação Apagada!</div>";                                        
                                    echo "</div>";

                                    echo "<div class='vr'></div>";
                                    echo "<div class='mb-3 d-grid gap-5 d-md-flex justify-content-md-left p-2'>";
                                        echo "<button class='btn btn-success rounded-pill' type='button' onclick='BotaoDesfazerInteresse(" . $row['idint'] . ")'>Desfazer Interesse</button>";
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