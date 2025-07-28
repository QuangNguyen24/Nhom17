<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<main>
    <section class="py-5 text-center bg-light">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Về Nexorevn E-commerce</h1>
            <p class="lead mb-0"style="font-size: 25px;">Khám phá câu chuyện của chúng tôi - nơi đam mê và chất lượng hội tụ, mang đến những sản phẩm tốt nhất cho bạn.</p>
            <strong style="font-size: 20px;">Khám phá – Sưu tầm – Thể hiện chất riêng</strong>
        </div>
    </section>

    <section class="container my-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="<?= BASE_URL ?>/images/logo/Nexore_logo_unback.png" class="img-fluid rounded shadow-lg" alt="Câu chuyện Nexorevn Shop">
            </div>
            <div class="col-lg-6">
                <h2 class="mb-4 text-primary">Sứ Mệnh Của Chúng Tôi</h2>
                <p style="font-size: 20px; text-align: justify;">
                    Tại <strong>Nexorevn E-commerce</strong>, chúng tôi không chỉ bán sản phẩm, mà còn xây dựng những trải nghiệm.
                    Sứ mệnh của chúng tôi là <strong>cung cấp những sản phẩm chất lượng cao nhất với mức giá hợp lý</strong>,
                    đồng thời kiến tạo một <strong>môi trường mua sắm trực tuyến thân thiện, an toàn và đáng tin cậy</strong>.
                    Chúng tôi mong muốn mỗi khách hàng đều cảm thấy hài lòng và được trân trọng.
                </p>

                <h2 class="mb-4 mt-5 text-primary">Giá Trị Cốt Lõi</h2>
                <ul class="list-unstyled" style="font-size: 20px;">
                    <li class="mb-3"><i class="fas fa-circle-check text-success me-2"></i> <strong>Chất lượng hàng đầu:</strong> Sản phẩm được kiểm định kỹ lưỡng.</li>
                    <li class="mb-3"><i class="fas fa-circle-check text-success me-2"></i> <strong>Chăm sóc tận tâm:</strong> Hỗ trợ 24/7, luôn lắng nghe khách hàng.</li>
                    <li class="mb-3"><i class="fas fa-circle-check text-success me-2"></i> <strong>Đổi mới không ngừng:</strong> Cập nhật xu hướng và công nghệ mới.</li>
                    <li class="mb-3"><i class="fas fa-circle-check text-success me-2"></i> <strong>Minh bạch - Uy tín:</strong> Giao dịch rõ ràng, chính sách công khai.</li>
                </ul>
            </div>
        </div>

        <hr class="my-5">

        <div class="text-center mb-4">
            <h2 class="text-primary">Đội Ngũ Của Chúng Tôi</h2>
            <p style="font-size: 20px; text-align: justify;">
                Nexorevn E-commerce là nơi hội tụ những con người trẻ trung, năng động và cùng chung một lý tưởng "Xây dựng nền tảng thương mại điện tử chất lượng và đầy cảm hứng".
            </p>
        </div>
        <!-- Nút điều hướng -->
            <button class="carousel-control-prev" type="button" data-bs-target="#teamCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#teamCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <section class="bg-primary text-white py-5 text-center">
        <div class="container">
            <h2 class="display-5 fw-bold mb-3">Bạn Đã Sẵn Sàng Khám Phá?</h2>
            <p class="lead mb-4">Hãy bắt đầu hành trình mua sắm của bạn ngay hôm nay!</p>
            <a class="btn btn-light btn-lg rounded-pill px-4 <?= $current_page == 'product.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>/product">
                Khám Phá Sản Phẩm Của Chúng Tôi <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
