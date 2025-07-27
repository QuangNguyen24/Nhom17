class Product {
    public static function all() {
        $conn = Database::connect();
        $stmt = $conn->query("SELECT * FROM products");
        return $stmt->fetchAll();
    }

    public static function find($id) {
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function create($data) {
        $conn = Database::connect();
        $stmt = $conn->prepare("INSERT INTO products (name, price, description) VALUES (:name, :price, :description)");
        return $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description']
        ]);
    }

    public static function delete($id) {
        $conn = Database::connect();
        $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
