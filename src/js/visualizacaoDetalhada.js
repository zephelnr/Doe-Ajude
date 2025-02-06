document.getElementById("email").textContent = email;
const id_publicacao = document.getElementById("idPublicacao").value;
//console.log("email",email.value);
//console.log("id",id_publicacao);
function carregarDetalhes() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","visualizacaoDetalhada_get.php?id_publicacao=" + id_publicacao + "&email=" + email.value);
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            console.log(xhr.responseText);

            const titulo = document.getElementById("titulo");
            const descricao = document.getElementById("descricao");
            const cidade_estado = document.getElementById("cidadeEstado");
            const status_data = document.getElementById("statusData");
            const botaoInteresse = document.getElementById("botaoInteresse");
            const foto = document.getElementById("foto");
            const semFoto = document.getElementById("semFoto");

            var response = xhr.responseText;
            

            // Criando um elemento temporário para analisar o HTML
            var parser = new DOMParser();
            var doc = parser.parseFromString(response, "text/html");
            // Pegando o conteúdo de um elemento específico
            var tituloGet = doc.querySelector("h2").textContent;
            var descricaoGet = doc.querySelector("h3").textContent;
            var cidadeGet = doc.querySelector("h4").textContent;
            var estadoGet = doc.querySelector("h5").textContent;
            var statusGet = doc.querySelector("h6").textContent;
            var dataGet = doc.querySelector("h7").textContent;
            var botao = doc.querySelector("a").textContent;
            var fotoGet = doc.querySelector("h9").textContent;

            //formatar data
            const data = new Date(dataGet);
            const dataFormatada = data.toLocaleDateString('pt-BR'); // Formato: dd/mm/aaaa
            
            //botão
            console.log(fotoGet);
            if (botao == "Demonstrar" || botao == "Desfazer") {
                let xhr = new XMLHttpRequest();
                xhr.open("GET","botao_get.php?botao=" + botao);
                xhr.onreadystatechange = function() {
                    if (xhr.status==200 && xhr.readyState==4) {
                        console.log(xhr.responseText);
                        if(xhr.responseText != ""){
                            botaoInteresse.innerHTML = xhr.responseText;
                        } 
                    }
                }
                xhr.send();
            }

            // Exibindo os dados
            titulo.value = tituloGet;
            descricao.value = descricaoGet;
            cidade_estado.value = cidadeGet + " / " + estadoGet;
            status_data.value = statusGet + " em: " + dataFormatada;
            if(fotoGet != "") {
                foto.src = fotoGet;
            } else {
                semFoto.innerHTML = "<svg class='bd-placeholder-img card-img-top' width='100%' height='350' xmlns='http://www.w3.org/2000/svg' aria-label='Placeholder: Thumbnail' preserveAspectRatio='xMidYMid slice' role='img' focusable='false'><title>Sem Foto</title><rect width='100%' height='100%' fill='#55595c' /><text x='50%' y='50%' fill='#eceeef' dy='.3em'>Sem Foto</text></svg>";
            }
        }
        else {
            //console.log("XMLHttpRequest Error");
        }
    }
    xhr.send();

}

window.onload = carregarDetalhes;


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
