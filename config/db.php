<?php
    $db_host = 'localhost';  // адрес хоста базы данных
    $db_name = 'name'; // имя базы данных
    $db_username = 'username'; // имя пользователя базы данных
    $db_password = 'password'; // пароль пользователя базы данных
    $dsn = "pgsql:host=$db_host;dbname=$db_name"; // строка подключения к базе данных
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    try {
        $db = new PDO($dsn, $db_username, $db_password, $options);
    } catch (PDOException $e) {
        echo 'Подключение не удалось: ' . $e->getMessage();
    }
?>
