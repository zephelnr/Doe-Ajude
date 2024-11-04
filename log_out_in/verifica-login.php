<?php
session_start();
//print_r($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // verifica email/hash no banco de dados
   if ($_POST['email']=='teste@teste.com' && 
   $_POST['hash']=='46070d4bf934fb0d4b06d9e2c46e346944e322444900a435d7d9a95e6d7435f5') {
      // adicionar o email na sessao
      $_SESSION['email'] = $_POST['email'];
      print("OK");
   }
   else {
      // se não deu certo redireciona de volta para o login
      print("ERRO");
   }
}
?>