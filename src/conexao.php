<?php
// Conectar ao banco de dados MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

try {
    // Cria a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (PDOException $e) {
    die(json_encode(["status" => "error", "message" => "Falha na conexão: " . $conn->connect_error]));
}
?>