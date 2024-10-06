const btnIncluir = document.getElementById("btnIncluir");
btnIncluir.addEventListener("click", (e) => {
   const frmIncluir = document.getElementById("frmIncluir");
   let formData = new FormData(frmIncluir);
   for ([key,val] of formData) {
      console.log(key + "=" + val);
   }
   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);
      }
   }
   xhr.open("PUT","cadastro.php");
   xhr.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded; charset=UTF-8');
   xhr.send(formData);
})