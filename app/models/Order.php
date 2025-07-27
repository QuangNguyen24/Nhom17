<?php

class Order {
    public static function allByUser($userId) {
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public static function create($userId, $total, $note) {
        $conn = Database::connect();
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total, note) VALUES (:user_id, :total, :note)");
        return $stmt->execute([
            'user_id' => $userId,
            'total' => $total,
            'note' => $note
        ]);
    }
}
