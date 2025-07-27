    <?php include_once __DIR__ . '/../layouts/header.php'; ?>

    <style>
    .card-img-top,
    .img-fluid.rounded-top {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
    }
    </style>

    <section class="py-5 bg-light text-center">
        <div class="container">
            <!-- <h2 class="mb-3"><?= htmlspecialchars($title ?? 'Danh sách sản phẩm') ?></h2> -->
            <h1 class="display-4 fw-bold mb-3">Tất cả sản phẩm </h1>
            <p class="lead mb-0"style="font-size: 25px;">Khám phá bộ sưu tập sản phẩm đa dạng, chất lượng cao tại Nexorevn E-commerce.</p>
        </div>
    </section>

    <?php
    function renderRating($product_id, $conn) {
        $review_q = $conn->query("SELECT ROUND(AVG(rating),1) as avg_rating, COUNT(*) as total FROM reviews WHERE product_id = $product_id");
        $review = $review_q->fetch_assoc();
        $avg = $review['avg_rating'] ?? 0;
        $total = $review['total'] ?? 0;

        if ($total == 0) return "";
        $stars = str_repeat("★", (int)$avg) . str_repeat("☆", 5 - (int)$avg);

        return "<div class='text-center mb-1 text-warning' style='font-size: 1rem;'>
                $stars <span class='text-muted' style='font-size: 0.9rem;'>($total đánh giá)</span>
                </div>";
    }
    ?>

    <section class="container my-5">
        <div class="row">
            <!-- Bộ lọc bên trái -->
            <div class="col-md-3">
                <?php include_once __DIR__ . '/filters.php'; ?>
            </div>

            <!-- Kết quả sản phẩm bên phải -->
            <div class="col-md-9">
                <?php if (!empty($products) && is_array($products)): ?>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php foreach ($products as $product): ?>
                            <?php
                                $price = (float)$product['price'];
                                $discount = (float)$product['discount_price'];
                                $has_discount = $discount > 0 && $discount < $price;
                            ?>
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="<?= htmlspecialchars($product['image']) ?>" 
                                        class="img-fluid rounded-top" 
                                        style="object-fit: cover; height: 250px; width: 100%;">

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-truncate"><?= htmlspecialchars($product['name']) ?></h5>
                                        <?= renderRating($product['id'], $conn) ?>

                                        <div class="text-center mt-2 mb-3">
                                            <?php if ($has_discount): ?>
                                                <span class="text-muted text-decoration-line-through"><?= number_format($price, 0, ',', '.') ?> VND</span><br>
                                                <span class="text-danger fw-bold fs-5"><?= number_format($discount, 0, ',', '.') ?> VND</span>
                                            <?php else: ?>
                                                <span class="text-primary fw-bold fs-5"><?= number_format($price, 0, ',', '.') ?> VND</span>
                                            <?php endif; ?>
                                        </div>

                                        <a href="index.php?url=product/detail/<?= $product['id'] ?>" class="btn btn-outline-primary mt-auto w-100">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <!-- Phân trang -->
                <?php if (!empty($total_pages) && $total_pages > 1): ?>
    <?php $current_page = (int)($_GET['page'] ?? 1); ?>
    <?php
        if ($current_page < 1) $current_page = 1;
        if ($current_page > $total_pages) $current_page = $total_pages;
    ?>
    <nav class="mt-4" aria-label="Page navigation">
        <ul class="pagination justify-content-center">

            <!-- Nút Trước -->
            <?php if ($current_page > 1): ?>
                <?php $query = $_GET; $query['page'] = $current_page - 1; ?>
                <li class="page-item">
                    <a class="page-link" href="?<?= http_build_query($query) ?>">← Trước</a>
                </li>
            <?php endif; ?>

            <!-- Số trang -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php $query = $_GET; $query['page'] = $i; ?>
                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query($query) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Nút Sau -->
            <?php if ($current_page < $total_pages): ?>
                <?php $query = $_GET; $query['page'] = $current_page + 1; ?>
                <li class="page-item">
                    <a class="page-link" href="?<?= http_build_query($query) ?>">Sau →</a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>
<?php endif; ?>
    
                <?php else: ?>
                    <div class="alert alert-warning">Không tìm thấy sản phẩm nào phù hợp.</div>
                <?php endif; ?>

                
            </div>
        </div>
    </section>

    <?php include_once __DIR__ . '/../layouts/footer.php'; ?>
