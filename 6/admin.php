<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">

  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&family=Poppins:wght@500&display=swap" rel="stylesheet"> 

  <title>Задание 6</title>
</head>
<body>
  <div class="main">
<?php
  if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) || 
    !empty($_GET['logout'])) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="Enter login and password"');
    if (!empty($_GET['logout']))
      header('Location: admin.php');
    print('<h1>401 Требуется авторизация</h1></div></body>');
    exit();
  }

  $user = 'u41029';
  $pass = '3452334';
  $db = new PDO('mysql:host=localhost;dbname=u41029', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  
  $login = trim($_SERVER['PHP_AUTH_USER']);
  $pass_hash = substr(hash("sha256", trim($_SERVER['PHP_AUTH_PW'])), 0, 20);
  $stmtCheck = $db->prepare('SELECT admin_pass_hash FROM admin_login_data WHERE admin_login = ?');
  $stmtCheck->execute([$login]);
  $row = $stmtCheck->fetch(PDO::FETCH_ASSOC);
  if ($row == false || $row['admin_pass_hash'] != $pass_hash) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="Invalid login or password"');
    print('<h1>401 Неверный логин или пароль</h1>');
    exit();
  }
?>
    <section>
        <h2>Администрирование</h2>
        <a href="login.php">Выйти</a>
    </section>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // пароль qwerty
  
  $stmtCount = $db->prepare('SELECT ability_name, count(ab.form_id) AS amount FROM abilities_name AS am LEFT JOIN ability AS ab ON am.ability_id = ab.ability_id GROUP BY am.ability_id');
  $stmtCount->execute();
  print('<section>');
  while($row = $stmtCount->fetch(PDO::FETCH_ASSOC)) {
      print('<b>' . $row['ability_name'] . '</b>: ' . $row['amount'] . '<br/>');
  }
  print('</section>');

  $stmt1 = $db->prepare('SELECT form_id, name, email, birthday, sex, limbs, bio, login FROM forms');
  $stmt2 = $db->prepare('SELECT ability_id FROM ability WHERE form_id = ?');
  $stmt1->execute();

  while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      print('<section>');
      print('<h2>' . $row['login'] . '</h2>');
      $superpowers = [false, false, false];
      $stmt2->execute([$row['form_id']]);
      while ($superrow = $stmt2->fetch(PDO::FETCH_ASSOC)) {
          $superpowers[$superrow['ability_id']] = true;
      }
      foreach ($row as $key => $value)
        if (is_string($value))
          $row[$key] = strip_tags($value);
      include('adminform.php');
      print('</section>');
  }
} else {
  if (array_key_exists('delete', $_POST)) {
    $user = 'u41029';
    $pass = '3452334';
    $db = new PDO('mysql:host=localhost;dbname=u41029', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    $stmt1 = $db->prepare('DELETE FROM ability WHERE form_id = ?');
    $stmt1->execute([$_POST['uid']]);
    $stmt2 = $db->prepare('DELETE FROM forms WHERE form_id = ?');
    $stmt2->execute([$_POST['uid']]);
    header('Location: admin.php');
    exit();
  }

  $trimmedPost = [];
  foreach ($_POST as $key => $value)
    if (is_string($value))
      $trimmedPost[$key] = trim($value);
    else
      $trimmedPost[$key] = $value;

  if (empty($trimmedPost['name'])) {
    $hasErrors = TRUE;
  }
  $values['name'] = strip_tags($trimmedPost['name']);

  if (!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $trimmedPost['email'])) {
    $hasErrors = TRUE;
  }
  $values['email'] = strip_tags($trimmedPost['email']);

  if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $trimmedPost['birthday'])) {
    $hasErrors = TRUE;
  }
  $values['birthday'] = strip_tags($trimmedPost['birthday']);

  if (!preg_match('/^[MFO]$/', $trimmedPost['gender'])) {
    $hasErrors = TRUE;
  }
  $values['gender'] = strip_tags($trimmedPost['gender']);

  if (!preg_match('/^[0-5]$/', $trimmedPost['limbs'])) {
    $hasErrors = TRUE;
  }
  $values['limbs'] = strip_tags($trimmedPost['limbs']);

  foreach (['0', '1', '2'] as $value) {
    $values['superpowers'][$value] = FALSE;
  }
  if (array_key_exists('superpowers', $trimmedPost)) {
    foreach ($trimmedPost['superpowers'] as $value) {
      if (!preg_match('/[0-2]/', $value)) {
        $hasErrors = TRUE;
      }
      $values['superpowers'][$value] = TRUE;
    }
  }
  $values['biography'] = strip_tags($trimmedPost['biography']);
  

  if ($hasErrors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: admin.php');
    exit();
  }

  $user = 'u41029';
  $pass = '3452334';
  $db = new PDO('mysql:host=localhost;dbname=u41029', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  $stmt1 = $db->prepare('UPDATE forms SET name=?, email=?, birthday=?, sex=?, limbs=?, bio=? WHERE form_id = ?');
  $stmt1->execute([$values['name'], $values['email'], $values['birthday'], $values['gender'], $values['limbs'], $values['biography'], $_POST['uid']]);

  $stmt2 = $db->prepare('DELETE FROM ability WHERE form_id = ?');
  $stmt2->execute([$_POST['uid']]);

  $stmt3 = $db->prepare("INSERT INTO ability SET form_id = ?, ability_id = ?");
  foreach ($trimmedPost['superpowers'] as $s)
    $stmt3 -> execute([$_POST['uid'], $s]);

  header('Location: admin.php');
  exit();
}

?>
</div>
</body>
