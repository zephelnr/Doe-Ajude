const btnLogin = document.getElementById("btnLogin");
btnLogin.addEventListener("click", (e) => {
   const frmLogin = document.getElementById("frmLogin");
   let formData = new FormData(frmLogin);

   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }
   
   xhr.open("POST","login.php");
   xhr.send(formData);
})