//const btnDemonstrarInteresse = document.getElementById("btnDemonstrarInteresse");

function DemonstrarInteresse() {
    //const email = document.getElementById("email");
    //const id_publicacao = document.getElementById("idPublicacao");

    const frmInteresse = document.getElementById("frmInteresse");
    
    let formData = new FormData(frmInteresse);

    //formData.append("email", email.value);
    //formData.append("id_publicacao", id_publicacao.value);

    console.log(formData);
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
        if (xhr.status == 200 && xhr.readyState == 4) {
            console.log(xhr.responseText);

            // Verifica o conteúdo da resposta ou outras condições
            //const response = xhr.responseText;

            // Supondo que você verifique algo na resposta para decidir o redirecionamento
            //if (response.includes("response")) {
            //    window.location.href = "login.php";   
            //}
                


        }
        else {
            console.log("XMLHttpRequest Error");
        }
    }

    xhr.open("POST", "demonstrarInteresse.php");
    xhr.send(formData);
}