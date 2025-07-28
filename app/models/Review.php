<?php
class Review {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

public function getByProduct($productId) {
    $stmt = $this->db->prepare("SELECT * FROM reviews WHERE product_id = :id");
    $stmt->bindValue(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function getAverage($product_id) {
        $id = intval($product_id);
        $query = "SELECT AVG(rating) as avg_rating, COUNT(*) as count FROM reviews WHERE product_id = $id";
        return mysqli_fetch_assoc(mysqli_query($this->conn, $query));
    }

    public function insert($product_id, $user_id, $rating, $comment) {
    $stmt = $this->conn->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);
    return $stmt->execute();
}
public function hasReviewed($product_id, $user_id) {
    $stmt = $this->conn->prepare("SELECT id FROM reviews WHERE product_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $product_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}


}
