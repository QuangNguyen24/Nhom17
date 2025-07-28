<?php
class Category {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Hoặc getInstance()->getConnection()
    }

public function getAll() {
    $stmt = $this->db->query("SELECT * FROM categories ORDER BY name ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function find($id) {
$stmt = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
$stmt->execute(['id' => $id]);
return $stmt->fetch(PDO::FETCH_ASSOC);

    }
}
