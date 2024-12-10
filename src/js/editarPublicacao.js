//função que armazena o id da publicacao e envia para a página editarPublicacao.php
function clickPublicacao(idPublicacao) {
    console.log(idPublicacao);
    window.location.href = "editarPublicacao.php";
    window.onload = carregarSessaoEdit(idPublicacao);
  }

document.getElementById("email").textContent = email;
var publicacoes = document.getElementById("publicacoes");

//pega o id da publicação
//const idPublicacao = dataset.idpublicacao;
//console.log(idPub);
function carregarSessaoEdit(idPublicacao) {
    var idPub = idPublicacao;
    console.log(idPub);
    let xhr = new XMLHttpRequest();
    xhr.open("GET","editarPublicacao_get.php?idpublicacao=" + idPublicacao + "&usuario_email=" + email.value);
    xhr.onreadystatechange = function() {
        //console.log(xhr.responseText);
        if (xhr.status==200 && xhr.readyState==4) {
            console.log(xhr.responseText);
            //var publicacoes = this.response;
            //console.log(publicacoes);
            //if(xhr.responseText != ""){
            //    publicacoes.innerHTML = xhr.responseText;
            //}
        }
    }
    xhr.send();

}

//window.onload = carregarSessaoEdit;