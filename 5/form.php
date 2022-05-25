<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">

  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&family=Poppins:wght@500&display=swap" rel="stylesheet"> 

  <title>Задание 6</title>
</head>
<body>
  <nav>
    <ul>
      <li><a href="#form" title = "Форма">Форма</a></li>
      <li>
        <?php 
        if(!empty($_COOKIE[session_name()]) && !empty($_SESSION['login']))
          print('<a href="./?quit=1" title = "Выйти">Выйти</a>');
        else {
          print('<a href="login.php" title = "Войти">Войти</a>');
          print('<a href="admin.php" title = "Администрирование"> Администрирование</a>');
        }
        ?>
      </li>
    </ul>
  </nav>
  <div class="main">
    <?php 
    if (!empty($messages)) {
      print('<section id="messages">');
      if ($hasErrors)
        print('<h2>Ошибка</h2>');
      else
        print('<h2>Сообщения</h2>');
      foreach ($messages as $message) {
        print($message);
      }
      print('</section>');
    }
    ?>
    <section id="form">
      <h2>Форма</h2>
      <form action="."
        method="POST">
        <label>
          Имя
          <br />
          <input name="name" <?php if (!empty($errors['name'])) {print 'class="error"';} ?>
            value="<?php print $values['name']; ?>"/>
        </label>
        <br />

        <label>
          E-mail:
          <br />
          <input name="email" <?php if (!empty($errors['email'])) {print 'class="error"';} ?>
            value="<?php print $values['email']; ?>"
            type="email" />
        </label>
        <br />

        <label>
          Дата рождения:
          <br />
          <input name="birthday" <?php if (!empty($errors['birthday'])) {print 'class="error"';} ?>
            value="<?php print $values['birthday']; ?>"
            type="date" />
        </label>
        <br />

        Пол:<br />
        <label><input type="radio"
          name="gender" value="M" <?php if ($values['gender'] == 'M') {print 'checked';} ?>/>
          Мужской
        </label>
        <label>
        <input type="radio"
          name="gender" value="F" <?php if ($values['gender'] == 'F') {print 'checked';} ?> />
          Женский
        </label>
        <label>
        <input type="radio"
          name="gender" value="O" <?php if ($values['gender'] == 'O') {print 'checked';} ?> />
          Другое
        </label>
        <br />

        Количество конечностей:
        <br />
        <label>
        <input type="radio" <?php if ($values['limbs'] == '0') {print 'checked';} ?>
          name="limbs" value="0" />
          0
        </label>
        <label>
        <input type="radio" <?php if ($values['limbs'] == '1') {print 'checked';} ?>
          name="limbs" value="1" />
          1
        </label>
        <label>
        <input type="radio" <?php if ($values['limbs'] == '2') {print 'checked';} ?>
          name="limbs" value="2" />
          2
        </label>
        <label>
        <input type="radio" <?php if ($values['limbs'] == '3') {print 'checked';} ?>
          name="limbs" value="3" />
          3
        </label>
        <label>
        <input type="radio" <?php if ($values['limbs'] == '4') {print 'checked';} ?>
          name="limbs" value="4" />
          4
        </label>
        <label>
        <input type="radio" <?php if ($values['limbs'] == '5') {print 'checked';} ?>
          name="limbs" value="5" />
          5+
        </label>
        <br />

        <label>
          Сверхспособности:
          <br />
          <select name="superpowers[]"
            multiple="multiple">
            <option value="0" <?php if ($values['superpowers']['0']) {print 'selected';} ?>>Бессмертие</option>
            <option value="1" <?php if ($values['superpowers']['1']) {print 'selected';} ?>>Прохождение сквозь стены</option>
            <option value="2" <?php if ($values['superpowers']['2']) {print 'selected';} ?>>Левитация</option>
          </select>
        </label>
        <br />

        <label>
          Биография:
          <br />
          <textarea name="biography"><?php print $values['biography']; ?></textarea>
        </label>
        <br />

        <br />
        <label <?php if (array_key_exists('contract', $errors)) {print 'class="error"';} ?>>
        <input type="checkbox"
          name="contract" <?php if ($values['contract']) {print 'checked';} ?>/>
          С контрактом ознакомлен(-а)
        </label>
        <br />
        
        <input id="submit" type="submit" value="Отправить" />
      </form>
    </section>
  </div>
</body>
</html>
