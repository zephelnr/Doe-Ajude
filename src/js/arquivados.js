document.getElementById("email").textContent = email;
var arquivados = document.getElementById("arquivados");
function carregarSessaoArq() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","arquivados_get.php?email=" + email.value);
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            //console.log(xhr.responseText);
            if(xhr.responseText != ""){
                arquivados.innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send();

}

window.onload = carregarSessaoArq;