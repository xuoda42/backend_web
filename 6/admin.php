<html><head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="style.css" >
</head></html>

<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != 'admin' ||
    md5($_SERVER['PHP_AUTH_PW']) != md5('123')) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

echo "<div class='container mb-1 mt-1' id='for'>Вы успешно авторизовались и видите защищенные паролем данные. </div>";
echo "<div class='container mb-1 mt-1' id='for'> Нажмите <a href='./'>сюда</a> для выхода.</div>";
$host='localhost';
$user = 'u16350';
$password = '1871497';
$db_name = 'u16350';   // Имя базы данных
$link = mysqli_connect($host, $user, $password, $db_name);;

$err=0;

$sql = mysqli_query($link, 'SELECT * FROM application');
$number=1;
while ($result = mysqli_fetch_array($sql)) { echo "<div class='container mb-1 mt-1' id='for'>";
    echo " Информация по $number-му пользователю: ";
    echo " <p> Айди: "; echo "<strong>"; echo  $result['id']; echo "</strong>";
    echo " <p> Имя: "; echo "<strong>"; echo  $result['name']; echo "</strong>";
    echo " <p> Почтовый адрес: ";echo "<strong>"; echo  $result['mail']; echo "</strong>";
    echo " <p> Год рождения: "; echo "<strong>"; echo  $result['year']; echo "</strong>";
    
    echo " <p> Выбранные способности: "; 
    $num=0;
    $pos = strpos($result['abilities'], "Levitation"); 
    if ($pos!==false){echo "<strong>"; echo  "Левитация"; echo "</strong>"; $num=$num+1;}
    $pos1 = strpos($result['abilities'], "Walls");
    if ($pos1!==false){if ($num==0){echo "<strong>";  echo  "Умение ходить сквозь стены "; echo "</strong>";} else {echo "<strong>"; echo ", Умение ходить сквозь стены";echo "</strong>";} $num=$num+1; }
    $pos2 = strpos($result['abilities'], "Immortal");
    if ($pos2!==false){if ($num==0){ echo "<strong>"; echo  "Бессмертие"; echo "</strong>";} else{ echo "<strong>"; echo ", Бессмертие"; echo "</strong>";} $num=$num+1; }
    
    echo " <p> Количество конечностей: "; echo "<strong>"; echo  $result['limps']; echo "</strong>";
    echo " <p> Пол: "; echo "<strong>"; echo  $result['sex']; echo "</strong>";
    echo "<p> Биография: "; echo "<strong >"; echo  $result['bio'];echo "</strong>";
    echo "<p> С условиями согласен: "; if ($result['checked']=='T'){echo "<strong>"; echo "Согласен";echo "</strong>";} else{ echo "<strong>"; echo "Не согласен!"; echo "</strong>";}
    echo "<p> Логин: ";echo "<strong>"; echo  $result['login']; echo "</strong>";
    echo "<p> Пароль: ";echo "<strong>"; echo  $result['pass']; echo "</strong>"; $number=$number+1; 
    $id=$result['id'];;
    $part="pple";
    $link="http://u16350.kubsu-dev.ru/web6/del.php?id=$id";
    $del=$result['id'];
    echo "<p> <a href=$link> <button> Удалить пользователя из базы данных </button> </a>";
    
    echo "</div>";
}

// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********
