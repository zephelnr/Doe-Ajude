<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.php");
}
?>
<?php
require_once("conexao.php");
if ($_SERVER['REQUEST_METHOD']=='DELETE') {
   print("<h1>_DELETE</h1>");
   // busca a string JSON
   $plainData = file_get_contents('php://input');
   // converter json em um objeto
   $object = json_decode($plainData);
   print_r($object);
   // converte json em um array
   $array = json_decode($plainData,true);
   print_r(($array));

   // Valida se os dados necessários estão no JSON
   if (isset($array['idPublicacao'])) {
        $idPublicacao = $array['idPublicacao'];
        //$idPublicacao = intval($array['idPublicacao']); // Converte o ID para inteiro

        // Conexão com o banco
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica conexão
        if ($conn->connect_error) {
            die(json_encode(["success" => false, "message" => "Erro de conexão: " . $conn->connect_error]));
        }

        // Query de delete
        $sql = "DELETE FROM publicacao WHERE idpublicacao = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $idPublicacao);

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