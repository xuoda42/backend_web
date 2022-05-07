<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
$user = 'u41029';
$pass = '3452334';
$db = new PDO('mysql:host=localhost;dbname=u41029', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

$result = $db->query("SELECT login FROM admin");
foreach($result as $r)
{
  $login = $r['login'];
}

$result = $db->query("SELECT pass FROM admin");
foreach($result as $r)
{
  $pass = $r['pass'];
}

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
  $messages = array();
  $errors = array();
  $errors['error'] = !empty($_COOKIE['id_error']);
  if ($errors['error'])
  {
    setcookie('id_error','',100000);
    $messages[]='<div class="error">id удаляемого = id редактированного или они пустые!!!</div>'; 
  }
  
  if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != $login ||
    md5($_SERVER['PHP_AUTH_PW']) != $pass)
    {
      header('HTTP/1.1 401 Unanthorized');
      header('WWW-Authenticate: Basic realm="My site"');
      print('<h1>401 Требуется авторизация</h1>');
      exit();
    }

  print('Вы успешно авторизовались и видите защищенные паролем данные.');

  $result = $db->query("SELECT * FROM person");
  $draw = $db->query("SELECT count(*) FROM person_talents WHERE id_talent=1");
  $sing = $db->query("SELECT count(*) FROM person_talents WHERE id_talent=2");
  $trouble = $db->query("SELECT count(*) FROM person_talents WHERE id_talent=3");
  $find = $db->query("SELECT count(*) FROM person_talents WHERE id_talent=4");
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
    <table border="2">
      <tr>
        <th>id</th>
        <th>Имя</th>
        <th>email</th>
        <th>Дата рождения</th>
        <th>Пол</th>
        <th>IQ</th>
        <th>О пользователе</th>
      </tr>
      <?php foreach($result as $r) 
        { ?>
      <tr>
        <td><?php print $r['id'];?></td>
        <td><?php print $r['name'];?></td>
        <td><?php print $r['email'];?></td>
        <td><?php print $r['birth'];?></td>
        <td><?php print $r['gender'];?></td>
        <td><?php print $r['iq'];?></td>
        <td><?php print $r['comment'];?></td>
      </tr>
      <?php } ?>
    </table>
    <table border="2">
          <tr>
            <th>Рисование</th>
            <th>Пение</th>
            <th>Попадание в неприятности</th>
            <th>Нахождение второго носка</th>
          </tr>
          <tr>
            <td>
              <?php foreach($draw as $dr) {print($dr['count(*)']);} ?>
            </td>
            <td>
              <?php foreach($sing as $dr) {print($dr['count(*)']);} ?>
            </td>
            <td>
              <?php foreach($trouble as $dr) {print($dr['count(*)']);} ?>
            </td>
            <td>
              <?php foreach($find as $dr) {print($dr['count(*)']);} ?>
            </td>
          </tr>
    </table>
    </br>
    <form action="" method="POST">
          <label>
            Редактирование </br>
            <input name="id1" />
          </label>
          </br>
          <label>
            Удаление </br>
            <input name="id2" />
          </label>
          <input type="submit" value="Подтвердить" />
    </form>

    <?php 

}
else
{
  $errors = false;
  if ($_POST['id1']==$_POST['id2'])
  {
    setcookie('id_error','1', time() + 24*60*60);
    $errors = true;
  }
  if($errors){
    header('Location: admin.php');
    exit();
  }
  else{
    setcookie('id_error','',100000);
  }

  if (!empty($_POST['id2']))
  {
    $id = (int) $_POST['id2'];
    $db->query("DELETE FROM person_talents WHERE id_person=$id");
    $db->query("DELETE FROM logpass WHERE id=$id");
    $db->query("DELETE FROM person WHERE id=$id");
    header('Location: admin.php');
  }

  if (!empty($_POST['id1']))
  {
    session_start();
    $_SESSION['uid'] = (int) $_POST['id1'];
    $_SESSION['login'] = 'lala';
    header('Location: ./');
  }
  
}




// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********
