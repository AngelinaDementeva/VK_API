<?php

require_once 'config.php';

class StatisticController {

    public static function get_statistics() {
        // Получаем параметры запроса
        $event_name = $_GET['event_name'];
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $aggregation_type = $_GET['aggregation_type'];

        // Подготавливаем SQL-запрос
        switch ($aggregation_type) {
            case 'event':
                $query = "SELECT event_name, COUNT(*) as count FROM events WHERE event_name = '$event_name' AND created_at >= '$start_date' AND created_at <= '$end_date' GROUP BY event_name";
                break;
            case 'user':
                $query = "SELECT user_ip, COUNT(*) as count FROM events WHERE event_name = '$event_name' AND created_at >= '$start_date' AND created_at <= '$end_date' GROUP BY user_ip";
                break;
            case 'status':
                $query = "SELECT is_authorized, COUNT(*) as count FROM events WHERE event_name = '$event_name' AND created_at >= '$start_date' AND created_at <= '$end_date' GROUP BY is_authorized";
                break;
            default:
                // Некорректный тип агрегации
                return null;
        }

        // Выполняем SQL-запрос
        $result = pg_query($GLOBALS['conn'], $query);

        // Обрабатываем результаты запроса
        $statistics = array();
        while ($row = pg_fetch_assoc($result)) {
            $statistics[] = array(
                'key' => $row['event_name'] ?? $row['user_ip'] ?? $row['is_authorized'],
                'count' => intval($row['count']),
            );
        }

        // Формируем выходной JSON-объект
        $response = array(
            'statistics' => $statistics,
        );
        $json_response = json_encode($response);

        // Возвращаем выходной JSON-объект
        return $json_response;
    }

}

?>
