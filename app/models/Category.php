<?php
class Category {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Hoặc getInstance()->getConnection()
    }

    public function getAll() {
    $result = $this->db->query("SELECT * FROM categories ORDER BY parent_id ASC, name ASC");
    return $result->fetch_all(MYSQLI_ASSOC);
}


    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
