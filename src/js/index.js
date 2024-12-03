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
/*
//codigo buscar

const btnBuscar = document.getElementById("btnBuscar");
const titulo = document.getElementById("search");

btnBuscar.addEventListener("click", (e) => {
   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
        if(xhr.responseText != ""){
            titulo.innerHTML = xhr.responseText;
        }
      }
   }
   xhr.open("GET","index_get.php?titulo=" + titulo.value);
   xhr.send(formData);
})*/