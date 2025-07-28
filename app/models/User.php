<?php

class User {
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

    public static function create($data) {
        $conn = Database::connect();
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);
    }
    public static function getByUsername($username) {
    $conn = Database::connect();
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    return $stmt->fetch();
}

}
