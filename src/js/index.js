var pubRecentes = document.getElementById("pubRecentes");
function carregarSessaoIndex() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","index_get.php");
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            if(xhr.responseText != ""){
                pubRecentes.innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send();

}

window.onload = carregarSessaoIndex;