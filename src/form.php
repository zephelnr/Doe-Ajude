<?php
//require("conexao.php");

//print("REQUEST_METHOD = ".$_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD']=='GET') {
   print("<h1>_GET</h1>");
   print_r($_GET);
}
elseif ($_SERVER['REQUEST_METHOD']=='POST') {
   
   // Recebe o JSON (por exemplo, de uma solicitação POST)
   $plainData = file_get_contents('php://input');

   // Decodifica o JSON para um array associativo
   $array = json_decode($plainData, true);

   // Verifica se o JSON foi decodificado corretamente
   if (json_last_error() === JSON_ERROR_NONE) {
      // Dados extraídos do JSON
      $email = $dados['email'];
      $cpf = $dados['cpf'];
      $nomeCompleto = $dados['nomeCompleto'];
      $senha = $dados['senha'];
      
      // Conectar ao banco de dados MySQL
      $servername = "localhost";  // Exemplo: localhost
      $username = "root";      // Seu usuário do banco
      $password = "";        // Sua senha do banco
      $dbname = "mydb";       // Nome do seu banco de dados

      // Cria a conexão
      $conn = new mysqli($servername, $username, $password, $dbname, 3306);

      // Verifica se a conexão foi bem-sucedida
      if ($conn->connect_error) {
         die("Falha na conexão: " . $conn->connect_error);
      }

      // Prepara a consulta SQL para inserir os dados
      $sql = "INSERT INTO usuario (email, cpf, nomeCompleto, senha) VALUES (?, ?, ?, ?)";

      // Prepara a declaração (statement) e vincula os parâmetros
      if ($stmt = $conn->prepare($sql)) {
         $stmt->bind_param("ssss", $email, $cpf, $nomeCompleto, $senha);

         // Executa a inserção
         if ($stmt->execute()) {
               echo "Dados inseridos com sucesso!";
         } else {
               echo "Erro ao inserir os dados: " . $stmt->error;
         }

         // Fecha a declaração
         $stmt->close();
      } else {
         echo "Erro ao preparar a consulta: " . $conn->error;
      }

      // Fecha a conexão
      $conn->close();
   } else {
      echo "Erro ao decodificar JSON: " . json_last_error_msg();
   }


   //print("<h1>_POST</h1>");
   print_r($_POST);
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

