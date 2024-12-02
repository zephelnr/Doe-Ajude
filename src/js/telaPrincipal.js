/* // Função que será chamada quando a página for carregada
 window.onload = function() {
    // Usando fetch para fazer a requisição AJAX para o script PHP
    fetch('telaPrincipal.php')
        .then(response => response.text())  // Lê a resposta como texto
        .then(data => {
            console.log(data);  // Exibe a resposta do PHP no console
            document.getElementById('resultado').innerHTML = data;  // Exibe no HTML
        })
        .catch(error => console.error('Erro:', error));  // Tratamento de erro
};*/

var telaPrincipal = document.getElementById("telaPrincipal");
//console.log(email.value);
function carregarSessaoTelaPrin() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","telaPrincipal_get.php");
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            //console.log(xhr.responseText);
            //var publicacoes = this.response;
            //console.log(publicacoes);
            if(xhr.responseText != ""){
                telaPrincipal.innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send();

}

window.onload = carregarSessaoTelaPrin;