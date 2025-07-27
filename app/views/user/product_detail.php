<?php include_once __DIR__ . '/../layouts/header.php'; 

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: ' . BASE_URL . '/index.php?url=auth/login');
    exit;
}
?>

<section class="py-5 bg-light text-center">
  <div class="container">
     <h2 style="font-weight: bold; font-size: 2.5rem;">  <?= $product['name'] ?> </h2>
  </div>
</section>

<section class="container my-7">
<?php if (!empty($product)): ?>
  <div class="row gy-4">
    <!-- Hình ảnh sản phẩm -->
    <div class="col-lg-5">
      <div class="bg-white rounded shadow-sm" style="aspect-ratio: 4/3; overflow:hidden;">
        <img id="mainImage" src="<?= htmlspecialchars($product['image']) ?>" class="w-100 h-100 object-fit-contain" alt="<?= htmlspecialchars($product['name']) ?>">
      </div>

      <?php if (!empty($additional_images)): ?>
        <div class="d-flex flex-wrap gap-2 mt-3">
          <?php foreach ($additional_images as $img): ?>
            <img src="<?= htmlspecialchars($img['image_path']) ?>" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover; cursor:pointer;" onclick="document.getElementById('mainImage').src = this.src" alt="Ảnh phụ">
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Thông tin sản phẩm -->
    <div class="col-lg-7">
          <h4 class="mb-3 text-primary fw-bold">💸 Giá sản phẩm</h4>

          <?php if ($product['discount_price'] > 0 && $product['discount_price'] < $product['price']): ?>
            <p class="mb-1">
              <span class="badge bg-danger fs-6 me-2">Giá khuyến mãi</span>
              <span class="text-danger fs-3 fw-bold"><?= number_format($product['discount_price']) ?>₫</span>
            </p>
            <p class="mb-2">
              <span class="badge bg-secondary fs-6 me-2">Giá gốc</span>
              <span class="text-muted text-decoration-line-through fs-5"><?= number_format($product['price']) ?>₫</span>
            </p>
            <p class="text-success fw-semibold fs-6">
              ✅ Bạn tiết kiệm được <strong><?= number_format($product['price'] - $product['discount_price']) ?>₫</strong>
            </p>
          <?php else: ?>
            <p class="fs-4 fw-bold text-dark">Giá: <?= number_format($product['price']) ?>₫</p>
          <?php endif; ?>

           <p><strong>Danh mục:</strong> <?= htmlspecialchars($product['category_name'] ?? 'Chưa rõ') ?></p>
            
        <div class="card mt-4 p-4 shadow-sm">
          
            <!-- Mô tả -->
            <div class="mt-3">
                <h5 style="font-size: 2rem; font-style: italic;">Mô tả sản phẩm</h5>
                <p class="text-muted">
                    <?= $product['description'] ?>
                </p>
            </div>
        </div>

        <br></br>

      <?php if (!empty($avg['avg_rating'])): ?>
        <div class="mb-2 text-warning fw-bold">
          <?= str_repeat("★", round($avg['avg_rating'])) ?>
          <?= str_repeat("☆", 5 - round($avg['avg_rating'])) ?>
          <span class="text-muted"> (<?= number_format($avg['avg_rating'], 1) ?>/5)</span>
        </div>
      <?php endif; ?>

      

      <form method="post" action="<?= BASE_URL ?>/index.php?url=cart/add">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <div class="mb-3">
          <label class="form-label">Số lượng:</label>
          <input type="number" name="quantity" class="form-control w-25" value="1" min="1">
        </div>
        <button type="submit" class="btn btn-warning"><i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng</button>
      </form>
    </div>
  </div>

  <hr class="my-4">

  <!-- Gửi đánh giá -->
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <h4 class="text-center mb-3 mt-4">📝 Gửi đánh giá của bạn</h4>
      <?php if (isset($_SESSION['user_id'])): ?>
        <form id="reviewForm" class="border rounded p-4 bg-light shadow-sm">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <input type="hidden" name="rating" id="ratingInput" value="0">

            <div class="mb-3 text-center">
                <label class="form-label d-block">Đánh giá:</label>
                <div id="starRating" class="fs-2 text-warning">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fa-regular fa-star star" data-value="<?= $i ?>" style="cursor: pointer;"></i>
                <?php endfor; ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Bình luận:</label>
                <textarea name="comment" rows="3" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Gửi đánh giá</button>
        </form>

      <?php else: ?>
        <p class="text-center text-muted">Vui lòng <a href="<?= BASE_URL ?>/index.php?url=auth/login">đăng nhập</a> để gửi đánh giá.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Danh sách đánh giá -->
  <div id="reviewList" class="mt-5">
    <h4 class="text-center mb-4">🗣️ Đánh giá từ người dùng</h4>
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        <?php if (is_array($reviews) && count($reviews) > 0): ?>
          <?php foreach ($reviews as $review): ?>
            <div class="border rounded p-3 mb-3 bg-white">
              <strong><?= htmlspecialchars($review['username']) ?></strong>
              <div class="text-warning"><?= str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) ?></div>
              <p class="mb-0"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-muted text-center">Chưa có đánh giá nào cho sản phẩm này.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

<?php else: ?>
  <div class="alert alert-danger">Sản phẩm không tồn tại.</div>
<?php endif; ?>
</section>

<!-- AJAX xử lý form đánh giá -->
<script>
document.getElementById('reviewForm')?.addEventListener('submit', async function(e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);

  try {
    const response = await fetch("index.php?url=review/submit", {
      method: 'POST',
      body: formData
    });

    const text = await response.text();
    const result = JSON.parse(text);

    if (result.success) {
      const reviewList = document.querySelector('#reviewList .col-lg-8');
      const newReview = document.createElement('div');
      newReview.className = "border rounded p-3 mb-3 bg-white";
      newReview.innerHTML = `
        <strong>${result.username}</strong>
        <div class="text-warning">${'★'.repeat(result.rating)}${'☆'.repeat(5 - result.rating)}</div>
        <p class="mb-0">${result.comment.replace(/\n/g, "<br>")}</p>
      `;
      reviewList.prepend(newReview);
      form.reset();
    } else {
      alert(result.message || "Gửi đánh giá thất bại.");
    }
  } catch (err) {
    console.error("Lỗi gửi đánh giá:", err);
    alert("Đã xảy ra lỗi khi gửi đánh giá.");
  }
});
</script>

<script>
  const stars = document.querySelectorAll('#starRating .star');
  const ratingInput = document.getElementById('ratingInput');

  stars.forEach(star => {
    star.addEventListener('mouseenter', function () {
      const value = parseInt(this.dataset.value);
      highlightStars(value);
    });

    star.addEventListener('mouseleave', function () {
      highlightStars(parseInt(ratingInput.value));
    });

    star.addEventListener('click', function () {
      ratingInput.value = this.dataset.value;
      highlightStars(parseInt(this.dataset.value));
    });
  });

  function highlightStars(rating) {
    stars.forEach(star => {
      const val = parseInt(star.dataset.value);
      star.classList.remove('fa-solid', 'fa-regular');
      star.classList.add(val <= rating ? 'fa-solid' : 'fa-regular');
    });
  }
</script>


<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
