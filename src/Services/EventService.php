<?php
require_once 'Database.php';
require_once 'Event.php';

class EventService
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Сохранение события в базу данных
     * @param string $name Название события
     * @param bool $isAuthorized Флаг авторизации пользователя
     * @return bool true в случае успешного сохранения, false в противном случае
     */
    public function saveEvent(string $name, bool $isAuthorized): bool
    {
        $event = new Event($name, $isAuthorized);
        $query = "INSERT INTO events (name, is_authorized, ip_address) VALUES (:name, :isAuthorized, :ipAddress)";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':name', $event->getName());
        $stmt->bindParam(':isAuthorized', $event->getIsAuthorized(), PDO::PARAM_BOOL);
        $stmt->bindParam(':ipAddress', $event->getIpAddress());
        return $stmt->execute();
    }

    /**
     * Получение статистики по событиям
     * @param string $name Название события
     * @param string|null $date Дата в формате "Y-m-d"
     * @param string|null $aggregate Агрегация: "event", "ip", "status"
     * @return array|null массив с данными статистики или null в случае ошибки
     */
    public function getStatistics(string $name, ?string $date = null, ?string $aggregate = null): ?array
    {
        $query = "SELECT COUNT(*) as count";
        if ($aggregate === 'event') {
            $query .= ", name";
        } elseif ($aggregate === 'ip') {
            $query .= ", ip_address";
        } elseif ($aggregate === 'status') {
            $query .= ", is_authorized";
        }
        $query .= " FROM events WHERE name = :name";
        if (!is_null($date)) {
            $query .= " AND DATE(created_at) = :date";
        }
        $query .= " GROUP BY ";
        if ($aggregate === 'event') {
            $query .= "name";
        } elseif ($aggregate === 'ip') {
            $query .= "ip_address";
        } elseif ($aggregate === 'status') {
            $query .= "is_authorized";
        } else {
            $query .= "1";
        }
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':name', $name);
        if (!is_null($date)) {
            $stmt->bindParam(':date', $date);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
