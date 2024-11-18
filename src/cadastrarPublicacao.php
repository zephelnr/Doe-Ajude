<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.php");
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Cadastrar Publicação</title>
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
                    <!--
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link active" aria-current="page" href="perfil.php">Perfil</a>
                            <a class="nav-link" href="publicacoes.php">Publicações</a>
                            <a class="nav-link disabled" aria-disabled="true">Interesses</a>
                            <a class="nav-link disabled" aria-disabled="true">Interessados</a>
                        </div>
                    </div>
                   
                    <a class="btn btn-success rounded-pill" href="logout.php" role="button">Sair</a>
                    -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a class="btn btn-success rounded-pill" href="perfil.php" role="button">Menu</a>
                        <a class="btn btn-success rounded-pill" href="logout.php" role="button">Sair</a>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            <div class="container vstack gap-5 p-5"> 
                <div class="row p-5">
                    <div class="col-5 p-3 mb-2 offset-md-4 bg-success-subtle rounded-3">
                        <h2 class="mb-3 text-center">Cadastro de Publicação</h2>
                        <form id="frmPublicar" action="" class="" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control rounded-pill" id="email" placeholder="Digite o seu e-mail" autofocus required>
                                <p id="respEmailCad"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" name="titulo" class="form-control rounded-pill" id="titulo" placeholder="Digite o título da publicação" required>
                                <p id="respTituloCad"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <!--  
                                <input type="text" name="descricao" class="form-control rounded-pill" id="descricao" placeholder="Digite uma descrição para a publicação" required>
                                -->
                                <textarea class="form-control rounded" name="descricao" id="descricao" rows="3" placeholder="Digite uma descrição para a publicação" required></textarea>
                                <p id="respDescricaoCad"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" name="bairro" class="form-control rounded-pill" id="bairro" placeholder="Digite o bairro" required>
                                <p id="respBairroCad"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" name="cidade" class="form-control rounded-pill" id="cidade" placeholder="Digite a cidade" required>
                                <p id="respCidadeCad"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <input type="text" name="estado" class="form-control rounded-pill" id="estado" placeholder="Digite o estado" required>
                                <p id="respEstadoCad"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" name="telefone" class="form-control rounded-pill" id="telefone" placeholder="Digite o seu telefone" required>
                                <p id="respTelefoneCad"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <!--
                                <input type="text" name="foto" class="form-control rounded-pill" id="foto" placeholder="Faça o upload da foto" required>
                                -->
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="foto">
                                    <label class="input-group-text" for="foto">Upload</label>
                                </div>
                                <p id="respFotoCad"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <!--
                                <input type="text" name="status" class="form-control rounded-pill" id="status" placeholder="Coloque o status da publicação" required>
                                -->
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Selecione o status da publicação</option>
                                    <option value="Disponível">Disponível</option>
                                    <option value="Indisponível">Indisponível</option>
                                </select>
                                <p id="respStatusCad"></p> 
                            </div>
                            <div class="mb-3 d-grid gap-5 d-md-flex justify-content-md-center">
                                <button class="btn btn-success rounded-pill" type="button" id="btnPublicar">Publicar</button>
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
        <script src="js/cadastrarPublicacao.js"></script>
    </body>
</html>
