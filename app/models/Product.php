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
        $stmt = $this->db->prepare("SELECT * FROM products WHERE discount_price IS NOT NULL AND discount_price > 0 AND discount_price < price ORDER BY created_at DESC LIMIT ?");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->etchAll(PDO::FETCH_ASSOC);
    }

    public function getAll($filters = []) {
        $sql = "SELECT p.*, c.name AS category_name, b.name AS brand_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE 1";
        $params = [];
        $types = "";

        if (!empty($filters['keyword'])) {
            $sql .= " AND p.name LIKE ?";
            $params[] = "%" . $filters['keyword'] . "%";
            $types .= "s";
        }

        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = ?";
            $params[] = $filters['category_id'];
            $types .= "i";
        }

        if (!empty($filters['brand_id'])) {
            $sql .= " AND p.brand_id = ?";
            $params[] = $filters['brand_id'];
            $types .= "i";
        }

        $sql .= " ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

    public function findDetailById($id) {
        $id = intval($id);
        $query = "SELECT products.*, categories.name AS category_name 
                  FROM products 
                  LEFT JOIN categories ON products.category_id = categories.id 
                  WHERE products.id = $id";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($result);
    }

    public function getImagesByProductId($id) {
        $id = intval($id);
        $result = mysqli_query($this->db, "SELECT * FROM product_images WHERE product_id = $id");
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getReviews($product_id) {
        $stmt = $this->db->prepare("SELECT r.*, u.username 
                                    FROM reviews r 
                                    JOIN users u ON r.user_id = u.id 
                                    WHERE r.product_id = ? 
                                    ORDER BY r.created_at DESC");
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        return $reviews;
    }

    public function getAverageRating($product_id) {
        $stmt = $this->db->prepare("SELECT ROUND(AVG(rating), 1) as average_rating 
                                    FROM reviews 
                                    WHERE product_id = ?");
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['average_rating'] ?? 0;
    }

    public function getFilteredProducts($filters) {
        $where = "1";
        
        if (!empty($filters['category_id'])) {
            $categoryIds = $this->getChildCategoryIds(intval($filters['category_id']));
            $where .= " AND p.category_id IN (" . implode(',', $categoryIds) . ")";
        }


        if (!empty($filters['brand_id'])) {
            $where .= " AND p.brand_id = " . intval($filters['brand_id']);
        }

         if (!empty($filters['price_range'])) {
            $range = explode('-', $filters['price_range']);
            if (count($range) == 2) {
                $min = (int)$range[0];
                $max = (int)$range[1];
                $where .= " AND COALESCE(p.discount_price, p.price) BETWEEN $min AND $max";
            }
        }

        if (!empty($filters['keyword'])) {
            $keyword = mysqli_real_escape_string($this->db, $filters['keyword']);
            $where .= " AND p.name LIKE '%$keyword%'";
        }

        // Sắp xếp
        $sortSql = "ORDER BY p.created_at DESC";
        if (!empty($filters['sort'])) {
            $sorts = [
                'price_asc'  => 'COALESCE(p.discount_price, p.price) ASC',
                'price_desc' => 'COALESCE(p.discount_price, p.price) DESC',
                'name_asc'   => "CONVERT(TRIM(p.name) USING utf8mb4) COLLATE utf8mb4_unicode_ci ASC",
                'name_desc'  => "CONVERT(TRIM(p.name) USING utf8mb4) COLLATE utf8mb4_unicode_ci DESC",
            ];
            if (isset($sorts[$filters['sort']])) {
                $sortSql = "ORDER BY " . $sorts[$filters['sort']];
            }
        }


        // Phân trang
        $limit = 12;
        $page = max(1, intval($filters['page']));
        $offset = ($page - 1) * $limit;

        // Truy vấn chính (kèm review)
        $sql = "SELECT p.*, c.name AS category_name, b.name AS brand_name, ROUND(AVG(r.rating),1) AS avg_rating
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                LEFT JOIN reviews r ON p.id = r.product_id
                WHERE $where
                GROUP BY p.id";


        if (!empty($filters['rating'])) {
            $sql .= " HAVING avg_rating >= " . intval($filters['rating']);
        }

        $sql .= " $sortSql LIMIT $limit OFFSET $offset";

        $result = $this->db->query($sql);
        $products = $result->fetch_all(MYSQLI_ASSOC);

        // Đếm tổng dòng để phân trang
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
                            HAVING AVG(r.rating) >= " . intval($filters['rating']) . "
                        ) AS subquery";
        }

        $countResult = $this->db->query($countSql);
        $totalRows = $countResult->fetch_assoc()['total'];
        $totalPages = ceil($totalRows / $limit);

        return [
            'products' => $products,
            'total_pages' => $totalPages,
            'title' => 'Tất cả sản phẩm'
        ];
    }
    private function getChildCategoryIds($parentId) {
    $ids = [$parentId];

    $stmt = $this->db->prepare("SELECT id FROM categories WHERE parent_id = ?");
    $stmt->bind_param("i", $parentId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $ids[] = $row['id'];
    }

    return $ids;
}


    public function calculateCartTotal($cart) {
        $total = 0;
        foreach ($cart as $productId => $quantity) {
            $stmt = $this->db->prepare("SELECT price, discount_price FROM products WHERE id = ?");
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            if ($product) {
                $price = ($product['discount_price'] > 0) ? $product['discount_price'] : $product['price'];
                $total += $price * $quantity;
            }

            $stmt->close();
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
                                WHERE p.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

public function getImages($product_id) {
    $stmt = $this->db->prepare("SELECT image_path FROM product_images WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

 
 public function getByType($type, $filters = []) {
    $page = $filters['page'] ?? 1;
    $limit = 12;
    $offset = ($page - 1) * $limit;

    $where = match ($type) {
        'featured' => "p.is_featured = 1",
        'discount' => "p.discount_price > 0 AND p.discount_price < p.price",
        'newest'   => "1",
        default    => "1"
    };

    $order = $type === 'newest' ? "ORDER BY p.created_at DESC" : "ORDER BY p.id DESC";

    // Đếm tổng số sản phẩm
    $countSql = "SELECT COUNT(DISTINCT p.id) as total
                 FROM products p
                 WHERE $where";
    $total = $this->db->query($countSql)->fetch_assoc()['total'];
    $total_pages = ceil($total / $limit);

    // Truy vấn dữ liệu
    $sql = "SELECT p.*, c.name AS category_name, b.name AS brand_name, ROUND(AVG(r.rating),1) AS avg_rating
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN reviews r ON p.id = r.product_id
            WHERE $where
            GROUP BY p.id
            $order
            LIMIT $limit OFFSET $offset";

    $result = $this->db->query($sql);

    return [
        'products' => $result,
        'total_pages' => $total_pages,
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
