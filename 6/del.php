<?php
if(isset($_GET['id']))
{   
    $host='localhost';
    $user = 'u41029';
    $password = '3452334';
    $db_name = 'u41029'; 
    $link = mysqli_connect($host, $user, $password, $db_name) 
            or die("Ошибка " . mysqli_error($link)); 
    $id = mysqli_real_escape_string($link, $_GET['id']);
     
    $query ="DELETE FROM application WHERE id = '$id'";
 
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    mysqli_close($link);
}

header('Location: admin.php'); 
?>