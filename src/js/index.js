var pubRecentes = document.getElementById("pubRecentes");
/*const btnBuscar = document.getElementById("btnBuscar");
const busca = document.getElementById("search");
const recentes = document.getElementById("recentes");*/



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
/*
btnBuscar.addEventListener("click", (e) => {
    if (busca.value != ""){
        recentes.innerHTML = "Busca por: " + busca.value;
    }
 })*/

//codigo buscar


/*
btnBuscar.addEventListener("click", (e) => {
   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
        if(xhr.responseText != ""){
            recentes.innerHTML = "";
            //pubRecentes.innerHTML = xhr.responseText;
        }
      }
   }
   xhr.open("GET","index_get.php?titulo=" + busca.value);
   xhr.send(formData);
})*/