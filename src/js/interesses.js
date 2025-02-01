document.getElementById("email").textContent = email;
var interesses = document.getElementById("interesses");
//console.log(email.value);
function carregarSessaoInteresses() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","interesses_get.php?usuario_email=" + email.value);
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            //console.log(xhr.responseText);
            //var publicacoes = this.response;
            //console.log(publicacoes);
            if(xhr.responseText != ""){
                interesses.innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send();

}

window.onload = carregarSessaoInteresses;