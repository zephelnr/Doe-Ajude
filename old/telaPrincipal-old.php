<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: index.html");
}
echo $_SESSION['email'];
?>