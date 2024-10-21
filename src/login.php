<?php
ini_set("session.cookie_secure", 1);
session_start();
?>
<?php
require_once("conexao.php");
//verificando se é uma requisição post para efetuar o login
if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    try {
        $email = filter_input(INPUT_POST, "email");
        $senha = filter_input(INPUT_POST, "senha");
        //$email = $_POST['email'] ?? '';
        //$senha = $_POST['senha'] ?? '';

        $sql = "select * from usuario where email = ?";

        $conn = new PDO("mysql:host=" . $servername. ";dbname=" . $dbname, $username, $password);
        //$DSN = "mysql:dbname=mydb;host=localhost";

        $pre = $conn->prepare($sql);
        $pre->execute(array(
            $email
        ));

        $resultado = $pre->fetch();

        if (!$resultado) {
            throw new Exception("Login invalido!");
        } else {
            //$senha = password_hash($senha, PASSWORD_BCRYPT, ['cost' => 12]);
            //error_log("\n senha: '$senha''", 3, "../file.log");
            if (password_verify($senha, $resultado["senha"]) === false) {
                throw new Exception("Senha invalida!");
            } else {
                $_SESSION["usuario"] = $resultado["email"];
            }
        }
        

        header("Location: telaPrincipal.html");
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Erro geral!" . $e->getMessage()]);
    } finally {
        $conexao = null;
    }
}


?>