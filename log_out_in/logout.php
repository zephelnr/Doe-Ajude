<?php
session_start();
$_SESSION = [];
header("Location: form-login.php");