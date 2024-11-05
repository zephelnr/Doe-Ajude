const btnLogin = document.getElementById("btnLogin");
const respEmailLog = document.querySelector("#respEmailLog");
const respSenhaLog = document.querySelector("#respSenhaLog");
btnLogin.addEventListener("click", (e) => {
   const frmLogin = document.getElementById("frmLogin");
 
   const emailInput = frmLogin.querySelector("#email");
   const senhaInput = frmLogin.querySelector("#senha");

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

        //verifica se o campo email está vazio
        if (emailInput.value != ""){
            //verifica a resposta, caso seja "Email", o email é inválido
            if (response.includes("Email")) {
               respEmailLog.innerHTML = `O E-mail digitado é inválido`;
            } else {
               respEmailLog.innerHTML = ``;
            }
        } else {
            respEmailLog.innerHTML = `O campo E-mail está vazio!`;
        }

        //verifica se o campo senha está vazio, se não estiver verifica a resposta, caso seja "Senha", a senha é inválida
        if (senhaInput.value != ""){
            if (response.includes("Senha")) {
               respSenhaLog.innerHTML = `A senha digitada está incorreta`;
            } else {
               respSenhaLog.innerHTML = ``;
            }
         } else {
               respSenhaLog.innerHTML = `O campo Senha está vazio!`;
         }

      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }
   
   xhr.open("POST","login.php");
   xhr.send(formData);
})