const btnLogin = document.getElementById("btnLogin");
const respEmail = document.querySelector("#respEmail");
const respSenha = document.querySelector("#respSenha");
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
            respEmail.innerHTML = `O Email digitado é inválido`;
         }
         if (response.includes("Senha")) {
            respSenha.innerHTML = `A senha digitada está incorreta`;
         }
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }
   
   xhr.open("POST","login.php");
   xhr.send(formData);
})