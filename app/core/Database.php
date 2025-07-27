<?php
class Database {
    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            // Lấy biến môi trường DATABASE_URL từ Heroku
            $db_url = getenv("DATABASE_URL");

            if (!$db_url) {
                die("DATABASE_URL chưa được thiết lập.");
            }

            $url = parse_url($db_url);

            $host = $url["host"];
            $port = $url["port"];
            $user = $url["user"];
            $pass = $url["pass"];
            $dbname = ltrim($url["path"], "/");

            try {
                // Tạo kết nối PDO đến PostgreSQL
                self::$conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
            }
        }

        return self::$conn;
    }
}
?>
