<?php

print("REQUEST_METHOD = ".$_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD']=='GET') {
   print("<h1>_GET</h1>");
   print_r($_GET);
}
elseif ($_SERVER['REQUEST_METHOD']=='POST') {
   print("<h1>_POST</h1>");
   print_r($_POST);
}
elseif ($_SERVER['REQUEST_METHOD']=='PUT') {
   print("<h1>_PUT</h1>");
   parse_str(file_get_contents('php://input'),$data);
   print_r($data);
}
elseif ($_SERVER['REQUEST_METHOD']=='DELETE') {
   print("<h1>_DELETE</h1>");
   parse_str(file_get_contents('php://input'),$data);
   print_r($data);
}

