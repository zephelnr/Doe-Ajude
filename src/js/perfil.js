document.getElementById("email").textContent = email;
console.log(email.value);
function carregarSessao() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","perfil.php?email=" + email.value);
    xhr.onreadystatechange = function() {
    if (xhr.status==200 && xhr.readyState==4) {
        console.log(xhr.responseText);

        const cpf = document.getElementById("cpf");
        const nomeCompleto = document.getElementById("nomeCompleto");

        var response = xhr.responseText;

        // Criando um elemento temporário para analisar o HTML
        var parser = new DOMParser();
        var doc = parser.parseFromString(response, "text/html");

        // Pegando o conteúdo de um elemento específico
        var cpfGet = doc.querySelector("h2").textContent;
        var nomeCompletoGet = doc.querySelector("h3").textContent;


        // Exibindo os dados
        cpf.value = cpfGet;
        nomeCompleto.value = nomeCompletoGet;


    }
    else {
        console.log("XMLHttpRequest Error");
    }
    }
    xhr.send();

}

window.onload = carregarSessao;


/*
function carregarDadosSessao() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET","perfil.php?", true); // Requisição para o PHP que retorna a sessão
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            var resposta = JSON.parse(xhr.responseText);
            
            if (resposta.usuario) {
                document.getElementById("usuario").textContent = resposta.usuario;
                //document.getElementById("email").textContent = resposta.email;
                //document.getElementById("idade").textContent = resposta.idade;
            } else {
                console.log(resposta.error);
            }
        }
    };
    xhr.send();
}

window.onload = carregarDadosSessao; // Chama a função quando a página carrega*/
