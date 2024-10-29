const btnLogin = document.getElementById("btnLogin");
btnLogin.addEventListener("click", (e) => {
   const frmLogin = document.getElementById("frmLogin");
   let formData = new FormData(frmLogin);

   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);

         // Verifica o conteúdo da resposta ou outras condições
        const response = xhr.responseText;

        // Supondo que você verifique algo na resposta para decidir o redirecionamento
        if (response.includes("response")) {
            window.location.href = "telaPrincipal.html";
        }
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }
   
   xhr.open("POST","login.php");
   xhr.send(formData);
})