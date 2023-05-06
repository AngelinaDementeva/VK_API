<?php

use App\Controllers\EventController;
use App\Controllers\StatisticController;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

// Создаем объект контроллера событий
$eventController = new EventController();

// Обрабатываем POST-запросы на добавление события
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventController->addEvent($_POST['event_name'], $_POST['user_status']);
}

// Создаем объект контроллера статистики
$statisticController = new StatisticController();

// Обрабатываем GET-запросы на получение статистики
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Получаем параметры запроса
    $event_name = $_GET['event_name'] ?? '';
    $from_date = $_GET['from_date'] ?? '';
    $to_date = $_GET['to_date'] ?? '';
    $group_by = $_GET['group_by'] ?? '';

    // Вызываем нужный метод контроллера статистики
    if ($group_by === 'event') {
        $statisticController->getEventsCount($event_name, $from_date, $to_date);
    } elseif ($group_by === 'user') {
        $statisticController->getUsersCount($event_name, $from_date, $to_date);
    } elseif ($group_by === 'status') {
        $statisticController->getStatusCount($event_name, $from_date, $to_date);
    }
}
