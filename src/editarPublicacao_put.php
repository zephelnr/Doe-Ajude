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
    if (isset($object['email']) && isset($object['idPublicacao']) && !empty($object['titulo']) && !empty($object['descricao']) && !empty($object['cidade']) && !empty($object['estado']) && !empty($object['telefone'])) {
         $idPublicacao= $object['idPublicacao'];        
         $usuario_email = $object['email'];
         $campoTitulo = $object['campoTitulo'];
         $titulo = $object['titulo'];
         $campoDescricao = $object['campoDescricao'];
         $descricao = $object['descricao'];
         $campoCidade = $object['campoCidade'];
         $cidade = $object['cidade'];
         $campoEstado = $object['campoEstado'];
         $estado= $object['estado'];
         $campoTelefone = $object['campoTelefone'];
         $telefone = $object['telefone'];
         $campoFoto = $object['campoFoto'];
         $foto = $object['foto'];
         //$foto = '';
         $status = $object['status'];
 
         // Conexão com o banco de dados usando MySQLi
         $conn = new mysqli($servername, $username, $password, $dbname);
 
         // Verifica se a conexão foi bem-sucedida
         if ($conn->connect_error) {
             echo json_encode(['status' => 'error', 'message' => 'Erro na conexão com o banco de dados: ' . $conn->connect_error]);
             exit;
         }
 
         // Prepara a consulta SQL
         $sql = "UPDATE publicacao SET `$campoTitulo` = ?, `$campoDescricao` = ?, `$campoCidade` = ?, `$campoEstado` = ?, `$campoTelefone` = ?, `$campoFoto` = ?, `status` = ?, `data` = NOW() WHERE idpublicacao = ? AND usuario_email = ?";
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

         //envia a resposta para o javascript para a mudança de página
         echo json_encode("response");
     } else {
         echo json_encode(['status' => 'error', 'message' => 'Dados inválidos ou incompletos.']);
     }
 
    
    
 }
?>