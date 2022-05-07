<?php
/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    setcookie('log', '', 100000);
    setcookie('pass', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
    if (!empty($_COOKIE['pass'])) {
      $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass']));
    }
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['field-name-1'] = !empty($_COOKIE['field-name-1_error']);
  $errors['field-email'] = !empty($_COOKIE['field-email_error']);
  $errors['field-date'] = !empty($_COOKIE['field-date_error']);
  $errors['radio-group-1'] = !empty($_COOKIE['radio-group-1_error']);
  $errors['radio-group-iq'] = !empty($_COOKIE['radio-group-iq_error']);
  $errors['field-name-talents'] = !empty($_COOKIE['field-name-talents_error']);
  $errors['field-name-4'] = !empty($_COOKIE['field-name-4_error']);
  $errors['check-1'] = !empty($_COOKIE['check-1_error']);
  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['field-name-1']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('field-name-1_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя ваше имя корректно.</div>';
  }
  if ($errors['field-email']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('field-email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните e-mail.</div>';
  }
  if ($errors['radio-group-1']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('radio-group-1_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Выберите ваш пол</div>';
  }
  if ($errors['radio-group-iq']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('radio-group-iq_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Выберите ваш IQ</div>';
  }
  if ($errors['field-name-talents']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('field-name-talents_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Выберите ваши таланты</div>';
  }
  if ($errors['field-name-4']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('field-name-4_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Напишите что-нибудь о себе</div>';
  }
  if ($errors['check-1']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('check-1_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Согласитесь с нами</div>';
  }
  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['field-name-1'] = empty($_COOKIE['field-name-1_value']) ? '' : $_COOKIE['field-name-1_value'];
  $values['field-email'] = empty($_COOKIE['field-email_value']) ? '' : $_COOKIE['field-email_value'];
  $values['field-date'] = empty($_COOKIE['field-date_value']) ? '' : $_COOKIE['field-date_value'];
  $values['radio-group-1'] = empty($_COOKIE['radio-group-1_value']) ? '' : $_COOKIE['radio-group-1_value'];
  $values['radio-group-iq'] = empty($_COOKIE['radio-group-iq_value']) ? '' : $_COOKIE['radio-group-iq_value'];
  $values['field-name-talents'] = empty($_COOKIE['field-name-talents_value']) ? '' : $_COOKIE['field-name-talents_value'];
  $values['field-name-4'] = empty($_COOKIE['field-name-4_value']) ? '' : $_COOKIE['field-name-4_value'];

  $er=false;
  foreach ($errors as $x)
    if ($x)
      $er=true;
  if ($er==false && !empty($_COOKIE[session_name()]) &&
  session_start() && !empty($_SESSION['login'])) {
  // TODO: загрузить данные пользователя из БД
  // и заполнить переменную $values,
  // предварительно санитизовав.
    $user = 'u41029';
    $pass = '3452334';
    $db = new PDO('mysql:host=localhost;dbname=u41029', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    $uid = $_SESSION['uid'];
    $result = $db->query("SELECT * FROM person WHERE id=$uid");
    foreach($result as $x)
    {
      //Санитизация
      $values['field-name-1'] = strip_tags($x['name']);
      $values['field-email'] = strip_tags($x['email']);
      $values['field-date'] = strip_tags($x['birth']);
      $values['radio-group-1'] = strip_tags($x['gender']);
      $values['radio-group-iq'] = strip_tags($x['iq']);
      $values['field-name-4'] = strip_tags($x['comment']);
    }
    $result = $db->query("SELECT id_talent FROM person_talents WHERE id_person=$uid");
    $tale = array();
    foreach ($result as $x)
    {
      $tale[]=(int) strip_tags($x['id_talent']);
    }
    $tt=implode('',$tale);
    $values['field-name-talents'] = $tt;
    printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
  }
  // TODO: аналогично все поля.

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;

  if (empty($_POST['field-name-1']) || preg_match('/[^(\x7F-\xFF)|(\s)]/', $_POST['field-name-1'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('field-name-1_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('field-name-1_value', $_POST['field-name-1'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['field-email'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('field-email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('field-email_value', $_POST['field-email'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['field-date'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('field-date_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('field-date_value', $_POST['field-date'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['radio-group-1'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('radio-group-1_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('radio-group-1_value', $_POST['radio-group-1'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['radio-group-iq'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('radio-group-iq_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('radio-group-iq_value', $_POST['radio-group-iq'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['field-name-talents'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('field-name-talents_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    $t = implode("",$_POST['field-name-talents']);
    setcookie('field-name-talents_value', $t, time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['field-name-4'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('field-name-4_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('field-name-4_value', $_POST['field-name-4'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['check-1'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('check-1_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  

// *************
// TODO: тут необходимо проверить правильность заполнения всех остальных полей.
// Сохранить в Cookie признаки ошибок и значения полей.
// *************

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('field-name-1_error', '', 100000);
    setcookie('field-email_error', '', 100000);
    setcookie('field-date_error', '', 100000);
    setcookie('radio-group-1_error', '', 100000);
    setcookie('radio-group-iq_error', '', 100000);
    setcookie('field-name-talents_error', '', 100000);
    setcookie('field-name-4_error', '', 100000);
    setcookie('check-1_error', '', 100000);
    // TODO: тут необходимо удалить остальные Cookies.
  }

  $user = 'u41029';
  $pass = '3452334';
  $db = new PDO('mysql:host=localhost;dbname=u41029', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
    // TODO: перезаписать данные в БД новыми данными,
    // кроме логина и пароля.
    $uid = $_SESSION['uid'];
    $stmt = $db->prepare("UPDATE person SET name=?, email=?, birth=?, gender=?, iq=?, comment=? WHERE id=$uid");
    $stmt -> execute([$_POST['field-name-1'],$_POST['field-email'],$_POST['field-date'],
    $_POST['radio-group-1'],$_POST['radio-group-iq'],$_POST['field-name-4']]);
    $db->query("DELETE FROM person_talents WHERE id_person=$uid");
    $stmt = $db->prepare("INSERT INTO person_talents SET id_person = ?,id_talent = ?");
    foreach ($_POST['field-name-talents'] as $x)
        $stmt -> execute([$uid,$x]);
  }
  else {
    // Генерируем уникальный логин и пароль.
    // TODO: сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
    $login = substr(uniqid(),1,10);
    $pass = substr(md5(time()),1,5);
    // Сохраняем в Cookies.
    setcookie('login', $login);
    setcookie('pass', $pass);
    $stmt = $db->prepare("INSERT INTO person SET name = ?, email = ?, birth = ?, gender = ?, iq = ?, comment = ?");
    $n = $_POST['field-name-1'];
    $e = $_POST['field-email'];
    $b = $_POST['field-date'];
    $p = $_POST['radio-group-1'];
    $iq = $_POST['radio-group-iq'];
    $com = $_POST['field-name-4'];
    $stmt -> execute([$n, $e, $b, $p, $iq, $com]);
    $id=$db->lastInsertId();
    $stmt = $db->prepare("INSERT INTO person_talents SET id_person = ?, id_talent = ?");
    foreach ($_POST['field-name-talents'] as $x)
      $stmt -> execute([$id,$x]);
    $stmt = $db->prepare("INSERT INTO logpass SET id=?, login=?, pass=?");
    $p = md5($pass);
    $stmt -> execute([$id,$login,$p]);

    // TODO: Сохранение данных формы, логина и хеш md5() пароля в базу данных.
    // ...
  }

  // Сохранение в XML-документ.
  

  // Подготовленный запрос. Не именованные метки.
 


  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}
