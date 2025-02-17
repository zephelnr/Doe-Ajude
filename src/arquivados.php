<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.php");
}
?>
<?php
//Arquiva publicações com mais de 90 dias da data de publicação
require_once("arquivarPublicacoes.php");
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Arquivados</title>
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
                            <a class="nav-link" href="telaPrincipal.php">Home</a>
                            <a class="nav-link" href="perfil.php">Perfil</a>
                            <a class="nav-link" href="publicacoes.php">Minhas Publicações</a>
                            <a class="nav-link active" aria-current="page" href="arquivados.php">Arquivados</a>
                            <a class="nav-link" href="interesses.php">Meus Interesses</a>
                            <a class="nav-link" href="interessados.php">Interessados</a>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <p class="texto-nome">Olá, <?= $_SESSION['nomeCompleto']; ?></p>
                        <a class="btn btn-success rounded-pill" href="logout.php" role="button">Sair</a>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            <h2 class="mb-3 text-center">Arquivados</h2>
            <p><input type="hidden" name="email" id="email" value="<?= $_SESSION['email']; ?>"></p>
            <div class="mb-3 container d-flex">
                <!-- Caixa de tamanho fixo com classes Bootstrap -->
                <div class="fixed-size-box bg-success-subtle d-flex rounded row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="arquivados">           
                    <div class="container text-center" style="height: 450px;">
                        <div class="row">                           
                            <div class="col position-absolute top-50 start-50 translate-middle"><h6>Nenhuma publicação aquivada!</h6></div>
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
        <script src="js/arquivados.js"></script>
    </body>
</html>
