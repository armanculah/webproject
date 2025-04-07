<?php
require_once 'BaseDao.php';

class OrdersDao extends BaseDao {

    public function __construct() {
        parent::__construct("orders", "order_id");
    }

    public function getAllWithUserAndStatus() {
        $stmt = $this->connection->prepare("
            SELECT o.*, u.user_name, s.status_name
            FROM orders o
            JOIN users u ON o.user_id = u.user_id
            JOIN statuses s ON o.status_id = s.status_id
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOrdersByUserId($user_id) {
        $stmt = $this->connection->prepare("
            SELECT o.*, s.status_name
            FROM orders o
            JOIN statuses s ON o.status_id = s.status_id
            WHERE o.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function updateStatus($order_id, $status_id) {
        $stmt = $this->connection->prepare("
            UPDATE orders SET status_id = :status_id WHERE order_id = :order_id
        ");
        return $stmt->execute([
            'status_id' => $status_id,
            'order_id' => $order_id
        ]);
    }
}
