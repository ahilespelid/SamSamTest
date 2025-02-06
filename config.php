<?php
///*/ahilespelid Подключаем репу функций из гитхаба///*/
eval(preg_replace(['/<(\?|\%)\=?(php)?/', '/(\%|\?)>/'], '', file_get_contents('https://raw.githubusercontent.com/ahilespelid/functions/master/init.php')));

///*/ahilespelid Подключаю базу///*/
$servername = 'localhost';
$username   = 'j79864657_57';
$password   = 'dsbcojkslcoj';
$dbname     = 'j79864657_57';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>