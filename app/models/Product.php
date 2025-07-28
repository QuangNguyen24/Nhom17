<?php
class Product {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

public function getFeatured($limit = 8) {
    $stmt = $this->db->prepare("SELECT * FROM products WHERE is_featured = true ORDER BY created_at DESC LIMIT :limit");
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getNewest($limit = 8) {
    $stmt = $this->db->prepare("SELECT * FROM products ORDER BY created_at DESC LIMIT :limit");
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getDiscounted($limit = 8) {
    $stmt = $this->db->prepare("SELECT * FROM products WHERE discount_price IS NOT NULL AND discount_price > 0 AND discount_price < price ORDER BY created_at DESC LIMIT :limit");
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function getAll($filters = []) {
    $sql = "SELECT p.*, c.name AS category_name, b.name AS brand_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            WHERE 1=1";
    $params = [];

    if (!empty($filters['keyword'])) {
        $sql .= " AND p.name ILIKE :keyword";
        $params[':keyword'] = '%' . $filters['keyword'] . '%';
    }

    if (!empty($filters['category_id'])) {
        $sql .= " AND p.category_id = :category_id";
        $params[':category_id'] = (int)$filters['category_id'];
    }

    if (!empty($filters['brand_id'])) {
        $sql .= " AND p.brand_id = :brand_id";
        $params[':brand_id'] = (int)$filters['brand_id'];
    }

    $sql .= " ORDER BY p.created_at DESC";

    $stmt = $this->db->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val, is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function findDetailById($id) {
    $stmt = $this->db->prepare("SELECT products.*, categories.name AS category_name 
                                FROM products 
                                LEFT JOIN categories ON products.category_id = categories.id 
                                WHERE products.id = :id");
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function getImagesByProductId($id) {
    $stmt = $this->db->prepare("SELECT * FROM product_images WHERE product_id = :id");
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function findById($id) {
    $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function getReviews($product_id) {
    $stmt = $this->db->prepare("SELECT r.*, u.username 
                                FROM reviews r 
                                JOIN users u ON r.user_id = u.id 
                                WHERE r.product_id = :id 
                                ORDER BY r.created_at DESC");
    $stmt->bindValue(':id', (int)$product_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getAverageRating($product_id) {
    $stmt = $this->db->prepare("SELECT ROUND(AVG(rating), 1) as average_rating 
                                FROM reviews 
                                WHERE product_id = :id");
    $stmt->bindValue(':id', (int)$product_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['average_rating'] ?? 0;
}

   public function getFilteredProducts($filters) {
    $where = "1=1";
    $params = [];

    if (!empty($filters['category_id'])) {
        $categoryIds = $this->getChildCategoryIds((int)$filters['category_id']);
        $where .= " AND p.category_id IN (" . implode(",", array_map('intval', $categoryIds)) . ")";
    }

    if (!empty($filters['brand_id'])) {
        $where .= " AND p.brand_id = :brand_id";
        $params[':brand_id'] = (int)$filters['brand_id'];
    }

    if (!empty($filters['price_range'])) {
        $range = explode('-', $filters['price_range']);
        if (count($range) === 2) {
            $where .= " AND COALESCE(p.discount_price, p.price) BETWEEN :min_price AND :max_price";
            $params[':min_price'] = (int)$range[0];
            $params[':max_price'] = (int)$range[1];
        }
    }

    if (!empty($filters['keyword'])) {
        $where .= " AND p.name ILIKE :keyword";
        $params[':keyword'] = '%' . $filters['keyword'] . '%';
    }

    // Sort
    $sortSql = "ORDER BY p.created_at DESC";
    $sorts = [
        'price_asc'  => 'COALESCE(p.discount_price, p.price) ASC',
        'price_desc' => 'COALESCE(p.discount_price, p.price) DESC',
        'name_asc'   => 'p.name ASC',
        'name_desc'  => 'p.name DESC'
    ];
    if (!empty($filters['sort']) && isset($sorts[$filters['sort']])) {
        $sortSql = "ORDER BY " . $sorts[$filters['sort']];
    }

    // Pagination
    $limit = 12;
    $page = max(1, (int)($filters['page'] ?? 1));
    $offset = ($page - 1) * $limit;

    // Main query
    $sql = "SELECT p.*, c.name AS category_name, b.name AS brand_name, ROUND(AVG(r.rating),1) AS avg_rating
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN reviews r ON p.id = r.product_id
            WHERE $where
            GROUP BY p.id";

    if (!empty($filters['rating'])) {
        $sql .= " HAVING avg_rating >= :rating";
        $params[':rating'] = (int)$filters['rating'];
    }

    $sql .= " $sortSql LIMIT $limit OFFSET $offset";
$stmt = $this->db->prepare($sql);
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val, is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR);
}
try {
    $stmt->execute();
} catch (PDOException $e) {
    die("❌ Lỗi thực thi getFilteredProducts: " . $e->getMessage());
}

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count total
    $countSql = "SELECT COUNT(DISTINCT p.id) as total
                 FROM products p
                 LEFT JOIN reviews r ON p.id = r.product_id
                 WHERE $where";

    if (!empty($filters['rating'])) {
        $countSql = "SELECT COUNT(*) as total FROM (
                        SELECT p.id
                        FROM products p
                        LEFT JOIN reviews r ON p.id = r.product_id
                        WHERE $where
                        GROUP BY p.id
                        HAVING AVG(r.rating) >= :rating
                     ) AS subquery";
    }

$countStmt = $this->db->prepare($countSql);
foreach ($params as $key => $val) {
    $countStmt->bindValue($key, $val, is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR);
}
$countStmt->execute();




    $totalRows = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalRows / $limit);

    return [
        'products' => $products,
        'total_pages' => $totalPages,
        'title' => 'Tất cả sản phẩm'
    ];
}

    private function getChildCategoryIds($parentId) {
    $ids = [$parentId];

$stmt = $this->db->prepare("SELECT id FROM categories WHERE parent_id = :id");
$stmt->bindValue(':id', $parentId, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $ids[] = $row['id'];
}
ids[] = $row['id'];
    }

    return $ids;
}


public function calculateCartTotal($cart) {
    $total = 0;
    foreach ($cart as $productId => $quantity) {
        $stmt = $this->db->prepare("SELECT price, discount_price FROM products WHERE id = :id");
        $stmt->bindValue(':id', (int)$productId, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $price = ($product['discount_price'] > 0) ? $product['discount_price'] : $product['price'];
            $total += $price * $quantity;
        }
    }
    return $total;
}


    public function getById($id) {
    $stmt = $this->db->prepare("SELECT p.*, c.name AS category_name, b.name AS brand_name
                                FROM products p
                                LEFT JOIN categories c ON p.category_id = c.id
                                LEFT JOIN brands b ON p.brand_id = b.id
                                WHERE p.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

public function getDetail($id) {
    $stmt = $this->db->prepare("SELECT p.*, c.name AS category_name, b.name AS brand_name 
                                FROM products p 
                                LEFT JOIN categories c ON p.category_id = c.id 
                                LEFT JOIN brands b ON p.brand_id = b.id 
                                WHERE p.id = :id");
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function getImages($product_id) {
    $stmt = $this->db->prepare("SELECT image_path FROM product_images WHERE product_id = :product_id");
    $stmt->bindValue(':product_id', (int)$product_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


 
public function getByType($type, $filters = []) {
    $page = $filters['page'] ?? 1;
    $limit = 12;
    $offset = ($page - 1) * $limit;

    $where = match ($type) {
        'featured' => "p.is_featured = true",
        'discount' => "p.discount_price > 0 AND p.discount_price < p.price",
        'newest'   => "1=1",
        default    => "1=1"
    };

    $order = $type === 'newest' ? "ORDER BY p.created_at DESC" : "ORDER BY p.id DESC";

    // Total count
    $countSql = "SELECT COUNT(DISTINCT p.id) as total FROM products p WHERE $where";
    $count = $this->db->query($countSql)->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($count / $limit);

    // Main query
    $sql = "SELECT p.*, c.name AS category_name, b.name AS brand_name, ROUND(AVG(r.rating),1) AS avg_rating
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN reviews r ON p.id = r.product_id
            WHERE $where
            GROUP BY p.id
            $order
            LIMIT $limit OFFSET $offset";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'products' => $products,
        'total_pages' => $totalPages,
        'page' => $page,
        'title' => match ($type) {
            'featured' => '🔥 Sản phẩm nổi bật',
            'discount' => '💥 Sản phẩm giảm giá',
            'newest'   => '🆕 Sản phẩm mới nhất',
            default    => 'Tất cả sản phẩm'
        }
    ];
}

   
    
}
