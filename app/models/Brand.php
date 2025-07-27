<?php
class Brand {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Hoặc Database::getInstance()->getConnection();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM brands ORDER BY name ASC");
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM brands WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
