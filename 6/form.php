<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Задание №6</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
/* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
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
  </head>
  <body>
  <?php if (empty($_SESSION['login'])) { ?>
  <a href="login.php">Вход</a> <?php } else { ?>
  <a href="login.php">Выход</a> <?php } ?>
    <div class="form">
      <div class="content">
        <h1 id="forms">Форма</h1>
        <form action=""
            method="POST">

        <p>Введите свое имя:</p>
        <label><br />
            <input name="field-name-1" <?php if ($errors['field-name-1']) {print 'class="error"';} ?> value="<?php print $values['field-name-1']; ?>"/>
          </label><br />

          <p>Введите Ваш e-mail:</p>
          <label><br />
            <input name="field-email"
              type="email" <?php if ($errors['field-email']) {print 'class="error"';} ?> value="<?php print $values['field-email']; ?>"/>
          </label><br />

          <p id="birth">Ваш год рождения:</p>
          <label><br />
            <select name="field-date">
              <option value="1995" <?php if ($values['field-date']==1995)
            {print 'selected';}?>>1995</option>
              <option value="1996" <?php if ($values['field-date']==1996)
            {print 'selected';}?>>1996</option>
              <option value="1997" <?php if ($values['field-date']==1997)
            {print 'selected';}?>>1997</option>
              <option value="1998" <?php if ($values['field-date']==1998)
            {print 'selected';}?>>1998</option>
              <option value="1999" <?php if ($values['field-date']==1999)
            {print 'selected';}?>>1999</option>
              <option value="2000" <?php if ($values['field-date']==2000)
            {print 'selected';}?>>2000</option>
              <option value="2001"<?php if ($values['field-date']==2001)
            {print 'selected';}?>>2001</option>
              <option value="2002" <?php if ($values['field-date']==2002)
            {print 'selected';}?>>2002</option>
            </select>
          </label><br />

          <p id="gender">Пол:</p>
          <label><input type="radio" 
            name="radio-group-1" value="1" <?php if ($errors['radio-group-1']) {print 'class="error"';} ?> <?php if ($values['radio-group-1']==1)
            {print 'checked';}?>/>М</label>
          <label><input type="radio"
            name="radio-group-1" value="2" <?php if ($errors['radio-group-1']) {print 'class="error"';} ?> <?php if ($values['radio-group-1']==2)
            {print 'checked';}?>/>Ж</label><br />

            <p>Ваш IQ:</p>
          <label><input type="radio" 
            name="radio-group-iq" value="2" <?php if ($errors['radio-group-iq']) {print 'class="error"';} ?> <?php if ($values['radio-group-iq']==2)
            {print 'checked';}?>/>2</label>
          <label><input type="radio"
            name="radio-group-iq" value="-18" <?php if ($errors['radio-group-iq']) {print 'class="error"';} ?> <?php if ($values['radio-group-iq']==-18)
            {print 'checked';}?>/>-18</label>
          <label><input type="radio"
            name="radio-group-iq" value="180" <?php if ($errors['radio-group-iq']) {print 'class="error"';} ?> <?php if ($values['radio-group-iq']==180)
            {print 'checked';}?>/>180</label>
          <label><input type="radio"
            name="radio-group-iq" value="100" <?php if ($errors['radio-group-iq']) {print 'class="error"';} ?> <?php if ($values['radio-group-iq']==100)
            {print 'checked';}?>/>100</label><br />

            <p>  Ваши таланты:</p>
            <label>
                <select name="field-name-talents[]"
                  multiple="multiple">
                  <option value="1" <?php $tal=str_split($values['field-name-talents']); 
                    foreach ($tal as $talent)
                      if ($talent==1) print 'selected';?> 
                      <?php if ($errors['field-name-talents']) {print 'class="error"';} ?>>Рисование</option>
                  <option value="2" <?php $tal=str_split($values['field-name-talents']); 
                    foreach ($tal as $talent)
                      if ($talent==2) print 'selected';?>
                      <?php if ($errors['field-name-talents']) {print 'class="error"';} ?>>Пение</option>
                  <option value="3" <?php $tal=str_split($values['field-name-talents']); 
                    foreach ($tal as $talent)
                      if ($talent==3) print 'selected';?>
                      <?php if ($errors['field-name-talents']) {print 'class="error"';} ?>>Попадание в неприятности</option>
                  <option value="4"<?php $tal=str_split($values['field-name-talents']); 
                    foreach ($tal as $talent)
                      if ($talent==4) print 'selected';?>
                      <?php if ($errors['field-name-talents']) {print 'class="error"';} ?>>Нахождение второго носка</option>
                </select>
              </label><br />

            <p>Расскажите о себе:</p>
            <label>
            <textarea name="field-name-4" 
            <?php if ($errors['field-name-4']) {print 'class="error"';} ?>><?php print $values['field-name-4']; ?></textarea>
            </label><br />

            <p id="subm">Даю согласие на обратоку данных</p>
          <label><input type="checkbox" checked="checked"
            name="check-1" <?php if ($errors['check-1']) {print 'class="error"';} ?>/>Подтверждаю</label><br />

            <input type="submit" value="Отправить" />
          </form>

            <p><a id="bottom"></a></p>
        </div>
      </div>
    
  </body>
</html>
