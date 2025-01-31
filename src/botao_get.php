<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.php");
}
?>
<?php
if ($_SERVER['REQUEST_METHOD']=='GET') {
    try {    
        // Verificar se o parâmetro 'email' foi passado via GET
        if (isset($_GET['botao'])) {
            $botao = $_GET['botao'];
            //print_r("botao$botao");
            echo "<button class='btn btn-success rounded-pill' type='button' id='btn" . $botao . "Interesse'>" . $botao . " Interesse</button>";
        } else {
            throw new Exception("Nenhuma Publicação encontrada");
        } 
    } catch (Exception $e) {
        //throw $e;
        echo json_encode(["Erro!" . $e->getMessage()]);
        //print_r(["Erro!" . $e->getMessage()]);
    } finally {
        $conn = null;
    }
    
 }
?>