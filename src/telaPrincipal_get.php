<?php
require_once("conexao.php");
if ($_SERVER['REQUEST_METHOD']=='GET') {
    try {
         // Obtém o parâmetro de busca
         $titulo = isset($_GET['titulo']) ? trim($_GET['titulo']) : '';

         // Verificar se o parâmetro de busca contendo o 'titulo' foi passado via GET
         if (!empty($titulo)) {
             // Consulta ao banco de dados
             $stmt = $conn->prepare("SELECT * FROM publicacao WHERE (`status` = 'Publicado' OR `status` = 'Editado') AND titulo LIKE ? ORDER BY `data` DESC");
             
             // Adiciona os curingas para a pesquisa
             $buscaTitulo = "%$titulo%";
             
             // Associa o parâmetro ao placeholder
             $stmt->bind_param("s", $buscaTitulo);
             
             // Executa a consulta
             $stmt->execute();
             
             // Obtém o resultado
             $result = $stmt->get_result();
         } else {
            // Consultar o banco de dados para pegar os dados da publicação
            $sql = "SELECT * FROM publicacao WHERE  `status` = 'Publicado' OR `status` = 'Editado' ORDER BY `data` DESC";
            $result = $conn->query($sql);
         }
       
        //verifica se o número de linhas do resultado é maior que zero, e se for, executa o código
        if ($result->num_rows > 0) {
            
            while ($row = $result->fetch_assoc()) {
                // Converte e formata a data
                $data = new DateTime($row['data']);
                $dataFormatada = $data->format('d/m/Y');
                
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
                                    echo "<button type='button' class='btn btn-sm btn-outline-success'>Visualizar</button>";
                                    //echo "<button type='button' class='btn btn-sm btn-outline-success'>Editar</button>";
                                echo "</div>";
                                echo "<small class='text-muted'>" . $row['cidade'] . "</br>" . $row['estado'] . "</br>" . $row['status'] ." no dia: " .  $dataFormatada . "</small>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }
        } else if (!empty($titulo)){
            echo "<div class='container text-center' style='height: 450px;'>";
                echo "<div class='row'> ";
                    echo "<div class='col position-absolute top-50 start-50 translate-middle'><h6>Nenhuma publicação encontrada!</h6></div>";
                echo "</div>";
            echo "</div>";
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