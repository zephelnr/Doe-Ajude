var telaPrincipal = document.getElementById("pubTelaPrincipal");

function carregarSessaoTelaPrin() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","telaPrincipal_get.php");
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            if(xhr.responseText != ""){
                telaPrincipal.innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send();

}

window.onload = carregarSessaoTelaPrin;