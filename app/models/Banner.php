<?php
class Banner {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getActiveBanners() {
        return $this->db->query("SELECT * FROM banners WHERE is_active = 1 ORDER BY created_at DESC");
    }

    
}
