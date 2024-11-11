<?php
//require("conexao.php");

//print("REQUEST_METHOD = ".$_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD']=='GET') {
   print("<h1>_GET</h1>");
   print_r($_GET);
   
/*
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
        
        // Consultar o banco de dados para pegar os dados do usuário
        $sql = "SELECT * FROM usuarios WHERE id = $email";
        $result = $conn->query($sql);

        // Verificar se o usuário existe
        if ($result->num_rows > 0) {
            // Exibir os dados do usuário
            $row = $result->fetch_assoc();
            echo "<h1>Informações do Usuário</h1>";
            echo "email: " . $row['email'] . "<br>";
            echo "cpf: " . $row['cpf'] . "<br>";
            echo "nomeCompleto: " . $row['nomeCompleto'] . "<br>";
        } else {
            echo "Nenhum usuário encontrado com esse email.";
        }
    } else {
        echo "Por favor, informe um email de usuário.";
    }

    // Fechar a conexão com o banco de dados
    $conn->close();*/
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
   $object = json_decode($plainData);
   print_r($object);
   // converte json em um array associativo
   parse_str($plainData,$array);
   // em seguida criar a instrução SQL para fazer o UPDATE no banco
   
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

