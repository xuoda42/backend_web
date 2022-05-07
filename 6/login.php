<html>
<head>
    
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="style.css" >

  </head>
  <body>

<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Начинаем сессию.
session_start();

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
if (!empty($_SESSION['login'])) {
  // Если есть логин в сессии, то пользователь уже авторизован.
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()
  //при нажатии на кнопку Выход).
  

    
  // Делаем перенаправление на форму.
 
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
<div class="container align-self-center">
<form  action="" method="post" id="form-top">
<div id="for">
<div class="row" >
	<h5 class="col"> Введите ваш логин:</h5>
  <input class="col" name="login" />
  </div>
  
  <div class="row"> <h5 class="col"> Введите ваш пароль:</h5>
  <input class="col" name="pass" />
  </div>
  
  <div class="row">
  <input class="col" type="submit" value="Войти" />
  </div></div>
</form>
</div>
</body> 
</html>


<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {

  // TODO: Проверть есть ли такой логин и пароль в базе данных.
    $host='localhost';
    $user = 'u41029';
    $password = '3452334';
    $db_name = 'u41029';   // Имя базы данных
    $link = mysqli_connect($host, $user, $password, $db_name);;
    
    $err=0;
    
    $sql = mysqli_query($link, 'SELECT * FROM application');
    while ($result = mysqli_fetch_array($sql)) {
        $cashed=md5($_POST['pass']);
        if ($result['login']==$_POST['login'] && $result['pass']==$cashed){
  // Выдать сообщение об ошибках.
  
  // Если все ок, то авторизуем пользователя.
  $_SESSION['login'] = $_POST['login'];
  // Записываем ID пользователя.
  $_SESSION['uid'] = 123;

  // Делаем перенаправление.
  header('Location: ./'); 
        }
        else{$err=1;
            
        }
    }if ($err==1){echo "<div class='container' id='notify'> <h2 id='for'> Таких учетных данных нет в базе данных.  Нажмите <a href='login.php'> сюда </a>, чтобы попробовать войти снова. </h2> </div>";}
}


