document.getElementById("email").textContent = email;
var interessados = document.getElementById("interessados");
function carregarSessaoInteressados() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","interessados_get.php?usuario_email=" + email.value);
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            if(xhr.responseText != ""){
                interessados.innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send();

}

window.onload = carregarSessaoInteressados;