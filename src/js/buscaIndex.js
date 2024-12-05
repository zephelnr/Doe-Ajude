const btnBuscar = document.getElementById("btnBuscar");
const busca = document.getElementById("search");
const recentes = document.getElementById("recentes");

btnBuscar.addEventListener("click", (e) => {
    let xhr = new XMLHttpRequest();
    xhr.onload = function() {
       if (xhr.status==200 && xhr.readyState==4) {
         if(xhr.responseText != ""){
            pubRecentes.innerHTML = xhr.responseText;
         }
         if(busca.value != ""){
            recentes.innerHTML = "Busca por: " + busca.value;
         }
       }
    }
    xhr.open("GET","index_get.php?titulo=" + busca.value);
    xhr.send();
 })