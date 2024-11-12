const btnVisualizar = document.getElementById("btnVisualizar");
btnVisualizar.addEventListener("click", (e) => {

    ///
   const email = document.getElementById("email");
   //const cpf = document.getElementById("cpf");
   //const nomeCompleto = document.getElementById("nomeCompleto");
   ///

   const frmVisualizar = document.getElementById("frmVisualizar");
   let formData = new FormData(frmVisualizar);

   ///
   //formData.append("email", email.value);
   //formData.append("cpf", cpf.value);
   //formData.append("nomeCompleto", nomeCompleto.value);
   ///
   console.log(formData);
   console.log(frmVisualizar.email.value);
   // as 2 linhas abaixo são no caso de uma alterção ou exclusão
   //let jsonData = JSON.stringify(Object.fromEntries(formData));
   //console.log(jsonData);

   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }
   // troque o DELETE abaixo pelo método que vc precisa
   // GET, POST, PUT, DELETE
   // lembrando que no caso de consultas (GET), vc deve enviar os parâmetros diretamente no URL
   xhr.open("GET","form.php?email=" + frmVisualizar.email.value);
   // se for inclusão(POST) vc envia o formData
   // se for alteração ou exclusão (PUT ou DELETE) você envia o jsonData
   // se for uma consulta (GET), vc deve enviar os dados pelo URL, como mencionei acima
   xhr.send(formData);
})