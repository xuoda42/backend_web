<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('Спасибо, результаты сохранены.');
  }
  include('form.php');
  exit();
}

$errors = FALSE;
if (empty($_POST['fio'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
}
if (empty($_POST['email'])) {
  print('Заполните электронную почту.<br/>');
  $errors = TRUE;
}
if (empty($_POST['birth_date'])) {
  print('Заполните год рождения.<br/>');
  $errors = TRUE;
}
if (!isset($_POST['limb'])) {
  print('Выберите количествово конечностей.<br/>');
  $errors = TRUE;
}
if (!isset($_POST['gender'])) {
  print('Выберите пол.<br/>');
  $errors = TRUE;
}
if (empty($_POST['biography'])) {
  print('Заполните биографию.<br/>');
  $errors = TRUE;
}
if (empty($_POST['checkbox'])) {
  print('Подтвердите согласие.<br/>');
  $errors = TRUE;
}

if ($errors) {
  exit();
}

$user = 'u41029';
$pass = '3452334';
$db = new PDO('mysql:host=localhost;dbname=u41029', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

$stmt = $db->prepare("INSERT INTO form (name, email, year, gender, limb, bio, checkbox) VALUES (:fio, :email, :birth_date, :gender, :limb, :bio, :checkbox)");
$stmt -> execute(array('fio'=>$_POST['fio'], 'email'=>$_POST['email'], 'birth_date'=>$_POST['birth_date'],'gender'=>$_POST['gender'],'limb'=>$_POST['limb'],'bio'=>$_POST['biography'],'checkbox'=>$_POST['checkbox']));

$form_id =  $db->lastInsertId();
$myselect = $_POST['select'];
if (!empty($myselect)) {
  foreach ($myselect as $ability) {
    if (!is_numeric($ability)) {
      continue;
    }
    $stmt = $db->prepare("INSERT INTO ability (form_id, ability_id) VALUES (:form_id, :ability_id)");
    $stmt -> execute(array(
      'form_id' => $form_id,
      'ability_id' => $ability
    ));  
  }
}

header('Location: ?save=1');

