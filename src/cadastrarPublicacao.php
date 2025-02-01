<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.php");
}
?>

<?php
require_once("conexao.php");

//print("REQUEST_METHOD = ".$_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD']=='POST') {
    try {
        // Coleta os dados enviados pelo FormData
        $email = $_POST['email'] ?? '';
        $titulo = trim($_POST['titulo'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $cidade = $_POST['cidade'] ?? '';
        $estado = $_POST['estado'] ?? '';
        $telefone= trim($_POST['telefone'] ?? '');
        $foto = $_POST['foto'] ?? '';
        $status = $_POST['status'] ?? '';

        //tratamento de erro telefone
        //checa se o telefone tem 10 ou 11 digitos
        if (strlen($telefone) !== 10 && strlen($telefone) !== 11){ //&& ctype_digit($cpf   
            echo json_encode(["telefone irregular"]);
            $telefone = '';
        }
      
        // Verifica se todos os campos foram enviados corretamente
        if (!empty($email) && !empty($titulo) && !empty($descricao) && !empty($cidade) && !empty($estado) && !empty($telefone) && !empty($status)) {
            // Cria um array associativo com os dados recebidos
            $dados = array(
                "titulo" => $titulo,
                "descricao" => $descricao,
                "cidade" => $cidade,
                "estado" => $estado,
                "telefone" => $telefone,
                "foto" => $foto,
                "status" => $status,
                "usuario_email" => $email
            );
      
            // Converte o array em JSON
            $jsonData = json_encode($dados);
      
            // Prepara a consulta SQL para inserir os dados
            $sql = "INSERT INTO publicacao (titulo, descricao, cidade, estado, telefone, foto, `status`, `data`,  usuario_email) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
      
            // Prepara a declaração e vincula os parâmetros
            if ($stmt = $conn->prepare($sql)) {
                // Usa "ssssssss" porque os campos são strings
                $stmt->bind_param("ssssssss", $titulo, $descricao, $cidade, $estado, $telefone, $foto, $status, $email);
      
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
            //if (empty($email)) {
            //    echo json_encode(["Email vazio"]);
            //}
            //if (empty($cpf)) {
            //    echo json_encode(["Cpf vazio"]);
           // }
            //if (empty($nomeCompleto)) {
            //    echo json_encode(["NomeCompleto vazio"]);
            //}
            //if (empty($senha)) {
            //    echo json_encode(["Senha vazia"]);
            //}

            // Retorna um erro se algum campo estiver vazio
            //echo json_encode(["status" => "error", "message" => "Todos os campos sao obrigatorios!"]);
            throw new Exception("Todos os campos sao obrigatorios!");
        }
        //header("Location: login.php");
        echo json_encode("response");
    } catch (Exception $e) {
        echo json_encode(["Erro! " . $e->getMessage()]);
    } finally {
        $conn = null;
    }
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

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a class="btn btn-success rounded-pill" href="perfil.php" role="button">Menu</a>
                        <a class="btn btn-success rounded-pill" href="logout.php" role="button">Sair</a>
                    </div>
                    -->
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
                        <h2 class="mb-3 text-center">Cadastro de Publicação</h2>
                        <form id="frmPublicar" action="" class="" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control rounded-pill" id="email" placeholder="Digite o seu e-mail" value="<?= $_SESSION['email']; ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="titulo" class="form-label">*Título</label>
                                <input type="text" name="titulo" class="form-control rounded-pill" id="titulo" placeholder="Digite o título da publicação" autofocus required>
                                <p id="respTituloCadPub"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">*Descrição</label>
                                <!--  
                                <input type="text" name="descricao" class="form-control rounded-pill" id="descricao" placeholder="Digite uma descrição para a publicação" required>
                                -->
                                <textarea class="form-control rounded" name="descricao" id="descricao" rows="3" placeholder="Digite uma descrição para a publicação" required></textarea>
                                <p id="respDescricaoCadPub"></p> 
                            </div>                            
                            <div class="mb-3">
                                <label for="estado" class="form-label">*Estado</label>
                                <!--<input type="text" name="estado" class="form-control rounded-pill" id="estado" placeholder="Digite o estado" required>-->
                                <select class="form-select" aria-label="Default select estado" id="estado">
                                    <!--<option selected value="">Selecione o estado</option>
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
                                    <option value="Tocantins">Tocantins</option>-->
                                </select>
                                <p id="respEstadoCadPub"></p> 
                            </div>
                            <div class="mb-3" id="selectCidade">
                                <label for="cidade" class="form-label">*Cidade</label>
                                <!--<input type="text" name="cidade" class="form-control rounded-pill" id="cidade" placeholder="Digite a cidade" required>-->
                                <select class="form-select" aria-label="Default select cidade" id="cidade"></select>
                                <p id="respCidadeCadPub"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="telefone" class="form-label">*Telefone</label>
                                <input type="number" name="telefone" class="form-control rounded-pill" id="telefone" placeholder="Digite o seu telefone (DD + número)" onkeypress="return event.charCode>=48 && event.charCode <=57" required>
                                <p id="respTelefoneCadPub"></p> 
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <!--
                                <input type="text" name="foto" class="form-control rounded-pill" id="foto" placeholder="Faça o upload da foto" required>
                                -->
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="foto" aria-describedby="blocoAjudaFoto">
                                    <label class="input-group-text" for="foto">Upload da foto</label>
                                </div>
                                <p id="respFotoCadPub"></p>
                                <div id="blocoAjudaFoto" class="form-text">
                                    (*)Campos obrigatórios.
                                </div> 
                            </div> <!--
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                               
                                <input type="text" name="status" class="form-control rounded-pill" id="status" placeholder="Coloque o status da publicação" required>
                               
                                <select class="form-select" aria-label="Default select example" id="status">
                                    <option selected value="">Selecione o status da publicação</option>
                                    <option value="Disponível">Disponível</option>
                                    <option value="Indisponível">Indisponível</option>
                                </select>
                                <p id="respStatusCadPub"></p> 
                            </div> -->
                            <div class="mb-3 d-grid gap-5 d-md-flex justify-content-md-center">
                                <button class="btn btn-success rounded-pill" type="button" id="btnPublicar">Publicar</button>
                                <a class="btn btn-success rounded-pill" href="publicacoes.php" role="button">Ir para publicações</a>
                            </div>                         
                        </form>
                    </div>    
                </div>    
            </div>
            <!-- Modal -->
            <div class="modal" id="sucessoCadastroPublicacaoModal">
                <div class="modal-content bg-success-subtle rounded-3">
                <h2>Doe & Ajude</h2>
                <p>Publicação cadastrada com sucesso!</p>
                <button class="btn btn-success rounded-pill" id="fecharModal">Ir para publicações</button>
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
        <script src="js/estado.js"></script>
        <script src="js/cidade.js"></script>
    </body>
</html>
