<?php
$ipaddress = $_SERVER["REMOTE_ADDR"];
function ip_details($ip) {
$json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
$details = json_decode ($json);
return $details;
}
$details = ip_details($ipaddress);
$ip=$details -> ip;
    require_once('dbconnect.php');
    $polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
        if (!$polaczenie) {
            echo "Błąd połączenia z MySQL." . PHP_EOL;
            echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }    
        $idu=$_COOKIE['user'];
        if(IsSet($usr)){
      $zapytanie ="SELECT * FROM logiblad WHERE idu=$idu order by datagodzina desc limit 1";
      $rezultat = mysqli_query($polaczenie, $zapytanie); 
      $wiersz1 = mysqli_fetch_array($rezultat); 
      }
      ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
    <title>Mężydło</title>
</head>

<body>
<?php
$usr=$_COOKIE['user_n'];
if(IsSet($usr)){
    ?>
<?php
 echo "Zalogowany jako użytkownik: <b>",$_COOKIE['user_n']," </b>";
 echo "<br>[<a href='wyloguj.php'>Wyloguj</a>]";
 ?>
<p><b><font color="red">
<?php
    if(!empty($wiersz1)){
    echo "ostatnie niepoprawne logowanie: ",$wiersz1['datagodzina']," <hr>";
   
    }
?>
</font></b></p>
<b>Twoja chmura:</b><br>
<?php

$dir= "/Z7/users/$usr";
$files = scandir($dir);
$arrlength = count($files);
for($x = 2; $x < $arrlength; $x++) {
    
  if (is_file("/Z7/users/$usr/$files[$x]")){
    echo "<a href='/Z7/users/$usr/$files[$x]' download='$files[$x]'>$files[$x]</a><br>";
  }else{ 
      echo $files[$x],"<br>";
      $dir2= "/Z7/users/$usr/$files[$x]";
      $files2 = scandir($dir2);
      $arrlength2 = count($files2);
        for($y = 2; $y < $arrlength2; $y++) {
        
        if (is_file("/Z7/users/$usr/$files[$x]/$files2[$y]")){
        echo "---<a href='/Z7/users/$usr/$files[$x]/$files2[$y]' download='$files2[$y]'>$files2[$y]</a>";
        }else{ 
            echo "---",$files2[$y];
        }
            echo "<br>";
            }
   }
  }
    echo "<br>";

?>
<br><br>
<b>Utwórz nowy katalog:</b>
<form method="POST" action="tworzenie.php">
        Katalog:<input type="text" name="n_kat">
        <input type="submit" value="Wyślij"/>
    </form>
<form action="odbierz.php" method="POST" ENCTYPE="multipart/form-data">
<b>Wybierz plik oraz folder, do którego chcesz go zapisać:</b> <input type="file" name="plik"/><br>
<?php
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if(is_dir("/Z7/users/$usr/$file") && $file != '.' && $file != '..'){
            echo "<input type=\"radio\" name=\"folder\" value =$file>$file<br>";
            }
        }
        closedir($dh);
    }
}
?>
 <input type="submit" value="Wyślij"/>
 
 <br>
 </form>
    <?php
}else{
echo "<center><font color=\"red\"><b>BRAK DOSTĘPU!<br>Nie jesteś zalogowany!</b></font></center>";
sleep(4);
echo "<script>location.href='wyloguj.php';</script>";}
?>
</body>
</html>