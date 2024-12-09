<?php
//require("conexao.php");

//print("REQUEST_METHOD = ".$_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD']=='GET') {
   print("<h1>_GET</h1>");
   print_r($_GET);
   //print_r(htmlspecialchars($email = $_GET['email']));
   //print("<h1>_GET</h1>");
   //$email = htmlspecialchars($_GET['email']);
   //print_r($email);
   

    // Conectar ao banco de dados MySQL
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mydb";

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
        
        // Consultar o banco de dados para pegar os dados do usuário
        $sql = "SELECT * FROM usuario WHERE email = '$email'";
        $result = $conn->query($sql);

        // Verificar se o usuário existe
        if ($result->num_rows > 0) {
            // Exibir os dados do usuário
            $row = $result->fetch_assoc();
            echo "<h1>Informações do Usuário</h1>";
            echo "<p>email: " . $row['email'] . "<p><br>";
            echo "<h2>" . $row['cpf'] ."</h2><br>";
            echo "<h3>" . $row['nomeCompleto'] ."</h3><br>";
        } else {
            echo "Nenhum usuário encontrado com esse email.";
        }
    } else {
        echo "Por favor, informe um email de usuário.";
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
}
elseif ($_SERVER['REQUEST_METHOD']=='POST') {
   
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

      // Conectar ao banco de dados MySQL
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "mydb";

      // Cria a conexão
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Verifica se a conexão foi bem-sucedida
      if ($conn->connect_error) {
          die(json_encode(["status" => "error", "message" => "Falha na conexão: " . $conn->connect_error]));
      }

      // Criptografa a senha
      $senha = password_hash($senha, PASSWORD_BCRYPT);

      // Prepara a consulta SQL para inserir os dados
      $sql = "INSERT INTO usuario (email, cpf, nomeCompleto, senha) VALUES (?, ?, ?, ?)";

      // Prepara a declaração e vincula os parâmetros
      if ($stmt = $conn->prepare($sql)) {
          // Usa "siss" porque CPF é um inteiro, e os outros campos são strings
          $stmt->bind_param("siss", $email, $cpf, $nomeCompleto, $senha);

          // Executa a inserção
          if ($stmt->execute()) {
              // Retorna uma resposta de sucesso
              echo json_encode(["status" => "success", "message" => "Dados inseridos com sucesso!"]);
          } else {
              // Retorna uma resposta de erro se falhar
              echo json_encode(["status" => "error", "message" => "Erro ao inserir os dados: " . $stmt->error]);
          }
          
          // Fecha a declaração
          $stmt->close();
      } else {
          echo json_encode(["status" => "error", "message" => "Erro ao preparar a consulta: " . $conn->error]);
      }

      // Fecha a conexão
      $conn->close();
   } else {
      // Retorna um erro se algum campo estiver vazio
      echo json_encode(["status" => "error", "message" => "Todos os campos sao obrigatorios!"]);
   }

}
elseif ($_SERVER['REQUEST_METHOD']=='PUT') {
   print("<h1>_PUT</h1>");
   $plainData = file_get_contents('php://input');
   // converter json em um objeto
   $object = json_decode($plainData,true);
   print_r($object);
   // converte json em um array associativo
   parse_str($plainData,$array);
   // em seguida criar a instrução SQL para fazer o UPDATE no banco
   print_r($array);
   // Verifica se os dados necessários foram enviados
   print_r($plainData);
   if (isset($object['email']) && isset($object['nomeCompleto'])) {
        $email = $object['email'];
        $nomeCompleto = $object['nomeCompleto'];
        $campo = $object['campo'];


        // Verifica se o nome do campo é seguro
        /*$camposPermitidos = ['nomeCompleto']; // Liste os campos permitidos
        if (!in_array($campo, $camposPermitidos)) {
            echo json_encode(['status' => 'error', 'message' => 'Campo inválido.']);
            exit;
        }*/

        // Configurações do banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mydb";

        // Conexão com o banco de dados usando MySQLi
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica se a conexão foi bem-sucedida
        if ($conn->connect_error) {
            echo json_encode(['status' => 'error', 'message' => 'Erro na conexão com o banco de dados: ' . $conn->connect_error]);
            exit;
        }

        // Prepara a consulta SQL
        $sql = "UPDATE usuario SET `$campo` = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Vincula os parâmetros
            $stmt->bind_param('ss', $nomeCompleto, $email);

            // Executa a consulta
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Dados atualizados com sucesso!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar os dados: ' . $stmt->error]);
            }

            // Fecha a declaração
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao preparar a consulta: ' . $conn->error]);
        }

        // Fecha a conexão
        $conn->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados inválidos ou incompletos.']);
    }

   
   
}
elseif ($_SERVER['REQUEST_METHOD']=='DELETE') {
   print("<h1>_DELETE</h1>");
   // busca a string JSON
   $plainData = file_get_contents('php://input');
   // converter json em um objeto
   $object = json_decode($plainData);
   print_r($object);
   // converte json em um array
   $array = json_decode($plainData,true);
   print_r(($array));
}

