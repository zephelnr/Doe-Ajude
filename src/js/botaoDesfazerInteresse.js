function BotaoDesfazerInteresse(id_interesse) {
    //const id_interesse = document.getElementById("idInteresse").value;
    const frmDesfazerInteresse = document.getElementById("frmDesfazerInteresse");

    // Selecionar os elementos do Modal
    const modal = document.getElementById('botaoDesfazerInteresseModal');
    const fecharModalBtn = document.getElementById('fecharModal');
    
    let formData = new FormData(frmDesfazerInteresse);

    formData.append("idInteresse", id_interesse);

    // as 2 linhas abaixo são no caso de uma alterção ou exclusão
   let jsonData = JSON.stringify(Object.fromEntries(formData));
   console.log(jsonData);

    console.log(formData);
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
        if (xhr.status == 200 && xhr.readyState == 4) {
            console.log(xhr.responseText);
            //console.log("id", id_publicacao);
            //window.location.href = "visualizacaoDetalhada.php?id_publicacao=" + id_publicacao;
            
            // Abrir o modal
            modal.style.display = 'flex';

            // Fechar o modal
            fecharModalBtn.addEventListener('click', () => {
               modal.style.display = 'none';
               window.location.href = "interesses.php";
            });
            
            // Fechar o modal ao clicar fora dele
            window.addEventListener('click', (e) => {
               if (e.target === modal) {
               modal.style.display = 'none';
               window.location.href = "interesses.php";
               }           
            });
        }
        else {
            console.log("XMLHttpRequest Error");
        }
    }

    xhr.open("DELETE", "botaoDesfazerInteresse.php");
    xhr.send(jsonData);
}