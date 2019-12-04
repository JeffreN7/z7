<?php
    //dane bazy danych
	$dbhost="serwer1944525.home.pl";
	$dbuser="31555506_cw7";
	$dbpassword="zse45rdx";
	$dbname="31555506_cw7";
    
    //sprawdzanie połączenia
    $polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    if (!$polaczenie) {
        echo "Błąd połączenia z MySQL." . PHP_EOL;
        echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
?>