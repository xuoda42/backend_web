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
if (empty($_SESSION['token']))
  $_SESSION['token'] = bin2hex(random_bytes(32));

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
if (!empty($_SESSION['login'])) {
  session_destroy();
  // Если есть логин в сессии, то пользователь уже авторизован.
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()
  //при нажатии на кнопку Выход).
  // Делаем перенаправление на форму.
  header('Location: ./');
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  
  $messages=array();
  $errors=array();
  $errors['log_pass']=!empty($_COOKIE['log_pass_error']);
  if($errors['log_pass'])
  {
    setcookie('log_pass_error', '', 100000);
    $messages[]='<div class="error">Неверный логин или пароль</div>';
  }
?>
<style>
.error {
      border: 2px solid red;
    }
    </style>
    <?php
      if (!empty($messages)) {
        print('<div id="messages">');
        // Выводим все сообщения.
        foreach ($messages as $message) {
          print($message);
        }
        print('</div>');
    }
    ?>
<form action="" method="post">
<a href="admin.php">Админ?</a>
  Логин
  <input name="login"  <?php if ($errors['log_pass']) {print 'class="error"';} ?>/>
  Пароль
  <input name="pass" type="password" <?php if ($errors['log_pass']) {print 'class="error"';} ?>/>
  <input type="hidden" name="token" value="<?php print $_SESSION['token']; ?>" />
  <input type="submit" value="Войти" />
  
</form>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else 
{
  if ($_POST['token']===$_SESSION['token'])
  {
    $errors = false;
    // TODO: Проверть есть ли такой логин и пароль в базе данных.
    // Выдать сообщение об ошибках.
    $user = 'u41029';
    $pass = '3452334';
    $db = new PDO('mysql:host=localhost;dbname=u41029', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    $log = $db->quote($_POST['login']);
    $pas = md5($_POST['pass']);
    $result = $db->query("SELECT login,pass FROM logpass WHERE login = $log");
    foreach ($result as $x)
    {
      $log2 = $db->quote($x['login']);
      $pas2 = $x['pass'];
    }
    if (!empty($log2) && !empty($pas2) && $pas==$pas2)
    {
      $pas2 = $db->quote($x['pass']);
      // Если все ок, то авторизуем пользователя.
      $_SESSION['login'] = $_POST['login'];
      $result = $db->query("SELECT id FROM logpass WHERE login = $log2 AND pass = $pas2");
      foreach ($result as $x)
        $id=(int) $x['id'];
      // Записываем ID пользователя.
      $_SESSION['uid'] = $id;
    }
    else 
    {
      $errors=true;
      setcookie('log_pass_error', '1', time() + 24 * 60 * 60);
    }
    if ($errors)
    {
      header('Location: login.php');
      exit();
    }
    else 
    {
      // Удаляем Cookies с признаками ошибок.
      setcookie('log_pass_error', '', 100000);
    }
  

    

    // Делаем перенаправление.
    header('Location: ./');
  }
  else exit();
}