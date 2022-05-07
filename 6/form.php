<html>
  <head>
    <style>
/* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
.error {
  border: 2px solid red;
}
    </style>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="style.css" >
  </head>
  <body>
  
  <?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])){
        if(isset($_GET['exit']))
        {
            session_destroy();
            $values['fio']='';
            $values['mail']='';
            $values['year']='';
            $values['sex']='';
            $values['bio']='';
            $values['checkbox']='';
            $values['limps']='';
            setcookie('fio_value', '', 100000);
            setcookie('mail_value', '', 100000);
            setcookie('year_value', '', 100000);
            setcookie('sex_value', '', 100000);
            setcookie('limps_value', '', 100000);
            setcookie('bio_value', '', 100000);
            setcookie('checkbox_value', '', 100000);
            header('Location:index.php');
        }

        $login=$_SESSION['login'];
        $fio=$values['fio'];
        echo "<div class='container mb-1 mt-1' id='for'>  <h5> Здравствуйте, <strong> $fio </strong>!!! Вы зашли под логином <strong> $login </strong>, Нажмите <a href='?exit'>сюда</a> для выхода. </h5> </div>";
}

else{
    echo "<div class='container mb-1 mt-1' id='for'><h5> Нажмите <a href='login.php'> сюда </a>, чтобы войти и изменить данные формы своего аккаунта. </div> "; 
}
// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>

<div class='container mb-1 mt-1' id='for'><h5> Нажмите <a href='/web6/admin.php'>сюда</a> ,если вы являетесь админиистратором.</div>";

<div class="container">
<h1 id="for"> Контракт: </h1>
<div class="mb-1" id="for">
<form action="" method="POST">

<div class="row" <?php if ($errors['fio']) {print 'id="error"';} ?>> 
<h2 id="mt" class="col">	ФИО: </h2>
  <input class="col" name="fio" value="<?php print $values['fio']; ?>"/ >
  </div>
  
  <div class="row" <?php if ($errors['mail']) {print 'id="error"';} ?>>
   <h2 class="col"> E-mail: </h2> 
  <input class="col" name="mail"  value="<?php print $values['mail']; ?>" /> 
  </div>
  
  <div class="row" <?php if ($errors['year']) {print 'id="error"';} ?>>
  <h2 class="col">Год Рождения: </h2>
  <select class="col" name="year" value="<?php print $values['year']; ?>">
  	<?php for ($i = 1900; $i<2020; $i++) {?>
  		<option value="<?php print($i);  ?>" <?php if ($i==$values['year']) {print 'selected';}?> > <?php print($i);?> </option>
  	<?php } ?>
  </select>
  </div>
  
  <div class="row" <?php if ($errors['abilities']) {print 'id="error"';} ?>>
  <h2 class="col"> Суперспособности: </h2>
  <select class="col" name="abilities[]"  multiple>
  		<option selected <?php if($ability['first']== "Immortal") {print 'selected';}  ?> value="Immortal"   > Бессмертие </option>
  		<option <?php if($ability['second'] == "Walls") {print 'selected';} ?> value="Walls" > Прохождение сквозь стены </option>
  		<option <?php if($ability['third'] == "Levitation") {print 'selected';} ?> value="Levitation"  > Левитация </option>
  </select>  
  </div>
  
  <div class="row" <?php if ($errors['limps']) {print 'id="error"';} ?>>
  <h2 class="col">Количество конечностей: </h2><div class="col">
  <p>
  	<input name="limps" <?php  if ($values['limps'] == 1) {print 'checked';}?> type=radio value="1" id="r"> 1;
  </p>
   <p>
  	<input name="limps" <?php  if ($values['limps'] == 2) {print 'checked';}?> type=radio value="2" id="r"> 2;
  </p>
   <p>
  	<input name="limps" <?php  if ($values['limps'] == 4) {print 'checked';}?> type=radio value="4" id="r"> 4;
  </p>
  </div>
  </div>
  
  <div class="row" <?php if ($errors['sex']) {print 'id="error"';} ?>>
  <h2 class="col">Пол: </h2>
  <div class="col">
  <p>
  	<input name="sex" type=radio value="male" id="r" <?php  if ($values['sex'] == "male") {print 'checked';}?> > Мужской;
  </p>
   <p>
  	<input name="sex" type=radio value="female" id="r" <?php  if ($values['sex'] == "female") {print 'checked';}?> > Женский;
  </p>
  </div>
  </div>
  
  <div class="row" <?php if ($errors['bio']) {print 'id="error"';} ?>>
  <h2 class="col"> Биография: </h2>
  <textarea class="col" name="bio"   ><?php print $values['bio']; ?></textarea>
  </div>
  
  <div id="row" <?php if ($errors['checkbox']) {print 'id="error"';} ?>>
  <h2 > С контрактом ознакомлен:  <input type="checkbox" <?php if ($errors['checkbox']) {print 'class="error"';} ?> name="checkbox" value="T" <?php  if ($values['checkbox'] == "T") {print 'checked';}?> >  </h2> 
  </div>
  
  <input id="mb" class="mx-0" type="submit" value="Отпправить данные" />
</form>
</div>
</div>
</div>
</body></html>