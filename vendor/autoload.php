<?php

spl_autoload_register(function ($class) {
    // определить базовую директорию
    $base_dir = __DIR__ . '/src/';

    // заменить пространства имен на путь к файлу
    $class_file = str_replace('\\', '/', $class) . '.php';

    // путь к файлу класса
    $file = $base_dir . $class_file;

    // проверить наличие файла и загрузить его
    if (file_exists($file)) {
        require_once $file;
    }
});
