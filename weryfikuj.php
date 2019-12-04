<?php
$ip = $_SERVER["REMOTE_ADDR"];
function ip_details($ip) {
$json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
$details = json_decode ($json);
return $details;
}
$details = ip_details($ip);
$ip=$details -> ip;
$godzina = date("Y-m-d H:i:s", time());
$user=strtolower($_POST['user']);
 $pass=$_POST['pass'];
 require_once('dbconnect.php');
 $polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
 if(!$polaczenie) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); }
 mysqli_query($polaczenie, "SET NAMES 'utf8'");

 $zapytanie="SELECT * FROM users WHERE login='$user'";
 $rezultat = mysqli_query($polaczenie, $zapytanie);
 $wiersz = mysqli_fetch_array($rezultat);
 $idu=$wiersz['id'];
 $zapytanie ="SELECT * FROM logiblad WHERE idu='$idu'";
 $rezultat = mysqli_query($polaczenie, $zapytanie); 
 $wiersz1 = mysqli_fetch_array($rezultat); 
 if(!$wiersz) //Jeśli brak, to nie ma użytkownika o podanym loginie
{
    echo "<center><b><font color=\"red\">Brak takiego użytkownika!</font><br><br></b></center>";
    sleep(2);
    echo "<script>location.href='wyloguj.php';</script>";
 }
else
 { // Jeśli $wiersz istnieje
 if($wiersz['haslo']==$pass )// czy hasło zgadza się z BD
 {  
     $spr=substr($wiersz1['proba'], 0, 2);
     $proba=$wiersz1['proba'];
     if($spr=="b-"){
            $blockedTime = substr($proba, 2);
            if(time() < $blockedTime){
            echo "<center><b><font color=\"red\">KONTO ZABLOKOWANE<br>Wpisano błędne hasło 3 razy!<br>Zostanie odblokowane: ",date("Y-m-d H:i:s ", $blockedTime),"</font></b></center>"; 
            sleep(5);
            echo "<script>location.href='wyloguj.php';</script>";
            }else{
 if ((!isset($_COOKIE['user'])) || ($_COOKIE['user']!=$wiersz['id'])){
            setcookie("user", $wiersz['id'], mktime(23,59,59,date("m"),date("d"),date("Y")));
            setcookie("user_n", $wiersz['login'], mktime(23,59,59,date("m"),date("d"),date("Y")));
    }
          $zapytanie="INSERT INTO logi VALUES (NULL,$idu,'$ip','$godzina')";
          mysqli_query($polaczenie, $zapytanie);
          $zapytanie="UPDATE logiblad SET proba='0' WHERE idu='$idu'";
          mysqli_query($polaczenie, $zapytanie);
          $target="pliki.php";
          header("Location: $target");
 }}else{
      if ((!isset($_COOKIE['user'])) || ($_COOKIE['user']!=$wiersz['id'])){
            setcookie("user", $wiersz['id'], mktime(23,59,59,date("m"),date("d"),date("Y")));
            setcookie("user_n", $wiersz['login'], mktime(23,59,59,date("m"),date("d"),date("Y")));
    }
          $zapytanie="INSERT INTO logi VALUES (NULL,$idu,'$ip','$godzina')";
          mysqli_query($polaczenie, $zapytanie);
          $zapytanie="UPDATE logiblad SET proba='0' WHERE idu='$idu'";
          mysqli_query($polaczenie, $zapytanie);
          $target="pliki.php";
          header("Location: $target");
 }}
 else
 {
      $proba=$wiersz1['proba'];
     if ($proba=='2'){
              $proba="b-" . strtotime("+1 minutes", time());
              $zapytanie="UPDATE logiblad SET proba='$proba',datagodzina='$godzina' WHERE idu='$idu'";
              mysqli_query($polaczenie, $zapytanie);
          }
          if(substr($proba, 0, 2) == "b-"){
            $blockedTime = substr($proba, 2);
            if(time() < $blockedTime){
            echo "<center><b><font color=\"red\">KONTO ZABLOKOWANE<br>Wpisano błędne hasło 3 razy!<br>Zostanie odblokowane: ",date("Y-m-d H:i:s ", $blockedTime),"</font></b></center>"; 
            }else{
                $zapytanie="UPDATE logiblad SET proba='1',datagodzina='$godzina' WHERE idu='$idu'";
                mysqli_query($polaczenie, $zapytanie);
                echo "<center><b>Niepoprawne hasło!<br><br></b></center>";
                echo "<script>location.href='wyloguj.php';</script>";
            }}else{  
            if (IsSet($wiersz1)){
                $proba=$wiersz1['proba']+1;
                $zapytanie="UPDATE logiblad SET proba='$proba',datagodzina='$godzina' WHERE idu='$idu'";
                mysqli_query($polaczenie, $zapytanie);
                echo "<center><b>Niepoprawne hasło!<br><br></b></center>";
                echo "<script>location.href='wyloguj.php';</script>";
            }else{
         $proba=$wiersz1['proba']+1;
          $zapytanie="INSERT INTO logiblad VALUES (NULL,$idu,'$ip','$godzina','$proba')";
          mysqli_query($polaczenie, $zapytanie);
          echo "<center><b>Niepoprawne hasło!<br><br></b></center>";
            }
            }
 mysqli_close($polaczenie);
 echo "<center><a href=\"wyloguj.php\"><input type=\"submit\" value=\"Powrót\"></a></center>";
 }
}
?>
