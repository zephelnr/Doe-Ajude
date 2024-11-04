<?php
session_start();
if (empty($_SESSION['email'])) {
   header("Location: form-login.php");
}
?>
<html>

<head>
   <title>Titulo</title>
</head>
<body>
   <h1>Menu Principal</h1>
   <a href="logout.php">Logout</a>
</body>
</html>