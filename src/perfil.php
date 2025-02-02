<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.php");
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
                            <a class="nav-link" href="interesses.php">Meus Interesses</a>
                            <a class="nav-link" href="interessados.php">Interessados</a>
                        </div>
                    </div>
                   
                    <!--<div class="d-grid gap-5 d-md-flex justify-content-md-center">
                        <a class="navbar-brand" href="telaPrincipal.php">Doe&Ajude</a>
                        <a class="btn btn-success rounded-pill" href="perfil.php" role="button">Perfil</a>
                        <a class="btn btn-success rounded-pill" href="publicacoes.php" role="button">Publicações</a>
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
                            <input type="email" name="email" class="form-control rounded-pill" id="email" value="<?= $_SESSION['email']; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" name="cpf" class="form-control rounded-pill" id="cpf" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="nomeCompleto" class="form-label">Nome Completo</label>
                            <input type="text" name="nomeCompleto" class="form-control rounded-pill" id="nomeCompleto" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" name="senha" id="senha" class="form-control rounded-pill" disabled>
                        </div>
                        <div class="mb-3 d-grid gap-5 d-md-flex justify-content-md-center">
                            <button class="btn btn-success rounded-pill" type="button"  data-bs-toggle="modal" data-bs-target="#modalIdEditarPerfil" onclick="carregarSessao()">Editar</button>
                        </div>                                                
                    </div>    
                </div>    
            </div>
            <!-- Modal Body EditarPerfil-->
            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
            <div class="modal fade" id="modalIdEditarPerfil" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success-subtle">
                        <h5 class="modal-title" id="modalTitleId">
                            Editar Perfil
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Você deseja editar o seu cadastro?</p>
                        <p>Altere apenas os campos desejados!</p>
                        <div class="mb-3">
                            <label for="nomeCompleto" class="form-label">Nome Completo Atual</label>
                            <input type="text" name="nomeCompletoModal" class="form-control rounded-pill" id="nomeCompletoModal" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha Atual</label>
                            <input type="password" name="senhaModal" id="senhaModal" class="form-control rounded-pill" disabled>
                        </div>
                        <form id="frmEditarPerfil" action="" method="post">
                            <div class="mb-3">                                
                                <input type="hidden" name="emailEditarPerfil" class="form-control rounded-pill" id="emailEditarPerfil" value="<?= $_SESSION['email']; ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="nomeCompletoNovo" class="form-label">Nome Completo Novo</label>
                                <input type="text" name="nomeCompletoNovo" class="form-control rounded-pill" id="nomeCompletoNovo" placeholder="Digite o Nome Completo novo">
                            </div>
                            <p id="respNomeCompletoPerfilEdit"></p>
                            <div class="mb-3">
                                <label for="senhaNova" class="form-label">Senha Nova</label>
                                <input type="password" name="senhaNova" id="senhaNova" class="form-control rounded-pill" aria-describedby="blocoAjudaSenha" placeholder="Digite a senha nova">
                            </div>
                            <p id="respSenhaPerfilEdit"></p>
                            <div id="blocoAjudaSenha" class="form-text">
                                Senha nova deve possuir no mínimo 8 caracteres.                            
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer bg-success-subtle">
                        <button type="button" class="btn btn-success rounded-pill" data-bs-dismiss="modal">
                            Fechar
                        </button>
                        <button type="button" class="btn btn-success rounded-pill" id="btnEditarPerfil">Editar</button>
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
        <script src="js/sha256.min.js"></script>
        <script src="js/perfil.js"></script>
        <script src="js/editarPerfil.js"></script>
    </body>
</html>
