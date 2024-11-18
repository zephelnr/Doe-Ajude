const btnPublicar = document.getElementById("btnPublicar");
const respTituloCadPub = document.querySelector("#respTituloCadPub");
const respDescricaoCadPub = document.querySelector("#respDescricaoCadPub");
const respCidadeCadPub = document.querySelector("#respCidadeCadPub");
const respEstadoCadPub = document.querySelector("#respEstadoCadPub");
const respTelefoneCadPub = document.querySelector("#respTelefoneCadPub");
const respFotoCadPub = document.querySelector("#respFotoCadPub");
const respStatusCadPub = document.querySelector("#respStatusCadPub");

btnPublicar.addEventListener("click", (e) => {
   e.preventDefault();
   const email = document.getElementById("email");
   const titulo = document.getElementById("titulo");
   const descricao = document.getElementById("descricao");
   const cidade = document.getElementById("cidade");
   const estado = document.getElementById("estado");
   const telefone = document.getElementById("telefone");
   const foto = document.getElementById("foto");
   const status = document.getElementById("status");

   const frmPublicar = document.getElementById("frmPublicar");

   const tituloInput = frmPublicar.querySelector("#titulo");
   const descricaoInput = frmPublicar.querySelector("#descricao");
   const cidadeInput = frmPublicar.querySelector("#cidade");
   const estadoInput = frmPublicar.querySelector("#estado");
   const telefoneInput = frmPublicar.querySelector("#telefone");
   const fotoInput = frmPublicar.querySelector("#foto");
   const statusInput = frmPublicar.querySelector("#status");

   let formData = new FormData(frmPublicar);

   formData.append("email", email.value);
   formData.append("titulo", titulo.value);
   formData.append("descricao", descricao.value);
   formData.append("cidade", cidade.value);
   formData.append("estado", estado.value);
   formData.append("telefone", telefone.value);
   formData.append("foto", foto.value);
   formData.append("status", status.value);

   let xhr = new XMLHttpRequest();
   xhr.onload = function () {
      if (xhr.status == 200 && xhr.readyState == 4) {
         console.log(xhr.responseText);

         // Verifica o conteúdo da resposta ou outras condições
         const response = xhr.responseText;

         // Supondo que você verifique algo na resposta para decidir o redirecionamento
         if (response.includes("response")) {
            window.location.href = "publicacoes.php";
         }

         //verifica se o campo título esta vazio
         if (tituloInput.value != "") {
            respTituloCadPub.innerHTML = ``;
         } else {
            respTituloCadPub.innerHTML = `O campo Título está vazio!`;
         }

         //verifica se o campo descrição esta vazio
         if (descricaoInput.value != "") {
            respDescricaoCadPub.innerHTML = ``;
         } else {
            respDescricaoCadPub.innerHTML = `O campo Descrição está vazio!`;
         }

         //verifica se o campo cidade esta vazio
         if (cidadeInput.value != "") {
            respCidadeCadPub.innerHTML = ``;
         } else {
            respCidadeCadPub.innerHTML = `O campo Cidade está vazio!`;
         }

         //verifica se o campo estado esta vazio
         if (estadoInput.value != "") {
            respEstadoCadPub.innerHTML = ``;
         } else {
            respEstadoCadPub.innerHTML = `O campo Estado está vazio!`;
         }

         //verifica se o campo telefone esta vazio
         if (telefoneInput.value != "") {
            respTelefoneCadPub.innerHTML = ``;
         } else {
            respTelefoneCadPub.innerHTML = `O campo Telefone está vazio!`;
         }

         ///verifica se o campo foto esta vazio
         //if (fotoInput.value != "") {
         //   respFotoCadPUb.innerHTML = ``;
         //} else {
         //   respFotoCadPub.innerHTML = `O campo Foto está vazio!`;
         //}

         //verifica se o campo status esta vazio
         if (statusInput.value != "") {
            respStatusCadPub.innerHTML = ``;
         } else {
            respStatusCadPub.innerHTML = `O campo Status está vazio!`;
         }
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }

   xhr.open("POST", "cadastrarPublicacao.php");
   xhr.send(formData);
})