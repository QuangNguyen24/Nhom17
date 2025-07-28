<?php

include_once __DIR__ . '/../layouts/header.php'; ?>

<style>
  .banner-img {
    background-color: black;
    padding: 10px;
    max-height: 200px;
    object-fit: contain;
  }
  
</style>

<!-- Banner -->
<div id="mainBanner" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">
  <div class="carousel-inner">
<?php foreach ($data['banners'] as $index => $b): ?>
  <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
    <a href="<?= $b['link'] ?>">
      <img src="<?= BASE_URL . '/' . htmlspecialchars($b['image']) ?>" class="d-block w-100 banner-img" alt="Banner">
    </a>
  </div>
<?php endforeach; ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#mainBanner" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#mainBanner" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- Giới thiệu -->
<div class="container mt-5 text-center">
  <h3 class="display-5 fw-bold mb-3">Chào mừng đến với cửa hàng của chúng tớ</h3>
  <p class="lead mb-0"style="font-size: 25px;">Chuyên cung cấp sản phẩm mô hình, phụ kiện và nhiều mặt hàng hấp dẫn.</p>
            <strong style="font-size: 20px;">Khám phá – Sưu tầm – Thể hiện chất riêng</strong>

</div>

<?php
function renderRating($product_id, $conn) {
    $stmt = $conn->prepare("SELECT ROUND(AVG(rating),1) as avg_rating, COUNT(*) as total FROM reviews WHERE product_id = :id");
    $stmt->execute([$product_id]);
    $review = $stmt->fetch(PDO::FETCH_ASSOC);

    $avg = $review['avg_rating'] ?? 0;
    $total = $review['total'] ?? 0;

    if ($total == 0) return "";
    $stars = str_repeat("★", (int)$avg) . str_repeat("☆", 5 - (int)$avg);

    return "<div class='text-center mb-1 text-warning' style='font-size: 1rem;'>
              $stars <span class='text-muted' style='font-size: 0.9rem;'>($total đánh giá)</span>
            </div>";
}



function renderProducts($data, $conn, $title, $filterType, $btn_class = 'btn-outline-primary', $pageKey = '') {
    $products = $data['products'];
    $page = $data['page'];
    $totalPages = $data['total_pages'];

    echo "<div class='container mt-5'>
        <div class='d-flex justify-content-between align-items-center mb-3'>
          <h3 class='mb-0'>$title</h3>";

    $linkAll = BASE_URL . "/index.php?url=product/byType&type=" . $filterType;
    echo "  <a href='$linkAll' class='btn btn-sm $btn_class'>Xem tất cả</a>";

    echo "  </div>
            <div class='row'>";

    foreach ($products as $product):
        $price = (float)$product['price'];
        $discount = (float)$product['discount_price'];
        $has_discount = $discount > 0 && $discount < $price;
?>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
          <div class="card h-100 <?= $btn_class == 'btn-outline-danger' ? 'border-danger' : '' ?>">
            <img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid rounded-top" 
         style="object-fit: cover; height: 250px; width: 100%;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
              <?= renderRating($product['id'], $conn) ?>
              <p class="card-text text-center mb-2">
                <?php if ($has_discount): ?>
                  <span class="text-muted text-decoration-line-through"><?= number_format($price, 0, ',', '.') ?> VND</span><br>
                  <span class="text-danger fw-bold fs-5"><?= number_format($discount, 0, ',', '.') ?> VND</span>
                <?php else: ?>
                  <span class="text-primary fw-bold fs-5"><?= number_format($price, 0, ',', '.') ?> VND</span>
                <?php endif; ?>
              </p>
              <a href="<?= BASE_URL ?>/index.php?url=product/detail/<?= $product['id'] ?>" class="btn <?= $btn_class ?> mt-auto">Xem chi tiết</a>
            </div>
          </div>
        </div>
<?php
    endforeach;

    echo "</div>";

    // Phân trang
    if ($totalPages > 1) {
        echo "<nav class='mt-3'><ul class='pagination justify-content-center'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            $query = $_GET;
            $query["{$pageKey}_page"] = $i;
            $link = "index.php?" . http_build_query($query);
            $active = ($i == $page) ? 'active' : '';
            echo "<li class='page-item $active'><a class='page-link' href='$link'>$i</a></li>";
        }
        echo "</ul></nav>";
    }

    echo "</div>";
}

?>

<!-- Các khối sản phẩm -->
 <?php
renderProducts($data['featured'], $conn, '🔥 Sản phẩm nổi bật', 'featured', 'btn-outline-primary', pageKey: 'featured');

renderProducts($data['newest'], $conn, '🆕 Sản phẩm mới nhất', 'newest', 'btn-outline-secondary', pageKey: 'newest');
renderProducts($data['discount'], $conn, '💥 Sản phẩm giảm giá', 'discount', 'btn-outline-danger', pageKey: 'discount');
?>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
