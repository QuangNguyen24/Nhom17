<?php

class Order {
    public static function allByUser($userId) {
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $conn = Database::connect();
        $stmt = $conn->prepare("
            INSERT INTO orders (fullname, email, phone, address, total_price, method_payment, status, user_id)
            VALUES (:fullname, :email, :phone, :address, :total_price, :method_payment, :status, :user_id)
            RETURNING id
        ");
        $stmt->execute([
            'fullname'        => $data['fullname'],
            'email'           => $data['email'],
            'phone'           => $data['phone'],
            'address'         => $data['address'],
            'total_price'     => $data['total_price'],
            'method_payment'  => $data['method_payment'],
            'status'          => $data['status'],
            'user_id'         => $data['user_id']
        ]);
        return $stmt->fetchColumn(); // Lấy id mới insert
    }
}
