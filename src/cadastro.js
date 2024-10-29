const btnIncluir = document.getElementById("btnIncluir");
btnIncluir.addEventListener("click", (e) => {
   const frmIncluir = document.getElementById("frmIncluir");
   let formData = new FormData(frmIncluir);

   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);

         // Verifica o conteúdo da resposta ou outras condições
        const response = xhr.responseText;

        // Supondo que você verifique algo na resposta para decidir o redirecionamento
        if (response.includes("response")) {
            window.location.href = "login.html";
        }
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }

   xhr.open("POST","cadastro.php");
   xhr.send(formData);
})