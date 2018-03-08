<?php
/**
 * Created by PhpStorm.
 * User: sinor
 * Date: 07.03.2018
 * Time: 1:16
 */

require_once ('cfg'.DIRECTORY_SEPARATOR.'app_config.php');
require_once ('inc'.DIRECTORY_SEPARATOR.'function.php');
echo <<<EOD
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Домашнее задание php, requests_limit</title>
    <link href='css/style.css' rel='stylesheet' type='text/css'>
</head>
<body></body>
EOD;
if ($_POST) {
    $ip = getClientIp();
    $result = checkIpLimits($ip);
    if ($result['result']) {
        echo '<h1>403 Forbidden</h1>';
        header('HTTP/1.0 403 Forbidden');
        exit;
    } else {
        writeIP($ip);
        $my_number = trim($_REQUEST['my_number']);
        echo "<a href='index.php'><<<</a>";
        echo "<p>Данные получены: <strong>{$my_number}</strong> </p>";
    }
}
echo "<a href='index.php'><<<</a>";
ECHO <<<EOD
</body>
</html>
EOD;
