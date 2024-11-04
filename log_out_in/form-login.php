<?php
session_start();
if (!empty($_SESSION['email'])) {
   header("Location: menu.php");
}
?>

<form method="POST" action="verifica-login.php">
   Email<input type="email" id="email" name="email"><br>
   Senha<input type="password" id="password" name="password"><br>
   <input type="submit" id="bSubmit">
</form>
<script src="js\sha256.min.js"></script>
<script>
   const bSubmit = document.getElementById("bSubmit");
   bSubmit.addEventListener("click", (e) => {
      e.preventDefault();
      const email = document.getElementById("email");
      const password = document.getElementById("password");
      console.log(`password: ${password.value}`);
      let hash = sha256(password.value);
      console.log(`hash: ${hash}`);
      let formData = new FormData();
      formData.append("email", email.value);
      formData.append("hash", hash);

      let xhr = new XMLHttpRequest();
      xhr.onload = function() {
         if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(`responseText: ${xhr.responseText}`);
            if (xhr.responseText == "OK") {
               window.location.href = "menu.php";
            } else {
               console.log(`Erro: ${xhr.responseText}`);
            }
         } else {
            console.log(`Erro: ${xhr.responseText}`);
         }
      }
      xhr.open("POST", "verifica-login.php");
      xhr.send(formData);

   });
</script>