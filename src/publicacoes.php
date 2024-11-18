<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.php");
}
?>
<?php
require_once("conexao.php");
if ($_SERVER['REQUEST_METHOD']=='GET') {
    try {   
        // Conectar ao banco de dados
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Verificar se a conexão foi bem-sucedida
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);   
        }
    
        // Verificar se o parâmetro 'email' foi passado via GET
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            //print_r($_GET['email']);
            
            // Consultar o banco de dados para pegar os dados do usuário
            $sql = "SELECT * FROM usuario WHERE email = '$email'";
            $result = $conn->query($sql);
    
            // Verificar se o usuário existe
            if ($result->num_rows > 0) {
                // Exibir os dados do usuário
                $row = $result->fetch_assoc();
                echo "<h1>Informações do Usuário</h1>";
                echo "<p>email: " . $row['email'] . "<p><br>";
                echo "<h2>" . $row['cpf'] ."</h2><br>";
                echo "<h3>" . $row['nomeCompleto'] ."</h3><br>";
                echo "<h4>" . $row['senha'] . "</h4><br>";
            } else {
                throw new Exception("Nenhum usuário encontrado com esse email.");
            }
        } else {
            //throw new Exception("Por favor, informe um email de usuário.");
        }
    
        // Fechar a conexão com o banco de dados
        $conn->close();
    } catch (Exception $e) {
        //throw $e;
        echo json_encode(["Erro!" . $e->getMessage()]);
        //print_r(["Erro!" . $e->getMessage()]);
    } finally {
        $conn = null;
    }
    
 }
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Publicações</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <style>
            /* CSS personalizado para definir o tamanho fixo da caixa */
            .fixed-size-box {
            width: 90vw;  /* Largura fixa de 250px */
            height: 70vh; /* Altura fixa de 150px */
            }
        </style>
    </head>

    <body>
        <header>
            <!-- place navbar here -->
            <nav class="navbar navbar-expand-lg bg-body-tertiary bg-success-subtle">
                <div class="container-fluid">

                    <a class="navbar-brand" href="telaPrincipal.php">Doe&Ajude</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link" href="perfil.php">Perfil</a>
                            <a class="nav-link active" aria-current="page" href="publicacoes.php">Publicações</a>
                            <a class="nav-link disabled" aria-disabled="true">Interesses</a>
                            <a class="nav-link disabled" aria-disabled="true">Interessados</a>
                        </div>
                    </div>
                    <a class="btn btn-success rounded-pill" href="logout.php" role="button">Sair</a>
                </div>
            </nav>
        </header>
        <main>
            <!--<div class="container vstack gap-5 p-5">
                <h2 class="mb-3 text-center">Publicações</h2>
                <div class="mb-3 d-grid gap-5 d-md-flex justify-content-md-left">
                    <a class="btn btn-success rounded-pill" href="cadastrarPublicacao.php" role="button">Nova Publicação</a>    
                </div>      
            </div>-->
            <h2 class="mb-3 text-center">Publicações</h2>
            <div class="mb-3 container d-flex">
                <!-- Caixa de tamanho fixo com classes Bootstrap -->
                <div class="fixed-size-box bg-success-subtle text-white d-flex rounded">
                    
                </div>
            </div>
            <div class="mb-3 d-grid gap-5 d-md-flex justify-content-md-center">
                <a class="btn btn-success rounded-pill" href="cadastrarPublicacao.php" role="button">Nova Publicação</a>    
            </div>
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="js/publicacoes.js"></script>
    </body>
</html>
