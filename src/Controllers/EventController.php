<?php

require_once '../config/database.php';
require_once '../models/Event.php';

// проверка наличия параметров запроса
if (!isset($_POST['event_name']) || !isset($_POST['user_status'])) {
    http_response_code(400); // Неверный запрос
    echo json_encode(['error' => 'Missing required parameters']);
    exit();
}

// получение параметров запроса
$eventName = $_POST['event_name'];
$userStatus = $_POST['user_status'];

// создание объекта модели события
$event = new Event($db);

// установка свойств события
$event->event_name = $eventName;
$event->user_status = $userStatus;
$event->event_date = date('Y-m-d H:i:s'); // текущая дата и время

// создание события в базе данных
if ($event->create()) {
    http_response_code(201); // Событие успешно создано
    echo json_encode(['message' => 'Event created successfully']);
} else {
    http_response_code(503); // Сервис недоступен
    echo json_encode(['error' => 'Unable to create event']);
}
