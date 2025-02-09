<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.php");
}
?>
<?php
require_once("conexao.php");
if ($_SERVER['REQUEST_METHOD']=='DELETE') {
   //print("<h1>_DELETE</h1>");
   // busca a string JSON
   $plainData = file_get_contents('php://input');
   // converter json em um objeto
   $object = json_decode($plainData);
   //print_r($object);
   // converte json em um array
   $array = json_decode($plainData,true);
   //print_r(($array));

   // Valida se os dados necessários estão no JSON
   if (isset($array['idPublicacao']) && isset($array['email']) && isset($array['fotoDelete'])) {
        $idPublicacao = $array['idPublicacao'];
        $email = $array['email'];
        $fotoDelete = $array['fotoDelete'];

        // Verifica conexão
        if ($conn->connect_error) {
            die(json_encode(["success" => false, "message" => "Erro de conexão: " . $conn->connect_error]));
        }

        //apaga a foto na pasta
        if(!empty($fotoDelete)) {
            $caminhoFotoDelete = './foto' . '/' . $fotoDelete;
            //print_r($caminhoFotoDelete);
            if (file_exists($caminhoFotoDelete)){
                unlink($caminhoFotoDelete);
            }
        }

        // Query de delete
        $sql = "DELETE FROM publicacao WHERE id_publicacao = ? AND usuario_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $idPublicacao, $email);

        // Executa o DELETE
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Registro deletado com sucesso."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao deletar o registro."]);
        }

        $stmt->close();
        $conn->close();

        //envia a resposta para o javascript para a mudança de página
        echo json_encode("response");
    } else {
        // Retorna erro se o ID não foi enviado
        echo json_encode(["success" => false, "message" => "ID não enviado no JSON."]);
    }
}
?>