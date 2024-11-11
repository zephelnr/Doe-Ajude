const btnCadastrar = document.getElementById("btnCadastrar");
const respEmailLCad = document.querySelector("#respEmailCad");
const respCpfLCad = document.querySelector("#respCpfCad");
const respNomeCompletoLCad = document.querySelector("#respNomeCompletoCad");
const respSenhaLCad = document.querySelector("#respSenhaCad");

btnCadastrar.addEventListener("click", (e) => {
   e.preventDefault();
   const email = document.getElementById("email");
   const cpf = document.getElementById("cpf");
   const nomeCompleto = document.getElementById("nomeCompleto");
   const senhaDesc = document.getElementById("senha");
   //criptografa a senha
   let senha = sha256(senhaDesc.value);

   const frmCadastrar = document.getElementById("frmCadastrar");

   const emailInput = frmCadastrar.querySelector("#email");
   const cpfInput = frmCadastrar.querySelector("#cpf");
   const nomeCompletoInput = frmCadastrar.querySelector("#nomeCompleto");
   const senhaInput = frmCadastrar.querySelector("#senha");

   let formData = new FormData(frmCadastrar);

   formData.append("email", email.value);
   formData.append("cpf", cpf.value);
   formData.append("nomeCompleto", nomeCompleto.value);
   formData.append("senha", senha);

   let xhr = new XMLHttpRequest();
   xhr.onload = function () {
      if (xhr.status == 200 && xhr.readyState == 4) {
         console.log(xhr.responseText);

         // Verifica o conteúdo da resposta ou outras condições
         const response = xhr.responseText;

         // Supondo que você verifique algo na resposta para decidir o redirecionamento
         if (response.includes("response")) {
            window.location.href = "login.php";
         }

         //verifica se o campo email esta vazio
         if (emailInput.value != "") {
            //verifica a resposta e se for "Email vazio" ou "PRIMARY" aparece o texto, se não retorna vazio
            if (response.includes("PRIMARY")) {
               respEmailCad.innerHTML = `O Email já está cadastrado!`;
            } else {
               respEmailCad.innerHTML = ``;
            }
         } else {
            respEmailCad.innerHTML = `O campo Email está vazio!`;
         }

         //verifica se o campo cpf esta vazio
         if (cpfInput.value != "") {
            //verifica a resposta e se for "CPF vazio" ou "UNIQUE" aparece o texto
            if (response.includes("UNIQUE")) {
               respCpfCad.innerHTML = `O CPF já está vazio!`;
            } else {
               respCpfCad.innerHTML = ``;
            }
         } else {
            respCpfCad.innerHTML = `O campo CPF está vazio!`;
         }

         //verifica se o campo nomeCompleto esta vazio
         if (nomeCompletoInput.value != "") {
            respCpfCad.innerHTML = ``;
         } else {
            respNomeCompletoCad.innerHTML = `O campo Nome Completo está vazio!`;
         }

         //verifica se o campo senha esta vazio
         if (senhaInput.value != "") {
            respSenhaCad.innerHTML = ``;
         } else {
            respSenhaCad.innerHTML = `O campo Senha está vazio!`;
         }
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }

   xhr.open("POST", "cadastro.php");
   xhr.send(formData);
})