<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.php");
}
?>

<?php
require_once("conexao.php");

if ($_SERVER['REQUEST_METHOD']=='GET') {
    //print("<h1>_GET</h1>");
    //print_r($_GET);

 
     // Conectar ao banco de dados
     $conn = new mysqli($servername, $username, $password, $dbname);
 
     // Verificar se a conexão foi bem-sucedida
     if ($conn->connect_error) {
         die("Conexão falhou: " . $conn->connect_error);   
     }
 
     // Verificar se o parâmetro 'idpublicacao' foi passado via GET
     if (isset($_GET['idpublicacao'])) {
         $idPublicacao = $_GET['idpublicacao'];
         $email = $_SESSION['email'];
         $email2 = $_GET['usuario_email'];
         
         //echo "<p>$idPublicacao</p>";
         //echo "<p>$email</p>";
         //echo "<p>$email2</p>";
         }
    }
?>

<!doctype html>
<html lang="pt-br">
    <head>
        <title>Editar Publicação</title>
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
            <nav class="navbar navbar-expand-lg bg-body-tertiary bg-success-subtle">
                <div class="container-fluid">

                    <a class="navbar-brand" href="telaPrincipal.php">Doe&Ajude</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link active" aria-current="page" href="perfil.php">Perfil</a>
                            <a class="nav-link" href="publicacoes.php">Publicações</a>
                            <a class="nav-link disabled" aria-disabled="true">Interesses</a>
                            <a class="nav-link disabled" aria-disabled="true">Interessados</a>
                        </div>
                    </div>
                    <div class="d-grid d-md-flex justify-content-md-center">
                        <a class="btn btn-success rounded-pill" href="logout.php" role="button">Sair</a>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            <div class="container vstack gap-5 p-5"> 
                <div class="row p-5">
                    <div class="col-6 p-3 mb-2 offset-md-4 bg-success-subtle rounded-3">
                        <h2 class="mb-3 text-center">Edição de Publicação</h2>
                        <div class="mb-3 d-grid gap-5 d-md-flex justify-content-md-center">
                            <button class="btn btn-success rounded-pill" type="button" id="btnArquivar">Arquivar publicação</button>
                            <button class="btn btn-success rounded-pill" type="button" id="btnExcluir">Excluir publicação</button>
                        </div> 
                        <form id="frmEditar" action="" class="" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control rounded-pill" id="email" placeholder="Digite o seu e-mail" value="<?= $_SESSION['email']; ?>" disabled>
                                <input type="hidden" name="idPublicacao" id="idPublicacao" value="<?= $idPublicacao; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="titulo" class="form-label">*Título</label>
                                <input type="text" name="titulo" class="form-control rounded-pill" id="titulo" placeholder="Digite o título da publicação" autofocus required>
                                <p id="respTituloCadEdit"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">*Descrição</label>
                                <!--  
                                <input type="text" name="descricao" class="form-control rounded-pill" id="descricao" placeholder="Digite uma descrição para a publicação" required>
                                -->
                                <textarea class="form-control rounded" name="descricao" id="descricao" rows="3" placeholder="Digite uma descrição para a publicação" required></textarea>
                                <p id="respDescricaoCadEdit"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="cidade" class="form-label">*Cidade</label>
                                <input type="text" name="cidade" class="form-control rounded-pill" id="cidade" placeholder="Digite a cidade" required>
                                <p id="respCidadeCadEdit"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">*Estado</label>
                                <!--<input type="text" name="estado" class="form-control rounded-pill" id="estado" placeholder="Digite o estado" required>-->
                                <select class="form-select" aria-label="Default select estado" name="estado" id="estado">
                                    <option value="">Selecione o estado</option>
                                    <option value="Acre">Acre</option>
                                    <option value="Alagoas">Alagoas</option>
                                    <option value="Amapá">Amapá</option>
                                    <option value="Amazonas">Amazonas</option>
                                    <option value="Bahia">Bahia</option>
                                    <option value="Ceará">Ceará</option>
                                    <option value="Distrito Federal">Distrito Federal</option>
                                    <option value="Espírito Santo">Espírito Santo</option>
                                    <option value="Goiás">Goiás</option>
                                    <option value="Maranhão">Maranhão</option>
                                    <option value="Mato Grosso">Mato Grosso</option>
                                    <option value="Mato Grosso do Sul">Mato Grosso do Sul</option>
                                    <option value="Minas Gerais">Minas Gerais</option>
                                    <option value="Pará">Pará</option>
                                    <option value="Paraíba">Paraíba</option>
                                    <option value="Paraná">Paraná</option>
                                    <option value="Pernambuco">Pernambuco</option>
                                    <option value="Piauí">Piauí</option>
                                    <option value="Rio de Janeiro">Rio de Janeiro</option>
                                    <option value="Rio Grande do Norte">Rio Grande do Norte</option>
                                    <option value="Rio Grande do Sul">Rio Grande do Sul</option>
                                    <option value="Rondônia">Rondônia</option>
                                    <option value="Roraima">Roraima</option>
                                    <option value="Santa Catarina">Santa Catarina</option>
                                    <option value="São Paulo">São Paulo</option>
                                    <option value="Sergipe">Sergipe</option>
                                    <option value="Tocantins">Tocantins</option>
                                </select>
                                <p id="respEstadoCadEdit"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="telefone" class="form-label">*Telefone</label>
                                <input type="text" name="telefone" class="form-control rounded-pill" id="telefone" placeholder="Digite o seu telefone" required>
                                <p id="respTelefoneCadEdit"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <!--
                                <input type="text" name="foto" class="form-control rounded-pill" id="foto" placeholder="Faça o upload da foto" required>
                                -->
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="foto" name="foto" aria-describedby="blocoAjudaFoto">
                                    <label class="input-group-text" for="foto">Upload da foto</label>
                                </div>
                                <p id="respFotoCadEdit"></p>
                                <div id="blocoAjudaFoto" class="form-text">
                                    (*)Campos obrigatórios.
                                </div> 
                            </div>
                            <div class="mb-3 d-grid gap-5 d-md-flex justify-content-md-center">
                                <button class="btn btn-success rounded-pill" type="button" id="btnEditar">Editar</button>
                                <a class="btn btn-success rounded-pill" href="publicacoes.php" role="button">Ir para publicações</a>
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
        <script src="js/editarPublicacao.js"></script>
    </body>
</html>