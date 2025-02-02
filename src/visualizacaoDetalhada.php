<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.php");
}
?>

<?php
require_once("conexao.php");

if ($_SERVER['REQUEST_METHOD']=='GET') { 
     // Verificar se a conexão foi bem-sucedida
     if ($conn->connect_error) {
         die("Conexão falhou: " . $conn->connect_error);   
     }
 
     // Verificar se o parâmetro 'id_publicacao' foi passado via GET
     if (isset($_GET['id_publicacao'])) {
         $idPublicacao = $_GET['id_publicacao'];
         }
    }
?>

<!doctype html>
<html lang="pt-br">
    <head>
        <title>Visualização Detalhada</title>
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
            width: 90vw;  /**/
            /*height: 70vh; 60em*/
            }
            .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
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
                            <a class="nav-link" href="arquivados.php">Arquivados</a>
                            <a class="nav-link" href="interesses.php">Meus Interesses</a>
                            <a class="nav-link" href="interessados.php">Interessados</a>
                        </div>
                    </div>
                    <a class="btn btn-success rounded-pill" href="logout.php" role="button">Sair</a>
                </div>
            </nav>
        </header>
        <main>
            <h2 class="mb-3 text-center">Visualização Detalhada</h2>
            <form action="" method="post" id="frmInteresse">
                <p><input type="hidden" name="email" id="email" value="<?= $_SESSION['email']; ?>"></p>
                <p><input type="hidden" name="idPublicacao" id="idPublicacao" value="<?= $idPublicacao; ?>"></p>
            </form>
            <div class="mb-3 container d-flex">
                <!-- Caixa de tamanho fixo com classes Bootstrap -->
                <div class="fixed-size-box bg-success-subtle d-flex rounded" id="publicacoes">           
                    <div class="container text-center" style="height: 500px;">
                        <div class="row">                           
                            
                            <div class="col">
                                <div>
                                    <svg class="bd-placeholder-img card-img-top" width="100%" height="325" xmlns="http://www.w3.org/2000/svg"
                                    aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" role="img" focusable="false">
                                        <title>Foto</title>
                                        <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef"
                                        dy=".3em">Foto</text>
                                    </svg>
                                </div>                                
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Titulo</label>
                                    <input type="text" name="titulo" class="form-control rounded-pill" id="titulo" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <textarea class="form-control rounded" name="descricao" id="descricao" rows="3" disabled></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="cidadeEstado" class="form-label">Cidade / Estado</label>
                                    <input type="text" name="cidadeEstado" class="form-control rounded-pill" id="cidadeEstado" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="statusData" class="form-label">Status / Data</label>
                                    <input type="text" name="statusData" class="form-control rounded-pill" id="statusData" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div id="botaoInteresse"></div>                            
                        </div>
                        <div>
                            <a class="btn btn-success rounded-pill" href="telaPrincipal.php" role="button">Voltar para página principal</a>
                        </div>  
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal" id="sucessoCadastroPublicacaoModal">
                <div class="modal-content bg-success-subtle rounded-3">
                <h2>Doe & Ajude</h2>
                <p id="modalInteresse"></p>
                <button class="btn btn-success rounded-pill" id="fecharModal">Fechar</button>
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
        <script src="js/visualizacaoDetalhada.js"></script>
        <script src="js/demonstrarInteresse.js"></script>
        <script src="js/desfazerInteresse.js"></script>
    </body>
</html>
