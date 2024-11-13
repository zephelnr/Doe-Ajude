<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.php");
}
?>
<?php
if ($_SERVER['REQUEST_METHOD']==='GET') {
    try {
        //code...
        //print("<h1>_GET</h1>");
        //print_r($_GET);
        //print_r(htmlspecialchars($email = $_GET['email']));
        //print("<h1>_GET</h1>");
        //$email = htmlspecialchars($_GET['email']);
        //print_r($email);
        
    
        // Conectar ao banco de dados MySQL
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mydb";
    
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
                //echo "<h4>" . $row['senha'] . "</h4><br>"
            } else {
                throw new Exception("Nenhum usuário encontrado com esse email.");
            }
        } else {
            throw new Exception("Por favor, informe um email de usuário.");
        }
    
        // Fechar a conexão com o banco de dados
        $conn->close();
    } catch (Exception $e) {
        //throw $th;
        //echo json_encode(["Erro!" . $e->getMessage()]);
        //print_r(["Erro!" . $e->getMessage()]);
    } finally {
        $conn = null;
    }
    
 }
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Perfil</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                            <a class="nav-link active" aria-current="page" href="perfil.php">Perfil</a>
                            <a class="nav-link" href="#">Publicação</a>
                            <a class="nav-link disabled" aria-disabled="true">Interesses</a>
                            <a class="nav-link disabled" aria-disabled="true">Interessados</a>
                        </div>
                    </div>
                   
                    <!--<div class="d-grid gap-5 d-md-flex justify-content-md-center">
                        <a class="navbar-brand" href="telaPrincipal.php">Doe&Ajude</a>
                        <a class="btn btn-success rounded-pill" href="perfil.php" role="button">Perfil</a>
                        <a class="btn btn-success rounded-pill" href="publicacao.php" role="button">Publicação</a>
                        <a class="btn btn-success rounded-pill" href="interesse.php" role="button">Interesses</a>
                        <a class="btn btn-success rounded-pill" href="interessado.php" role="button">Interessados</a>
                    </div>-->
                    <a class="btn btn-success rounded-pill" href="logout.php" role="button">Sair</a>
                </div>
            </nav>
        </header>
        <main>
            <div class="container vstack gap-5 p-5"> 
                <div class="row p-5">
                    <div class="col-4 p-3 mb-2 offset-md-4 bg-success-subtle rounded-3">
                        <h2 class="mb-3 text-center">Perfil</h2>
                        
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control rounded-pill" id="email" value="<?= $_SESSION['email']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" name="cpf" class="form-control rounded-pill" id="cpf">
                            </div>
                            <div class="mb-3">
                                <label for="nomeCompleto" class="form-label">Nome Completo</label>
                                <input type="text" name="nomeCompleto" class="form-control rounded-pill" id="nomeCompleto">
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" name="senha" id="senha" class="form-control rounded-pill">
                            </div>
                            <div class="mb-3 d-grid gap-5 d-md-flex justify-content-md-center">
                                <button class="btn btn-success rounded-pill" type="button" id="btnEditar">Editar</button>
                            </div>                         
                        
                    </div>    
                </div>    
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
        <script src="js/perfil.js"></script>
    </body>
</html>
