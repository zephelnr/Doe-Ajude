<?php
require_once("conexao.php");

//print("REQUEST_METHOD = ".$_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD']=='POST') {
    try {        
        // Coleta os dados enviados pelo FormData
        $email = $_POST['email'] ?? '';
        $id_publicacao = $_POST['idPublicacao'] ?? '';        
      
        // Verifica se todos os campos foram enviados corretamente
        if (!empty($email) && !empty($id_publicacao)) {
            print_r("entrou $id_publicacao $email entrou");
            // Cria um array associativo com os dados recebidos
            $dados = array(
                "usuario_email" => $email,
                "publicacao_id_publicacao" => $id_publicacao
            );
      
            // Converte o array em JSON
            $jsonData = json_encode($dados);
      
            // Prepara a consulta SQL para inserir os dados
            $sql = "INSERT INTO interesse (usuario_email, publicacao_id_publicacao) VALUES (?, ?)";
      
            // Prepara a declaração e vincula os parâmetros
            if ($stmt = $conn->prepare($sql)) {
                // Usa "ssss" porque os campos são strings
                $stmt->bind_param("ss", $email, $id_publicacao);
      
                // Executa a inserção
                if ($stmt->execute()) {
                    // Retorna uma resposta de sucesso
                    echo json_encode(["status" => "success", "message" => "Dados inseridos com sucesso!"]);
                } else {
                    // Retorna uma resposta de erro se falhar
                    //throw new Exception("Erro ao inserir os dados" . $stmt->error);
                    echo json_encode(["status" => "error", "message" => "Erro ao inserir os dados: " . $stmt->error]);
                }
                
                // Fecha a declaração
                $stmt->close();
            } else {
                //throw new Exception("Erro ao preparar a consulta" . $conn->error);
                echo json_encode(["status" => "error", "message" => "Erro ao preparar a consulta: " . $conn->error]);
            }
            
            // Fecha a conexão
            $conn->close();
        } else {
            //verifica se os campos estão vazios e manda um aviso
            if (empty($email)) {
                echo json_encode(["Email vazio"]);
            }
            if (empty($id_publicacao)) {
                echo json_encode(["IdPublicacao vazio"]);
            }

            // Retorna um erro se algum campo estiver vazio
            //echo json_encode(["status" => "error", "message" => "Todos os campos sao obrigatorios!"]);
            throw new Exception("Todos os campos sao obrigatorios!");
        }
        //header("Location: login.php");
        echo json_encode("response");
    } catch (Exception $e) {
        echo json_encode(["Erro! " . $e->getMessage()]);
    } finally {
        $conn = null;
    }
}
?>