 // Função que será chamada quando a página for carregada
 window.onload = function() {
    // Usando fetch para fazer a requisição AJAX para o script PHP
    fetch('telaPrincipal.php')
        .then(response => response.text())  // Lê a resposta como texto
        .then(data => {
            console.log(data);  // Exibe a resposta do PHP no console
            document.getElementById('resultado').innerHTML = data;  // Exibe no HTML
        })
        .catch(error => console.error('Erro:', error));  // Tratamento de erro
};