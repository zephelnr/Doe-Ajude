function DesfazerInteresse() {
    const id_publicacao = document.getElementById("idPublicacao").value;
    const frmInteresse = document.getElementById("frmInteresse");
    
    let formData = new FormData(frmInteresse);

    // as 2 linhas abaixo são no caso de uma alterção ou exclusão
   let jsonData = JSON.stringify(Object.fromEntries(formData));
   console.log(jsonData);

    console.log(formData);
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
        if (xhr.status == 200 && xhr.readyState == 4) {
            console.log(xhr.responseText);
            console.log("id", id_publicacao);
            window.location.href = "visualizacaoDetalhada.php?id_publicacao=" + id_publicacao;
        }
        else {
            console.log("XMLHttpRequest Error");
        }
    }

    xhr.open("DELETE", "desfazerInteresse.php");
    xhr.send(jsonData);
}