<?php
// Função para arquivar publicações com mais de 90 dias
function arquivarPublicacoes() {
    require_once("conexao.php");
    // Verifica a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Consulta para buscar publicações com mais de 90 dias e que ainda não estão arquivadas
    $sql_busca = " SELECT id_publicacao, titulo FROM publicacao WHERE `data` <= NOW() - INTERVAL 90 DAY AND status != 'arquivado'";

    $result = $conn->query($sql_busca);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id_publicacao = $row['id_publicacao'];
            $titulo = $row['titulo'];

            // Atualiza o status da publicação para 'arquivado'
            $sql_arquivar = "UPDATE publicacao SET status = 'arquivado' WHERE id_publicacao = ?";
            $stmt = $conn->prepare($sql_arquivar);
            $stmt->bind_param("i", $id_publicacao);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Publicação \"$titulo\" (ID: $id_publicacao) arquivada com sucesso!<br>";
            } else {
                echo "Falha ao arquivar a publicação \"$titulo\" (ID: $id_publicacao).<br>";
            }
        }
    } else {
        echo "Nenhuma publicação para arquivar.";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}

// Chamada da função para arquivar as publicações
arquivarPublicacoes();
?>
