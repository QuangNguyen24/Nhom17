<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <h2 class="text-center display-4 fw-bold mb-3"><?= htmlspecialchars($title ?? 'FAQ') ?></h2>
    <p class="text-center lead mb-0">Một số câu hỏi thường gặp từ khách hàng của chúng tôi</p>

    <div class="faq-section row mt-4 bg-white shadow rounded p-4">
        <!-- Cột trái -->
        <div class="col-md-6">
            <div class="faq-item d-flex gap-3 mb-4">
                <div class="faq-icon fs-4">🎯</div>
                <div>
                    <h5>Chính sách bảo hành</h5>
                    <p>Bảo hành 1 đổi 1 trong 7 ngày và sửa chữa miễn phí 12 tháng với lỗi kỹ thuật.</p>
                    <a href="<?= BASE_URL ?>/index.php?url=faq/warranty">Đọc thêm</a>
                </div>
            </div>

            <div class="faq-item d-flex gap-3 mb-4">
                <div class="faq-icon fs-4">🎯</div>
                <div>
                    <h5>Chính sách đổi trả</h5>
                    <p>Hỗ trợ đổi trả trong 7 ngày nếu sản phẩm bị lỗi hoặc không đúng mô tả.</p>
                    <a href="<?= BASE_URL ?>/index.php?url=faq/return">Đọc thêm</a>
                </div>
            </div>

            <div class="faq-item d-flex gap-3 mb-4">
                <div class="faq-icon fs-4">🎯</div>
                <div>
                    <h5>Hình thức thanh toán</h5>
                    <p>Chấp nhận tiền mặt, chuyển khoản và thanh toán qua VNPAY.</p>
                    <a href="<?= BASE_URL ?>/index.php?url=faq/payment_faq">Đọc thêm</a>
                </div>
            </div>
        </div>

        <!-- Cột phải -->
        <div class="col-md-6">
            <div class="faq-item d-flex gap-3 mb-4">
                <div class="faq-icon fs-4">🎯</div>
                <div>
                    <h5>Chính sách vận chuyển</h5>
                    <p>Giao hàng toàn quốc, miễn phí với đơn từ 500.000đ, kiểm hàng trước khi thanh toán.</p>
                    <a href="<?= BASE_URL ?>/index.php?url=faq/shipping">Đọc thêm</a>
                </div>
            </div>

            <div class="faq-item d-flex gap-3 mb-4">
                <div class="faq-icon fs-4">🎯</div>
                <div>
                    <h5>Chính sách bảo mật</h5>
                    <p>Chúng tôi cam kết bảo mật thông tin cá nhân của khách hàng.</p>
                    <a href="<?= BASE_URL ?>/index.php?url=faq/privacy">Đọc thêm</a>
                </div>
            </div>

            <div class="faq-item d-flex gap-3 mb-4">
                <div class="faq-icon fs-4">🎯</div>
                <div>
                    <h5>Hướng dẫn đặt hàng</h5>
                    <p>Chọn sản phẩm → Thêm vào giỏ → Nhập thông tin giao hàng → Thanh toán.</p>
                    <a href="<?= BASE_URL ?>/index.php?url=faq/introduction_faq">Đọc thêm</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
