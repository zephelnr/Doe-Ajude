const btnEditarPerfil = document.getElementById("btnEditarPerfil");
const respNomeCompletoPerfilEdit = document.querySelector("#respNomeCompletoPerfilEdit");
const respSenhaPerfilEdit = document.querySelector("#respSenhaPerfilEdit");

btnEditarPerfil.addEventListener("click", (e) => {
   const frmEditarPerfil = document.getElementById("frmEditarPerfil");

   const nomeCompletoInput = frmEditarPerfil.querySelector("#nomeCompletoNovo");
   const senhaInput = frmEditarPerfil.querySelector("#senhaNova");
   const emailEditarPerfil = document.getElementById("emailEditarPerfil");

   //criptografa a senha
   let senha = ""
   if (senhaInput.value != ""){
      senha = sha256(senhaInput.value);
   }

   //verifica o tamanho da senha
   let tamSenha = senhaInput.value.length
   if (tamSenha < 8){
      senha = "";
   }

   console.log("nome", nomeCompletoInput.value);
   console.log("senha",senhaInput.value);

   let formData = new FormData(frmEditarPerfil);

   formData.append("senhaNova", senha);
   formData.append("email", emailEditarPerfil.value);
   
   let jsonData = JSON.stringify(Object.fromEntries(formData));
   console.log("json",jsonData);

   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);

         // Verifica o conteúdo da resposta ou outras condições
         const response = xhr.responseText;

         // Verifica a resposta para decidir o redirecionamento
         if (response.includes("response")) {
            window.location.href = "perfil.php";
         }

         //verifica a senha
         if (senhaInput.value != "") {
            //verifica o tamanho da senha
            if (tamSenha < 8) {
                respSenhaPerfilEdit.innerHTML = `A Senha possui menos que 8 caracteres!`;
            } else {
                respSenhaPerfilEdit.innerHTML = ``;
            }
         } else {
            respSenhaPerfilEdit.innerHTML = ``;
         }

         //verifica o Nome Completo
         if (response.includes("nomeCompleto irregular")) {
            respNomeCompletoPerfilEdit.innerHTML = `O Nome Completo está em formato irregular!`;
         } else {
            respNomeCompletoPerfilEdit.innerHTML = ``;
         }

      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }
   xhr.open("PUT","editarPerfil.php");
   xhr.send(jsonData);
})
