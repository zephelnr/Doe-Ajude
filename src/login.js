const btnLogin = document.getElementById("btnLogin");
const respEmailLog = document.querySelector("#respEmailLog");
const respSenhaLog = document.querySelector("#respSenhaLog");
btnLogin.addEventListener("click", (e) => {
   const frmLogin = document.getElementById("frmLogin");
   let formData = new FormData(frmLogin);

   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);

         // Verifica o conteúdo da resposta ou outras condições
        const response = xhr.responseText;

        // verifica a resposta e se for "response" redireciona a página
        if (response.includes("response")) {
            window.location.href = "telaPrincipal.html";
        }
        //verifica a resposta e se for "Email" aparece o texto
        if (response.includes("Email")) {
            respEmailLog.innerHTML = `O Email digitado é inválido`;
         } else {
            respEmailLog.innerHTML = ``;
         }
         if (response.includes("Senha")) {
            respSenhaLog.innerHTML = `A senha digitada está incorreta`;
         } else {
            respSenhaLog.innerHTML = ``;
         }
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }
   
   xhr.open("POST","login.php");
   xhr.send(formData);
})