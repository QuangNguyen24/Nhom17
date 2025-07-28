<?php

class User {
public function exists($username) {
    $conn = Database::connect();
    $stmt = $conn->prepare("SELECT 1 FROM users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    return $stmt->fetchColumn() !== false;
}

public function getByUsername($username) {
    $conn = Database::connect();
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
    public static function all() {
        $conn = Database::connect();
        $stmt = $conn->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public static function findByEmail($email) {
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

public function create($data) {
    try {
        $conn = Database::connect();
        $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password, role) 
                                VALUES (:username, :email, :phone, :password, :role)");
        return $stmt->execute([
            'username' => $data['username'],
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => $data['role']
        ]);
    } catch (PDOException $e) {
        die("Đăng ký thất bại: " . $e->getMessage());
    }
}
}
