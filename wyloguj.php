<?php
setcookie("user", "", time() - 3600);
setcookie("user_n", "", time() - 3600);
header("Location: index.php");
?>