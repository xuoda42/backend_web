<?php
/**
 * Интернет-программирование. Задача 8.
 * Реализовать скрипт на веб-сервере на PHP или другом языке,
 * сохраняющий в XML-файл заполненную форму задания 7. При
 * отправке формы на сервере создается новый файл с уникальным именем.
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
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = "<div class='container mb-1 mt-1' id='for'> <h4>Спасибо, результаты сохранены.</h4> </div>";
    
    if (!empty($_COOKIE['pass'])) {
        $messages[] = sprintf("<div class='container mb-1 mt-1' id='for'> <h4> Вы можете <a href='login.php'>войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных. </h4> </div>",
            strip_tags($_COOKIE['login']),
            strip_tags($_COOKIE['pass']));
    }
  }
  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['mail'] = !empty($_COOKIE['mail_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['abilities'] = !empty($_COOKIE['abilities_error']);
  $errors['limps'] = !empty($_COOKIE['limps_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['checkbox'] = !empty($_COOKIE['checkbox_error']);
  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['fio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('fio_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="container-fluid" id="error"> <snap class="col"> Не заполнено имя... </snap></div>';
  }

  if ($errors['mail']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('mail_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="container-fluid" id="error"> <snap class="col"> Не заполнен почтовый адрес... </snap> </div>';
  }

  if ($errors['year']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('year_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="container-fluid" id="error"> <snap class="col">Не указана дата... </snap></div>';
  }

  if ($errors['abilities']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('abilities_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="container-fluid" id="error"> <snap class="col"> Не выбраны суперспособности... </snap></div>';
  }
  
  if ($errors['limps']) {
      // Удаляем куку, указывая время устаревания в прошлом.
      setcookie('limps_error', '', 100000);
      // Выводим сообщение.
      $messages[] = '<div class="container-fluid" id="error"> <snap class="col"> Не выбрано количество конечностей... </snap> </div>';
  }
  
  if ($errors['sex']) {
      // Удаляем куку, указывая время устаревания в прошлом.
      setcookie('sex_error', '', 100000);
      // Выводим сообщение.
      $messages[] = '<div class="container-fluid" id="error"> <snap class="col"> Не выбран пол... </snap> </div>';
  }
  
  if ($errors['bio']) {
      // Удаляем куку, указывая время устаревания в прошлом.
      setcookie('bio_error', '', 100000);
      // Выводим сообщение.
      $messages[] = '<div class="container-fluid" id="error"> <snap class="col"> Не расписана биография... </snap> </div>';
  }
  
  if ($errors['checkbox']) {
      // Удаляем куку, указывая время устаревания в прошлом.
      setcookie('checkbox_error', '', 100000);
      // Выводим сообщение.
      $messages[] = '<div class="container-fluid" id="error"> <snap class="col"> Не проставлен чекбокс... </snap> </div>';
  }
  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $ability = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['mail'] = empty($_COOKIE['mail_value']) ? '' : $_COOKIE['mail_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
 // $values['abilities'] = empty($_COOKIE['abilities_value']) ? '' : $_COOKIE['abilities_value'];
  $ability['first'] = empty($_COOKIE['abilities_value']) ? '' : $_COOKIE['abilities_value'];
  $ability['second'] = empty($_COOKIE['abilities_value2']) ? '' : $_COOKIE['abilities_value2'];
  $ability['third'] = empty($_COOKIE['abilities_value3']) ? '' : $_COOKIE['abilities_value3'];
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['checkbox'] = empty($_COOKIE['checkbox_value']) ? '' : $_COOKIE['checkbox_value'];
  $values['limps'] = empty($_COOKIE['limps_value']) ? '' : $_COOKIE['limps_value'];
  // TODO: аналогично все поля.
  
  // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
  // ранее в сессию записан факт успешного логина.
  if (!empty($errors) && !empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
          // TODO: загрузить данные пользователя из БД
          // и заполнить переменную $values,
          // предварительно санитизовав.
          
          
          
          $host='localhost';
          $user = 'u41029';
          $password = '3452334';
          $db_name = 'u41029';   // Имя базы данных
          $link = mysqli_connect($host, $user, $password, $db_name);;
          
          $sql = mysqli_query($link, 'SELECT * FROM application');
          while ($result = mysqli_fetch_array($sql)) {
              if ($result['login']==$_SESSION['login']) {
                  $values['fio']=$result['name'];
                  $values['mail']=$result['mail'];
                  $values['year']=$result['year'];
                  $values['sex']=$result['sex'];
                  $values['bio']=$result['bio'];
                  $values['checkbox']=$result['checked'];
                  $values['limps']=$result['limps'];
                  setcookie('fio_value', '', 100000);
                  setcookie('mail_value', '', 100000);
                  setcookie('year_value', '', 100000);
                  setcookie('sex_value', '', 100000);
                  setcookie('limps_value', '', 100000);
                  setcookie('bio_value', '', 100000);
                  setcookie('checkbox_value', '', 100000);
              }
          }
          
      }

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
else{
$errors = FALSE;
if (empty($_POST['fio'])) {
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['mail'])) {
    setcookie('mail_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('mail_value', $_POST['mail'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['year'])) {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['abilities'])) {
    setcookie('abilities_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    if ($_POST['abilities'] == 'Immortal')
    setcookie('abilities_value', $_POST['abilities'], time() + 30 * 24 * 60 * 60);
    if ($_POST['abilities'] == 'Walls')
    setcookie('abilities_value2', $_POST['abilities'], time() + 30 * 24 * 60 * 60);
    if ($_POST['abilities'] == 'Levitation')
    setcookie('abilities_value3', $_POST['abilities'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['limps'])) {
    setcookie('limps_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('limps_value', $_POST['limps'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['sex'])) {
    setcookie('sex_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('sex_value', $_POST['sex'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['bio'])) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['checkbox'])) {
    setcookie('checkbox_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('checkbox_value', $_POST['checkbox'], time() + 30 * 24 * 60 * 60);
}


$abilities=serialize($_POST['abilities']);

//$abilities = serialize($_POST['abilities']);

// *************
// Тут необходимо проверить правильность заполнения всех остальных полей.
// *************

if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
}
else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('fio_error', '', 100000);
    setcookie('mail_error', '', 100000);
    setcookie('year_error', '', 100000);
    setcookie('abilities_error', '', 100000);
    setcookie('sex_error', '', 100000);
    setcookie('limps_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('checkbox_error', '', 100000);
    // TODO: тут необходимо удалить остальные Cookies.
}
// Сохранение в базу данных.

// Проверяем меняются ли ранее сохраненные данные или отправляются новые.
if (!empty($_COOKIE[session_name()]) &&
    session_start() && !empty($_SESSION['login'])) {
        // TODO: перезаписать данные в БД новыми данными,
        // кроме логина и пароля.
        
        setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
        setcookie('mail_value', $_POST['mail'], time() + 30 * 24 * 60 * 60);
        setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
        setcookie('sex_value', $_POST['sex'], time() + 30 * 24 * 60 * 60);
        setcookie('limps_value', $_POST['limps'], time() + 30 * 24 * 60 * 60);
        setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
        setcookie('checkbox_value', $_POST['checkbox'], time() + 30 * 24 * 60 * 60);
        
        $user = 'u41029';
        $password = '3452334';
        $log=$_SESSION['login'];
        $db = new PDO('mysql:host=localhost;dbname=u41029', $user, $password, array(PDO::ATTR_PERSISTENT => true));
        
        try {
            $stmt = $db->prepare("UPDATE application SET name = ?, mail = ?, year = ?, abilities = ?, limps = ?, sex = ?, bio = ?, checked = ? WHERE login='$log'");
            $stmt -> execute(array($_POST['fio'], $_POST['mail'], $_POST['year'], $abilities, $_POST['limps'], $_POST['sex'], $_POST['bio'],  $_POST['checkbox']));
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
    }
    else {
        // Генерируем уникальный логин и пароль.
        // TODO: сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        $login = substr(str_shuffle($permitted_chars), 0, 16);
        $pass = substr(str_shuffle($permitted_chars), 0, 16);
        // Сохраняем в Cookies.
        setcookie('login', $login);
        setcookie('pass', $pass);
        setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
        setcookie('mail_value', $_POST['mail'], time() + 30 * 24 * 60 * 60);
        setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
        setcookie('sex_value', $_POST['sex'], time() + 30 * 24 * 60 * 60);
        setcookie('limps_value', $_POST['limps'], time() + 30 * 24 * 60 * 60);
        setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
        setcookie('checkbox_value', $_POST['checkbox'], time() + 30 * 24 * 60 * 60);
        $cashed=md5($pass);
        $user = 'u41029';
        $password = '3452334';
        $db = new PDO('mysql:host=localhost;dbname=u41029', $user, $password, array(PDO::ATTR_PERSISTENT => true));
        // Подготовленный запрос. Не именованные метки.
        try {
            $stmt = $db->prepare("INSERT INTO application SET name = ?, mail = ?, year = ?, abilities = ?, limps = ?, sex = ?, bio = ?, checked = ?, login = ?, pass = ?");
            $stmt -> execute(array($_POST['fio'], $_POST['mail'], $_POST['year'], $abilities, $_POST['limps'], $_POST['sex'], $_POST['bio'],  $_POST['checkbox'], $login, $cashed));
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
    }



//  stmt - это "дескриптор состояния".

//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(array('label'=>'perfect', 'color'=>'green'));

//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
 $stmt->bindParam(':firstname', $firstname);
 $stmt->bindParam(':lastname', $lastname);
 $stmt->bindParam(':email', $email);
 $firstname = "John";
 $lastname = "Smith";
 $email = "john@test.com";
 $stmt->execute();
 */

// Сохраняем куку с признаком успешного сохранения.
setcookie('save', '1');

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');
}