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
    print_r($plainData);
    if (isset($object['idPublicacao']) && isset($object['status']) && isset($object['email'])) {
         $idPublicacao= $object['idPublicacao'];        
         $status = $object['status'];
         $usuario_email = $object['email'];
 
         // Verifica se a conexão foi bem-sucedida
         if ($conn->connect_error) {
             echo json_encode(['status' => 'error', 'message' => 'Erro na conexão com o banco de dados: ' . $conn->connect_error]);
             exit;
         }
 
         // Prepara a consulta SQL
         $sql = "UPDATE publicacao SET `status` = ?, `data` = NOW() WHERE id_publicacao = ? AND usuario_email = ?";
         $stmt = $conn->prepare($sql);
 
         if ($stmt) {
             // Vincula os parâmetros
             $stmt->bind_param('sss', $status, $idPublicacao, $usuario_email);
 
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

         //envia a resposta para o javascript para a mudança de página
         echo json_encode("response");
     } else {
         echo json_encode(['status' => 'error', 'message' => 'Dados inválidos ou incompletos.']);
     }
 
    
    
 }
?>