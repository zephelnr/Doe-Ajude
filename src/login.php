<?php
session_start();
if (!empty($_SESSION['email'])) {
   header("Location: index.html");
}
?>
<?php
require_once("conexao.php");
//verificando se é uma requisição post para efetuar o login
if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    try {
        //$email = filter_input(INPUT_POST, "email");
        //$senha = filter_input(INPUT_POST, "senha");
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $sql = "select * from usuario where email = ?";

        $conn = new PDO("mysql:host=" . $servername. ";dbname=" . $dbname, $username, $password);

        $pre = $conn->prepare($sql);
        $pre->execute(array(
            $email
        ));

        $resultado = $pre->fetch();

        if (!$resultado) {
            throw new Exception("Email invalido!");
        } else {
            if ($senha === $resultado["senha"]) { //password_verify($senha, $resultado["senha"]) === false
                //throw new Exception("Senha invalida!");
                $_SESSION["email"] = $resultado["email"];
                //echo json_encode($_SESSION["email"]);
            } else {
                //$_SESSION["email"] = $resultado["email"];
                throw new Exception("Senha invalida!");
            }
        }
        
        //header("Location: telaPrincipal.html");
        echo json_encode("response");
    } catch (Exception $e) {
        echo json_encode(["Erro!" . $e->getMessage()]);
    } finally {
        $conexao = null;
    }
}


?>