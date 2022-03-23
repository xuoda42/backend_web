<head>
    <meta charset="utf-8">
    <title>3</title>
    <link rel="stylesheet" media="all" href="style.css">
</head>
<body>
    <form action="index.php" accept-charset="UTF-8" class="decor" method="POST">
        <div class="form">
            <div class="border">
                <h2>Заполните форму</h2>

                <label>Введите имя</label><br>
                <label><input type="text" name="fio"></label><br>

                <label>Введите почту</label><br>
                <label><input type="email" name="email"></label><br>

                <label>Введите свой год рождения</label><br>
                <select name="birth_date">
                <?php for ($i = 1900; $i < 2022; $i++) { ?>
                <option value="<?php print($i); ?>"><?php print($i); ?></option><?php } ?>
                </select>
                <br>

                <label>Выберите пол:</label><br>
                <label><input type="radio" name="gender" value="man">Мужской</label>
                <label><input type="radio" name="gender" value="woman">Женский</label>
                <br>

                <label>Количество конечностей:</label><br>
                <label><input type="radio" name="limb" value="1">1</label>
                <label><input type="radio" name="limb" value="2">2</label>
                <label><input type="radio" name="limb" value="3">3</label>
                <label><input type="radio" name="limb" value="4">4</label>
                <br>

                <label>Ваши сверхспособности:</label><br>
                <select name="select[]" multiple="multiple">
                <option name="immortality" value="1">Бессмертие</option>
                <option name="invisibility" value="2">Невидимость</option>
                <option name="levitation" value="3">Левитация</option>
                </select>
                <br>

                <label>Биография:</label><br>
                <textarea name="biography"></textarea>
                <br>

                <label>Нажмите, если ознакомились с контрактом:</label><br>
                <label><input type="checkbox" name="checkbox" value="1">С контрактом ознакомлен</label>
                <br>

                <input type="submit" value="Отправить">
            </div>
        </div>
</body>
