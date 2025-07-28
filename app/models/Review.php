<?php

class Review {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect(); // Sử dụng PDO
    }

    public function getByProduct($productId) {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE product_id = :id");
        $stmt->bindValue(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAverage($product_id) {
        $stmt = $this->conn->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS count FROM reviews WHERE product_id = :id");
        $stmt->bindValue(':id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($product_id, $user_id, $rating, $comment) {
        $stmt = $this->conn->prepare("
            INSERT INTO reviews (product_id, user_id, rating, comment)
            VALUES (:product_id, :user_id, :rating, :comment)
        ");
        return $stmt->execute([
            'product_id' => $product_id,
            'user_id'    => $user_id,
            'rating'     => $rating,
            'comment'    => $comment
        ]);
    }

    public function hasReviewed($product_id, $user_id) {
        $stmt = $this->conn->prepare("
            SELECT id FROM reviews
            WHERE product_id = :product_id AND user_id = :user_id
        ");
        $stmt->execute([
            'product_id' => $product_id,
            'user_id'    => $user_id
        ]);
        return $stmt->fetch() !== false;
    }
}
