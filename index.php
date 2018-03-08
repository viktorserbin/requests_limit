<?php
require_once ('cfg'.DIRECTORY_SEPARATOR.'app_config.php');
require_once ('inc'.DIRECTORY_SEPARATOR.'function.php');
//$action='block_with_limit.php';
//$action='block_with_limit_wait.php';
//$action='block_with_limit_json.php';
$action='block_with_limit_wait_json.php';
$time=TIME_LIMIT;
$count=LIMIT;

echo <<<EOD
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Домашнее задание php, requests_limit</title>
    <link href='css/style.css' rel='stylesheet' type='text/css'>
</head>
<body>
<div>
    <p>Разрешено $count попыток за $time секунд.</p>
    <p>Введите число</p>
    <form action="$action" method="POST">
        <fieldset>
            <label for="my_number">Произвольное число</label>
            <input type="number" name="my_number" size="20" /><br />
        </fieldset>
        <br />
        <fieldset>
            <input type="submit" value="Отправить" />
            <input type="reset" value="Осистить" />
        </fieldset>
    </form>
</div>
</body>
</html>
EOD;
