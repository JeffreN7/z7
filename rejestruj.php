<html>
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
     <title>Mężydło</title>
</head>

<body>
<a href="index.php">Strona główna</a></p>

<form method="POST">
<b>REJESTRACJA</b><br><br>
Login:
<input type="text" name="nick" maxlength="25" size="25"><br>
Hasło:
<input type="password" name="haslo" maxlength="25" size="25"><br>
Powtórz hasło:
<input type="password" name="haslo1" maxlength="25" size="25"><br><br>

<input type="submit" value="Wyślij"/>
</form>

<?php
    require_once('dbconnect.php');
    $polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
        if (!$polaczenie) {
            echo "Błąd połączenia z MySQL." . PHP_EOL;
            echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }    
if (IsSet($_POST['nick'])) {
    if($_POST['haslo'] == $_POST['haslo1']){
    $n=$_POST['nick'];
    $h=$_POST['haslo'];
    $zapytanie="INSERT INTO users VALUES (NULL,'$n', '$h')";
    mysqli_query($polaczenie, $zapytanie);
    mysqli_close($polaczenie);
    mkdir ("users/$n", 0777);
    echo "<script>alert('Utworzono nowe konto')</script>";
    echo "<script>location.href='index.php';</script>";
  // echo $dodaj;
    }else {
         echo "<script>alert('Hasła nie są identyczne!')</script>";
        }
}
?>
<hr>
</body>
</html>
</html>




