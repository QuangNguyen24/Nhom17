<?php
require_once __DIR__ . '/../../vendor/autoload.php'; // đường dẫn đúng đến autoload

use Dotenv\Dotenv;

class Database {
    public static function connect() {
        // Load .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../'); // đúng thư mục MVC/
        $dotenv->load();
        var_dump($_ENV);  // hoặc print_r($_ENV);


        // Nên dùng $_ENV (an toàn hơn getenv())
        $url = $_ENV['DATABASE_URL'] ?? null;

        if (!$url) {
            die("❌ DATABASE_URL chưa được thiết lập.");
        }

        // Parse DB info
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

}?>
