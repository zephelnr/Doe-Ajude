//document.getElementById("estado").textContent = estado;
var estado = document.getElementById("estado");
var cidade = document.getElementById("cidade");
//console.log(estado);

// Capturando o valor do select
document.getElementById('estado').addEventListener('change', function() {
    const estadoSelecionado = this.value; // Valor selecionado
    console.log("Estado selecionado:", estadoSelecionado);

    let xhr = new XMLHttpRequest();
    xhr.open("GET","cidade.php?id_estado=" + estadoSelecionado);
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            //console.log(xhr.responseText);
            if(xhr.responseText != ""){
                cidade.innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send();
});

const idEstado = document.getElementById("estadoId");
console.log("idEstado",idEstado.value);

document.getElementById('estadoId').addEventListener('change', function() {

    console.log("idEstado2",idEstado.value);
    let xhr = new XMLHttpRequest();
    xhr.open("GET","cidade.php?id_estado=" + estadoId.value);
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            //console.log(xhr.responseText);
            if(xhr.responseText != ""){
                cidade.innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send();
});

if (idEstado.value != "") {
    console.log("idEstado3", idEstado.value);
}