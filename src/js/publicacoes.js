document.getElementById("email").textContent = email;
var resultado = document.getElementById("resultado");
//console.log(email.value);
function carregarSessaoPub() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","publicacoes_get.php?email=" + email.value);
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            //console.log(xhr.responseText);
            //var publicacoes = this.response;
            //console.log(publicacoes);
            resultado.innerHTML = xhr.responseText;
        }
        else {
            //console.log("XMLHttpRequest Error");
        }
    }
    xhr.send();

}

window.onload = carregarSessaoPub;