<?php
session_start()
?>
<?php
require_once("conexao.php");
if(filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST"){
    try{
        $dados = [];

        $cpf = filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_NUMBER_INT);
        if(!$cpf){    
        }
        $dados["cpf"] = $cpf;

        $nomeCompleto = filter_input(INPUT_POST, "nomeCompleto");
        if(!$nomeCompleto){}
        $dados["nomeCompleto"] = $nomeCompleto;

        $usuario = filter_input(INPUT_POST, "usuario");
        if(!$usuario){
        }
        $dados["usuario"] = $usuario;

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        if(!$email){}
        $dados["email"] = $email;

        $senha = filter_input(INPUT_POST, "senha");
        if(!$senha){}
        $dados["senha"] = $senha;

        $_SESSION["dados"] = $dados;
        $conexao = new PDO("mysql:host=" . SERVIDOR . ";bdname=" . BANCO, USUARIO, SENHA);

        $sql = "SELECT * FROM usuario WHERE usuario = ?";
        $pre = $conexao->prepare($sql);
        $pre->execute(array(
            $usuario
        ));
        $resultado = $pre->fetch();
        if($resultado){
            throw new Exception("Usuario já cadastrado!");
        }
        $senha = password_hash($senha, PASSWORD_BCRYPT, ['cost' => 12]);
        
        $sql = "INSERT INTO usuario(cpf, nomeCompleto, usuario, senha, email) VALUES (?,?,?,?,?)";

        $pre = $conexao->prepare($sql);
        $pre->execute(array(
            $cpf,
            $nomeCompleto,
            $usuario,
            $email,
            $senha
        ));

        header("HTTP 1/1 302 Redirect");
        header("Location: login.php");
    } catch(Exception $e){

    } finally {
        $conexao = null;
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
        <link rel="stylesheet" href="/src/css/style.css">
        <link rel="stylesheet" href="/src/scss/_utilities.scss">
    </head>

    <body>
        <header>
            <!-- place navbar here -->
            <nav class="navbar bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="paginaPrincipal.php">Doe&Ajude</a>
                </div>
            </nav>
        </header>
        <main>
            <div class="container vstack gap-5 p-5"> 
                <div class="row p-5">
                    <div class="col-4 p-3 mb-2 offset-md-4 bg-success-subtle rounded-3">
                        <h2 class="mb-3 text-center">Cadastro de usuário</h2>
                        <form id="cadastroUsuario" action="cadastro.php" method="$_POST" class="">
                                <div class="mb-3">
                                    <label for="usuario" class="form-label">Usuário</label>
                                    <input type="text" class="form-control rounded-pill" id="usuario" placeholder="Digite um usuário" value="<?php echo isset($_SESSION['dados']['usuario']) ? $_SESSION['dados']['usuario'] : '' ?>" required>    
                                </div>
                                <div class="mb-3">
                                    <label for="nomeCompleto" class="form-label">Nome Completo</label>
                                    <input type="text" class="form-control rounded-pill" id="nomeCompleto" placeholder="Digite o seu nome completo" value="<?php echo isset($_SESSION['dados']['nomeCompleto']) ? $_SESSION['dados']['nomeCompleto'] : '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input type="text" class="form-control rounded-pill" id="cpf" placeholder="Digite o seu CPF(Apenas números)" value="<?php echo isset($_SESSION['dados']['cpf']) ? $_SESSION['dados']['cpf'] : '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control rounded-pill" id="email" placeholder="Digite o seu e-mail" value="<?php echo isset($_SESSION['dados']['email']) ? $_SESSION['dados']['email'] : '' ?>" required>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected></option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="cidade" class="form-label">Cidade</label>   
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected></option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control rounded-pill" id="telefone" placeholder="Digite o seu telefone(Apenas números)">
                                </div>
                                <div class="mb-3">
                                    <label for="senha" class="form-label">Senha</label>
                                    <input type="password" id="senha" class="form-control rounded-pill" aria-describedby="blocoAjudaSenha" placeholder="Digite uma senha" value="<?php echo isset($_SESSION['dados']['senha']) ? $_SESSION['dados']['senha'] : '' ?>" required>
                                        <div id="blocoAjudaSenha" class="form-text">
                                        Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                                    </div>
                                </div>
                                <div class="mb-3 d-grid gap-5 d-md-flex justify-content-md-center">
                                    <a class="btn btn-success rounded-pill" href="login.php" role="button">Já Tenho Cadastro</a>
                                    <button class="btn btn-success rounded-pill" type="submit">Cadastrar</button>
                                </div>                         
                        </form>
                        <?php
                        unset($_SESSION["dados"]);
                        ?>
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
    </body>
</html>
