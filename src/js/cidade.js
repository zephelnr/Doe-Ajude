//document.getElementById("estado").textContent = estado;
var estado = document.getElementById("estado");
var cidade = document.getElementById("cidade");
//console.log(estado);
function carregarCidadeSelect() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","cidade.php?id_estado=" + estado.value);
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            //console.log(xhr.responseText);
            //var publicacoes = this.response;
            //console.log(publicacoes);
            if(xhr.responseText != ""){
                cidade.innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send();

}

//if (estado.value != ''){
 //  window.onchange = carregarCidadeSelect; 
//}

// Capturando o valor do select
document.getElementById('estado').addEventListener('change', function() {
    const estadoSelecionado = this.value; // Valor selecionado
    console.log("Estado selecionado:", estadoSelecionado);

    let xhr = new XMLHttpRequest();
    xhr.open("GET","cidade.php?id_estado=" + estadoSelecionado);
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            //console.log(xhr.responseText);
            //var publicacoes = this.response;
            //console.log(publicacoes);
            if(xhr.responseText != ""){
                cidade.innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send();
    // Exemplo: Atualizar o parágrafo com o valor selecionado
    //document.getElementById('respEstadoCadPub').innerText = `Estado selecionado: ${textoSelecionado}`;
});
