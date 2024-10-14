const btnIncluir = document.getElementById("btnIncluir");
btnIncluir.addEventListener("click", (e) => {
   const frmIncluir = document.getElementById("frmIncluir");
   let formData = new FormData(frmIncluir);

   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }

   xhr.open("POST","cadastro.php");
   xhr.send(formData);
})