<?php
class Database {
    public static function connect() {
        $url = getenv('DATABASE_URL');

        if (!$url) {
            die("❌ DATABASE_URL chưa được thiết lập.");
        }

        $dbparts = parse_url($url);

        $host = $dbparts['host'];
        $port = $dbparts['port'];
        $user = $dbparts['user'];
        $pass = $dbparts['pass'];
        $dbname = ltrim($dbparts['path'], '/');

        try {
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
            $pdo = new PDO($dsn, $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("❌ Kết nối DB thất bại: " . $e->getMessage());
        }
    }
}

?>
