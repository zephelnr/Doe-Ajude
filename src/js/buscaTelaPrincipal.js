const btnBuscar = document.getElementById("btnBuscar");
const busca = document.getElementById("search");
const recentes = document.getElementById("recentes");

btnBuscar.addEventListener("click", (e) => {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.onload = function() {
       if (xhr.status==200 && xhr.readyState==4) {
         if(xhr.responseText != ""){
            pubTelaPrincipal.innerHTML = xhr.responseText;
         }
         if(busca.value != ""){
            recentes.innerHTML = "Busca por: " + busca.value;
         }
       }
    }
    xhr.open("GET","telaPrincipal_get.php?titulo=" + busca.value);
    xhr.send();
 })

 //faz com que a pesquisa seja realizada quando precionada a tecla ENTER
document.addEventListener("keydown", function(e) {

    if(e.keyCode === 13) {
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.onload = function() {
           if (xhr.status==200 && xhr.readyState==4) {
             if(xhr.responseText != ""){
                pubTelaPrincipal.innerHTML = xhr.responseText;
             }
             if(busca.value != ""){
                recentes.innerHTML = "Busca por: " + busca.value;
             }
           }
        }
        xhr.open("GET","telaPrincipal_get.php?titulo=" + busca.value);
        xhr.send();
    }
  
  });