<?php
session_start();
if (!empty($_SESSION['email'])) {
   header("Location: menu.php");
}
?>
<?php
require_once("conexao.php");

//print("REQUEST_METHOD = ".$_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD']=='POST') {
    try {
        // Coleta os dados enviados pelo FormData
        $email = $_POST['email'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $nomeCompleto = $_POST['nomeCompleto'] ?? '';
        $senha = $_POST['senha'] ?? '';
      
        // Verifica se todos os campos foram enviados corretamente
        if (!empty($email) && !empty($cpf) && !empty($nomeCompleto) && !empty($senha)) {
            // Cria um array associativo com os dados recebidos
            $dados = array(
                "email" => $email,
                "cpf" => $cpf,
                "nomeCompleto" => $nomeCompleto,
                "senha" => $senha
            );
      
            // Converte o array em JSON
            $jsonData = json_encode($dados);
      
            // Criptografa a senha
            //$senha = password_hash($senha, PASSWORD_BCRYPT);
      
            // Prepara a consulta SQL para inserir os dados
            $sql = "INSERT INTO usuario (email, cpf, nomeCompleto, senha) VALUES (?, ?, ?, ?)";
      
            // Prepara a declaração e vincula os parâmetros
            if ($stmt = $conn->prepare($sql)) {
                // Usa "ssss" porque os campos são strings
                $stmt->bind_param("ssss", $email, $cpf, $nomeCompleto, $senha);
      
                // Executa a inserção
                if ($stmt->execute()) {
                    // Retorna uma resposta de sucesso
                    echo json_encode(["status" => "success", "message" => "Dados inseridos com sucesso!"]);
                } else {
                    // Retorna uma resposta de erro se falhar
                    throw new Exception("Erro ao inserir os dados" . $stmt->error);
                    //echo json_encode(["status" => "error", "message" => "Erro ao inserir os dados: " . $stmt->error]);
                }
                
                // Fecha a declaração
                $stmt->close();
            } else {
                throw new Exception("Erro ao preparar a consulta" . $conn->error);
                //echo json_encode(["status" => "error", "message" => "Erro ao preparar a consulta: " . $conn->error]);
            }
            
            // Fecha a conexão
            $conn->close();
        } else {
            //verifica se os campos estão vazios e manda um aviso
            if (empty($email)) {
                echo json_encode(["Email vazio"]);
            }
            if (empty($cpf)) {
                echo json_encode(["Cpf vazio"]);
            }
            if (empty($nomeCompleto)) {
                echo json_encode(["NomeCompleto vazio"]);
            }
            if (empty($senha)) {
                echo json_encode(["Senha vazia"]);
            }

            // Retorna um erro se algum campo estiver vazio
            //echo json_encode(["status" => "error", "message" => "Todos os campos sao obrigatorios!"]);
            throw new Exception("Todos os campos sao obrigatorios!");
        }
        //header("Location: login.html");
        echo json_encode("response");
    } catch (Exception $e) {
        echo json_encode(["Erro! " . $e->getMessage()]);
    }
   

}


