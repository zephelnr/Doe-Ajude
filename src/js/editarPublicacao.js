document.getElementById("email").textContent = email;
document.getElementById("idPublicacao").textContent = idPublicacao;
console.log(idPublicacao.value);
console.log(email.value);
function carregarSessaoEdit() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","editarPublicacao_get.php?idpublicacao=" + idPublicacao.value + "&usuario_email=" + email.value);
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            console.log(xhr.responseText);

            const titulo = document.getElementById("titulo");
            const descricao = document.getElementById("descricao");
            const cidade = document.getElementById("cidade");
            const estado = document.getElementById("estado");
            const telefone = document.getElementById("telefone");
            const foto = document.getElementById("foto");

            var response = xhr.responseText;
            

            // Criando um elemento temporário para analisar o HTML
            var parser = new DOMParser();
            var doc = parser.parseFromString(response, "text/html");
            // Pegando o conteúdo de um elemento específico
            var tituloGet = doc.querySelector("h2").textContent;
            var descricaoGet = doc.querySelector("h3").textContent;
            var cidadeGet = doc.querySelector("h4").textContent;
            var estadoGet = doc.querySelector("h5").textContent;
            var telefoneGet = doc.querySelector("h6").textContent;
            var fotoGet = doc.querySelector("h7").textContent;


            // Exibindo os dados
            titulo.value = tituloGet;
            descricao.value = descricaoGet;
            cidade.value = cidadeGet;
            estado.value = estadoGet;
            telefone.value = telefoneGet;
            foto.value = fotoGet;

        }
        else {
            console.log("XMLHttpRequest Error");
        }
    }
    xhr.send();
}

window.onload = carregarSessaoEdit;

const btnEditar = document.getElementById("btnEditar");
const respTituloCadEdit = document.querySelector("#respTituloCadEdit");
const respDescricaoCadEdit = document.querySelector("#respDescricaoCadEdit");
const respCidadeCadEdit = document.querySelector("#respCidadeCadEdit");
const respEstadoCadEdit = document.querySelector("#respEstadoCadEdit");
const respTelefoneCadEdit = document.querySelector("#respTelefoneCadEdit");
//const respFotoCadEdit = document.querySelector("#respFotoCadEdit");

btnEditar.addEventListener("click", (e) => {
   const frmEditar = document.getElementById("frmEditar");

   const tituloInput = frmEditar.querySelector("#titulo");
   const descricaoInput = frmEditar.querySelector("#descricao");
   const cidadeInput = frmEditar.querySelector("#cidade");
   const estadoInput = frmEditar.querySelector("#estado");
   const telefoneInput = frmEditar.querySelector("#telefone");
   const fotoInput = frmEditar.querySelector("#foto");

   let formData = new FormData(frmEditar);

   //inclui no formdata o campo e o nome do campo
   formData.append("email", email.value);
   formData.append("campoTitulo", "titulo");
   formData.append("campoDescricao", "descricao");
   formData.append("campoCidade", "cidade");
   formData.append("campoEstado", "estado");
   formData.append("campoTelefone", "telefone");
   formData.append("campoFoto", "foto");
   formData.append("status", "Editado");

   //inpede o campo foto adicionar lixo na tabela
   if(fotoInput != ""){
    formData.append("foto", fotoInput.value);
   } else {
    formData.append("foto", "");
   }
   
   let jsonData = JSON.stringify(Object.fromEntries(formData));
   console.log(jsonData);

   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);

         // Verifica o conteúdo da resposta ou outras condições
         const response = xhr.responseText;

         // Verifica a resposta para decidir o redirecionamento
         if (response.includes("response")) {
            window.location.href = "publicacoes.php";
         }

         //verifica se o campo título esta vazio
         if (tituloInput.value != "") {
            respTituloCadEdit.innerHTML = ``;
         } else {
            respTituloCadEdit.innerHTML = `O campo Título está vazio!`;
         }

         //verifica se o campo descrição esta vazio
         if (descricaoInput.value != "") {
            respDescricaoCadEdit.innerHTML = ``;
         } else {
            respDescricaoCadEdit.innerHTML = `O campo Descrição está vazio!`;
         }

         //verifica se o campo cidade esta vazio
         if (cidadeInput.value != "") {
            respCidadeCadEdit.innerHTML = ``;
         } else {
            respCidadeCadEdit.innerHTML = `O campo Cidade está vazio!`;
         }

         //verifica se o campo estado esta vazio
         if (estadoInput.value != "") {
            respEstadoCadEdit.innerHTML = ``;
         } else {
            respEstadoCadEdit.innerHTML = `O campo Estado está vazio!`;
         }

         //verifica se o campo telefone esta vazio
         if (telefoneInput.value != "") {
            respTelefoneCadEdit.innerHTML = ``;
         } else {
            respTelefoneCadEdit.innerHTML = `O campo Telefone está vazio!`;
         }
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }
   xhr.open("PUT","editarPublicacao_put.php");
   xhr.send(jsonData);
})

const btnDeletar = document.getElementById("btnDeletar");
btnDeletar.addEventListener("click", (e) => {
   const frmDeletar = document.getElementById("frmDeletar");
   let formData = new FormData(frmDeletar);
   
   // as 2 linhas abaixo são no caso de uma alterção ou exclusão
   let jsonData = JSON.stringify(Object.fromEntries(formData));
   console.log(jsonData);

   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);

         // Verifica o conteúdo da resposta ou outras condições
         const response = xhr.responseText;

         // Verifica a resposta para decidir o redirecionamento
         if (response.includes("response")) {
            window.location.href = "publicacoes.php";
         }
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }
   xhr.open("DELETE","editarPublicacao_delete.php");
   xhr.send(jsonData);
})