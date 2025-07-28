<?php
require_once __DIR__ . '/../core/Database.php';
class Banner {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

   public function getActiveBanners() {
    try {
        return $this->db->query("SELECT * FROM banners WHERE is_active = true ORDER BY created_at DESC");

    } catch (PDOException $e) {
        die("❌ Lỗi SQL: " . $e->getMessage());
    }
}


    
}
