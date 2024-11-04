const btnCadastrar = document.getElementById("btnCadastrar");
const respEmailLCad = document.querySelector("#respEmailCad");
const respCpfLCad = document.querySelector("#respCpfCad");
const respNomeCompletoLCad = document.querySelector("#respNomeCompletoCad");
const respSenhaLCad = document.querySelector("#respSenhaCad");

btnCadastrar.addEventListener("click", (e) => {
   const frmCadastrar = document.getElementById("frmCadastrar");
   let formData = new FormData(frmCadastrar);

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

         //verifica a resposta e se for "Email vazio" ou "PRIMARY" aparece o texto, se não retorna vazio
         if (response.includes("Email vazio")) {
            respEmailCad.innerHTML = `O campo Email está vazio!`;
         } else if (response.includes("PRIMARY")){
            respEmailCad.innerHTML = `O Email já está cadastrado!`;
         } else {
            respEmailCad.innerHTML = ``;
         }
         //verifica a resposta e se for "CPF vazio" ou "UNIQUE" aparece o texto, se não retorna vazio
         if (response.includes("Cpf vazio")) {
            respCpfCad.innerHTML = `O campo CPF está vazio!`;
         } else if (response.includes("UNIQUE")) {
            respCpfCad.innerHTML = `O CPF já está vazio!`;
         } else {
            respCpfCad.innerHTML = ``;
         }
         //verifica a resposta e se for "NomeCompleto vazio" aparece o texto, se não retorna vazio
         if (response.includes("NomeCompleto vazio")) {
            respNomeCompletoCad.innerHTML = `O campo Nome Completo está vazio!`;
         } else {
            respCpfCad.innerHTML = ``;
         }
         //verifica a resposta e se for "Senha vazia" aparece o texto, se não retorna vazio
         if (response.includes("Senha vazia")) {
            respSenhaCad.innerHTML = `O campo Senha está vazio!`;
         } else {
            respCpfCad.innerHTML = ``;
         }
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }

   xhr.open("POST","cadastro.php");
   xhr.send(formData);
})