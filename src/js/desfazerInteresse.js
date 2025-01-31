function DesfazerInteresse() {
    const id_publicacao = document.getElementById("idPublicacao").value;
    const frmInteresse = document.getElementById("frmInteresse");

    // Selecionar os elementos do Modal
    const modal = document.getElementById('sucessoCadastroPublicacaoModal');
    const fecharModalBtn = document.getElementById('fecharModal');

    const modalInteresse = document.querySelector("#modalInteresse");
    
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
            //window.location.href = "visualizacaoDetalhada.php?id_publicacao=" + id_publicacao;
             // Abrir o modal
             modal.style.display = 'flex';
             modalInteresse.innerHTML = `Interesse retirado com sucesso!`;

             // Fechar o modal
             fecharModalBtn.addEventListener('click', () => {
                modal.style.display = 'none';
                window.location.href = "visualizacaoDetalhada.php?id_publicacao=" + id_publicacao;
             });
             
             // Fechar o modal ao clicar fora dele
             window.addEventListener('click', (e) => {
                if (e.target === modal) {
                modal.style.display = 'none';
                window.location.href = "visualizacaoDetalhada.php?id_publicacao=" + id_publicacao;
                }

            
             });
        }
        else {
            console.log("XMLHttpRequest Error");
        }
    }

    xhr.open("DELETE", "desfazerInteresse.php");
    xhr.send(jsonData);
}