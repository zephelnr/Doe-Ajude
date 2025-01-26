//console.log();
var estado = document.getElementById("estado");
function carregarEstadoSelect() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","estado.php");
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            //console.log(xhr.responseText);
            //var publicacoes = this.response;
            //console.log(publicacoes);
            if(xhr.responseText != ""){
                estado.innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send();

}

window.onload = carregarEstadoSelect;