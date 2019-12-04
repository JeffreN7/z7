<?php
header("Location: pliki.php");
$nazwa=$_POST['n_kat'];
$usr=$_COOKIE['user_n'];
mkdir ("users/$usr/$nazwa", 0777);
?>