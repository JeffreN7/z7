<?php
$usr=$_COOKIE['user_n'];
$sciezka=$_POST['folder'];
if (is_uploaded_file($_FILES['plik']['tmp_name']))
{
    if(IsSet($sciezka)){
        move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."Z7/users/$usr/$sciezka/".$_FILES['plik']['name']);
    }else{
     move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."Z7/users/$usr/".$_FILES['plik']['name']);
    }
}
header("Location: pliki.php");
?>