const btnLogin = document.getElementById("btnLogin");
const respEmailLog = document.querySelector("#respEmailLog");
const respSenhaLog = document.querySelector("#respSenhaLog");
btnLogin.addEventListener("click", (e) => {
   e.preventDefault();
   const email = document.getElementById("email");
   const senhaDesc = document.getElementById("senha");
   //criptografa a senha
   let senha = sha256(senhaDesc.value);

   const frmLogin = document.getElementById("frmLogin");
 
   const emailInput = frmLogin.querySelector("#email");
   const senhaInput = frmLogin.querySelector("#senha");

   let formData = new FormData(frmLogin);

   formData.append("email", email.value);
   formData.append("senha", senha);

   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);

         // Verifica o conteúdo da resposta ou outras condições
        const response = xhr.responseText;

        // verifica a resposta e se for "response" redireciona a página
        if (response.includes("response")) {
            window.location.href = "telaPrincipal.php";
        }

        //verifica se o campo email está vazio
        if (emailInput.value != ""){
            //verifica a resposta, caso seja "Email", o email é inválido
            if (response.includes("Email invalido")) {
               respEmailLog.innerHTML = `O E-mail digitado é inválido`;
            } else {
               respEmailLog.innerHTML = ``;
            }
        } else {
            respEmailLog.innerHTML = `O campo E-mail está vazio!`;
        }

        //verifica se o campo senha está vazio, se não estiver verifica a resposta, caso seja "Senha", a senha é inválida
        if (senhaInput.value != ""){
            if (response.includes("Senha invalida")) {
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