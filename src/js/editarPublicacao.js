document.getElementById("email").textContent = email;
document.getElementById("idPublicacao").textContent = idPublicacao;
console.log(idPublicacao.value);
console.log(email.value);
function carregarSessaoEdit() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","editarPublicacao_get.php?idpublicacao=" + idPublicacao.value + "&usuario_email=" + email.value);
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            console.log(xhr.responseText);

            const titulo = document.getElementById("titulo");
            const descricao = document.getElementById("descricao");
            const cidade = document.getElementById("cidade");
            const estado = document.getElementById("estado");
            const telefone = document.getElementById("telefone");
            const foto = document.getElementById("foto");

            var response = xhr.responseText;
            

            // Criando um elemento temporário para analisar o HTML
            var parser = new DOMParser();
            var doc = parser.parseFromString(response, "text/html");
            // Pegando o conteúdo de um elemento específico
            var tituloGet = doc.querySelector("h2").textContent;
            var descricaoGet = doc.querySelector("h3").textContent;
            var cidadeGet = doc.querySelector("h4").textContent;
            var estadoGet = doc.querySelector("h5").textContent;
            var telefoneGet = doc.querySelector("h6").textContent;
            var fotoGet = doc.querySelector("h7").textContent;


            // Exibindo os dados
            titulo.value = tituloGet;
            descricao.value = descricaoGet;
            cidade.value = cidadeGet;
            estado.value = estadoGet;
            telefone.value = telefoneGet;
            foto.value = fotoGet;

        }
        else {
            console.log("XMLHttpRequest Error");
        }
    }
    xhr.send();
}

window.onload = carregarSessaoEdit;