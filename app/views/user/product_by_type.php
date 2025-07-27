<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold"><?= $title ?></h2>
    <a href="<?= BASE_URL ?>/index.php" class="btn btn-outline-secondary btn-sm">⬅ Về trang chủ</a>
  </div>

  <div class="row">
    <?php foreach ($products as $product): ?>
      <?php
        $price = (float)$product['price'];
        $discount = (float)$product['discount_price'];
        $has_discount = $discount > 0 && $discount < $price;
        $avg_rating = $product['avg_rating'] ?? 0;
        $stars = str_repeat("★", (int)$avg_rating) . str_repeat("☆", 5 - (int)$avg_rating);
      ?>
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="card h-100">
          <img src="<?= htmlspecialchars($product['image']) ?>" 
               class="img-fluid rounded-top"
               style="object-fit: cover; height: 250px; width: 100%;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>

            <?php if ($avg_rating > 0): ?>
              <div class="text-center mb-2 text-warning" style="font-size: 1rem;">
                <?= $stars ?>
                <span class="text-muted" style="font-size: 0.85rem;">(<?= $avg_rating ?>★)</span>
              </div>
            <?php endif; ?>

            <p class="card-text text-center mb-2">
              <?php if ($has_discount): ?>
                <span class="text-muted text-decoration-line-through"><?= number_format($price, 0, ',', '.') ?> VND</span><br>
                <span class="text-danger fw-bold fs-5"><?= number_format($discount, 0, ',', '.') ?> VND</span>
              <?php else: ?>
                <span class="text-primary fw-bold fs-5"><?= number_format($price, 0, ',', '.') ?> VND</span>
              <?php endif; ?>
            </p>

            <a href="<?= BASE_URL ?>/index.php?url=product/detail/<?= $product['id'] ?>" class="btn btn-outline-primary mt-auto w-100">
              Xem chi tiết
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Phân trang -->
  <?php if ($total_pages > 1): ?>
    <nav class='mt-4'>
      <ul class='pagination justify-content-center'>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <li class='page-item <?= ($i == $page) ? 'active' : '' ?>'>
            <a class='page-link' href="<?= BASE_URL ?>/index.php?url=product/byType&type=<?= $type ?>&page=<?= $i ?>">
              <?= $i ?>
            </a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
  <?php endif; ?>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
