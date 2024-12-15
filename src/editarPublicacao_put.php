<?php
require_once("conexao.php");
if ($_SERVER['REQUEST_METHOD']=='PUT') {
    //print("<h1>_PUT</h1>");
    $plainData = file_get_contents('php://input');
    // converter json em um objeto
    $object = json_decode($plainData,true);
    //print_r($object);
    // converte json em um array associativo
    parse_str($plainData,$array);
    // em seguida criar a instrução SQL para fazer o UPDATE no banco
    //print_r($array);
    // Verifica se os dados necessários foram enviados
    //print_r($plainData);
    if (isset($object['email']) && isset($object['idPublicacao'])) {
         $idPublicacao= $object['idPublicacao'];        
         $usuario_email = $object['email'];
         $campo1 = $object['campo1'];
         $titulo = $object['titulo'];
         $campo2 = $object['campo2'];
         $descricao = $object['descricao'];
         $campo3 = $object['campo3'];
         $cidade = $object['cidade'];
         $campo4 = $object['campo4'];
         $estado= $object['estado'];
         $campo5 = $object['campo5'];
         $telefone = $object['telefone'];
         $campo6 = $object['campo6'];
         //$foto = $object['foto'];
         $foto = null;
         $status = $object['status'];
 
         // Conexão com o banco de dados usando MySQLi
         $conn = new mysqli($servername, $username, $password, $dbname);
 
         // Verifica se a conexão foi bem-sucedida
         if ($conn->connect_error) {
             echo json_encode(['status' => 'error', 'message' => 'Erro na conexão com o banco de dados: ' . $conn->connect_error]);
             exit;
         }
 
         // Prepara a consulta SQL
         $sql = "UPDATE publicacao SET `$campo1` = ?, `$campo2` = ?, `$campo3` = ?, `$campo4` = ?, `$campo5` = ?, `$campo6` = ?, `status` = ?, `data` = NOW() WHERE idpublicacao = ? AND usuario_email = ?";
         $stmt = $conn->prepare($sql);
 
         if ($stmt) {
             // Vincula os parâmetros
             $stmt->bind_param('sssssssss', $titulo, $descricao, $cidade, $estado, $telefone, $foto, $status, $idPublicacao, $usuario_email);
 
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
?>