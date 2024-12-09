document.getElementById("email").textContent = email;
var publicacoes = document.getElementById("publicacoes");

//pega o id da publicação
const idPublicacao = dataset.idpublicacao;
console.log(idPublicacao);
function carregarSessaoPub() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","publicacoes_get.php?email=");
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            //console.log(xhr.responseText);
            //var publicacoes = this.response;
            //console.log(publicacoes);
            if(xhr.responseText != ""){
                publicacoes.innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send();

}

window.onload = carregarSessaoPub;