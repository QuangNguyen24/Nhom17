<?php include_once __DIR__ . '/../layouts/header.php'; 
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: ' . BASE_URL . '/index.php?url=auth/login');
    exit;
}

?>

<section class="py-5">
  <div class="container">
    <h2 class="mb-4"> Giỏ hàng của bạn</h2>

    <?php if (!empty($products)): ?>
      <form action="<?= BASE_URL ?>/index.php?url=cart/update" method="post">
        <div class="table-responsive">
          <table class="table table-bordered align-middle text-center table-hover">
            <thead class="table-dark text-nowrap">
              <tr>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
                <th>Xóa</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $total = 0;
                foreach ($products as $item):
                  $price = $item['discount_price'] > 0 ? $item['discount_price'] : $item['price'];
                  $subtotal = $price * $item['quantity'];
                  $total += $subtotal;
              ?>
              <tr>
                <td><img src="<?= htmlspecialchars($item['image']) ?>" class="img-fluid rounded" style="max-width: 60px;" alt="<?= $item['name'] ?>"></td>
                <td class="text-start"><?= htmlspecialchars($item['name']) ?></td>
                <td class="text-nowrap"><?= number_format($price, 0, ',', '.') ?> VND</td>
                <td style="max-width: 100px;">
                  <input
                    type="number"
                    name="quantities[<?= $item['id'] ?>]"
                    value="<?= $item['quantity'] ?>"
                    min="1"
                    class="form-control text-center quantity-input"
                    data-id="<?= $item['id'] ?>"
                    data-price="<?= $price ?>"
                  >
                </td>
                <td class="text-nowrap subtotal" id="subtotal-<?= $item['id'] ?>"><?= number_format($subtotal, 0, ',', '.') ?>₫</td>
                <td>
                  <a href="<?= BASE_URL ?>/index.php?url=cart/remove/<?= $item['id'] ?>" class="btn btn-sm btn-danger">Xóa</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="row mt-3 gy-2 gx-2">
          <div class="col-md-auto">
            <a href="<?= BASE_URL ?>/index.php?url=product/index" class="btn btn-outline-secondary ">← Tiếp tục mua sắm</a>
          </div>
          <div class="col text-end">
            <h5>Tổng cộng: <strong id="total-price" class="text-danger"><?= number_format($total) ?> VND</strong></h5>
            <div class="d-flex flex-wrap justify-content-end gap-2">
               <button type="submit" class="btn btn-primary">Cập nhật giỏ hàng</button>
              <a href="<?= BASE_URL ?>/index.php?url=checkout" class="btn btn-success">Thanh toán</a>
              <a href="<?= BASE_URL ?>/index.php?url=cart/clear" class="btn btn-outline-danger">Xóa toàn bộ</a>
            </div>
          </div>
        </div>

      </form>
    <?php else: ?>
      <div class="alert alert-info">Giỏ hàng của bạn đang trống. <a href="<?= BASE_URL ?>/index.php?url=product/index">Mua sắm ngay</a>.</div>
    <?php endif; ?>
  </div>
</section>

<script>
  document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('input', function () {
      const price = parseFloat(this.dataset.price);
      const quantity = parseInt(this.value) || 1;
      const id = this.dataset.id;

      // Cập nhật subtotal từng sản phẩm
      const subtotal = price * quantity;
      document.getElementById('subtotal-' + id).textContent = subtotal.toLocaleString('vi-VN') + '₫';

      // Tính lại tổng
      let total = 0;
      document.querySelectorAll('.quantity-input').forEach(input => {
        const p = parseFloat(input.dataset.price);
        const q = parseInt(input.value) || 1;
        total += p * q;
      });
      document.getElementById('total-price').textContent = total.toLocaleString('vi-VN') + '₫';
    });
  });
</script>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
