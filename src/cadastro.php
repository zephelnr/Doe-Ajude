<?php
session_start();
if (!empty($_SESSION['email'])) {
   header("Location: telaPrincipal.php");
}
?>
<?php
require_once("conexao.php");

//print("REQUEST_METHOD = ".$_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD']=='POST') {
    try {
        // Coleta os dados enviados pelo FormData
        $email = $_POST['email'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $nomeCompleto = $_POST['nomeCompleto'] ?? '';
        $senha = $_POST['senha'] ?? '';
      
        // Verifica se todos os campos foram enviados corretamente
        if (!empty($email) && !empty($cpf) && !empty($nomeCompleto) && !empty($senha)) {
            // Cria um array associativo com os dados recebidos
            $dados = array(
                "email" => $email,
                "cpf" => $cpf,
                "nomeCompleto" => $nomeCompleto,
                "senha" => $senha
            );
      
            // Converte o array em JSON
            $jsonData = json_encode($dados);
      
            // Criptografa a senha
            //$senha = password_hash($senha, PASSWORD_BCRYPT);
      
            // Prepara a consulta SQL para inserir os dados
            $sql = "INSERT INTO usuario (email, cpf, nomeCompleto, senha) VALUES (?, ?, ?, ?)";
      
            // Prepara a declaração e vincula os parâmetros
            if ($stmt = $conn->prepare($sql)) {
                // Usa "ssss" porque os campos são strings
                $stmt->bind_param("ssss", $email, $cpf, $nomeCompleto, $senha);
      
                // Executa a inserção
                if ($stmt->execute()) {
                    // Retorna uma resposta de sucesso
                    echo json_encode(["status" => "success", "message" => "Dados inseridos com sucesso!"]);
                } else {
                    // Retorna uma resposta de erro se falhar
                    throw new Exception("Erro ao inserir os dados" . $stmt->error);
                    //echo json_encode(["status" => "error", "message" => "Erro ao inserir os dados: " . $stmt->error]);
                }
                
                // Fecha a declaração
                $stmt->close();
            } else {
                throw new Exception("Erro ao preparar a consulta" . $conn->error);
                //echo json_encode(["status" => "error", "message" => "Erro ao preparar a consulta: " . $conn->error]);
            }
            
            // Fecha a conexão
            $conn->close();
        } else {
            //verifica se os campos estão vazios e manda um aviso
            if (empty($email)) {
                echo json_encode(["Email vazio"]);
            }
            if (empty($cpf)) {
                echo json_encode(["Cpf vazio"]);
            }
            if (empty($nomeCompleto)) {
                echo json_encode(["NomeCompleto vazio"]);
            }
            if (empty($senha)) {
                echo json_encode(["Senha vazia"]);
            }

            // Retorna um erro se algum campo estiver vazio
            //echo json_encode(["status" => "error", "message" => "Todos os campos sao obrigatorios!"]);
            throw new Exception("Todos os campos sao obrigatorios!");
        }
        //header("Location: login.php");
        echo json_encode("response");
    } catch (Exception $e) {
        echo json_encode(["Erro! " . $e->getMessage()]);
    }
   

}
?>

<!doctype html>
<html lang="pt-br">
    <head>
        <title>Cadastro</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <header>
            <!-- place navbar here -->
            <nav class="navbar bg-body-tertiary bg-success-subtle">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">Doe&Ajude</a>
                </div>
            </nav>
        </header>
        <main>
            <div class="container vstack gap-5 p-5"> 
                <div class="row p-5">
                    <div class="col-4 p-3 mb-2 offset-md-4 bg-success-subtle rounded-3">
                        <h2 class="mb-3 text-center">Cadastro de usuário</h2>
                        <form id="frmCadastrar" action="" class="" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control rounded-pill" id="email" placeholder="Digite o seu e-mail" autofocus required>
                                <p id="respEmailCad"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" name="cpf" class="form-control rounded-pill" id="cpf" placeholder="Digite o seu CPF(Apenas números)" required>
                                <p id="respCpfCad"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="nomeCompleto" class="form-label">Nome Completo</label>
                                <input type="text" name="nomeCompleto" class="form-control rounded-pill" id="nomeCompleto" placeholder="Digite o seu nome completo" required>
                                <p id="respNomeCompletoCad"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" name="senha" id="senha" class="form-control rounded-pill" aria-describedby="blocoAjudaSenha" placeholder="Digite uma senha" required>
                                <p id="respSenhaCad"></p> 
                                <div id="blocoAjudaSenha" class="form-text">
                                    Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                                </div>
                            </div>
                            <div class="mb-3 d-grid gap-5 d-md-flex justify-content-md-center">
                                <a class="btn btn-success rounded-pill" href="login.php" role="button">Já Tenho Cadastro</a>
                                <button class="btn btn-success rounded-pill" type="button" id="btnCadastrar">Cadastrar</button>
                            </div>                         
                        </form>
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
        <script src="js/cadastro.js"></script>
        <script src="js/sha256.min.js"></script>
    </body>
</html>