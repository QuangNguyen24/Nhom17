<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5 mb-5">
  <h2 class="fw-bold text-uppercase text-primary mb-4">Liên hệ hỗ trợ</h2>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">✅ Gửi liên hệ thành công! Chúng tôi sẽ phản hồi sớm nhất.</div>
    <?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger">❌ Gửi liên hệ thất bại. Vui lòng điền đầy đủ thông tin.</div>
    <?php endif; ?>


  <div class="row">
    <!-- FORM -->
    <div class="col-lg-7 mb-4">
      <div class="border rounded p-4 bg-white shadow-sm">
        <form action="index.php?url=contact/send" method="post">
            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Họ và tên *</label>
                <input type="text" name="fullname" class="form-control" required>
            </div>
          
            <div class="mb-3">
                <label class="form-label">Nội dung *</label>
                <textarea name="message" rows="5" class="form-control" placeholder="Vui lòng mô tả chi tiết" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary px-5">Gửi liên hệ</button>
        </form>
      </div>
    </div>

    <!-- INFO -->
    <div class="col-lg-5">
      <div class="bg-white p-4 rounded shadow-sm">
        <h5 class="fw-bold mb-3">Thông tin liên hệ khác</h5>
        <p>Email hỗ trợ: <a href="mailto:hotro@example.com">nexorevn@gmail.com</a></p>
        <p>Hotline: <strong class="text-danger">0932088279</strong></p>
        <hr>
        <h6 class="fw-bold mt-4">Văn phòng</h6>
        <p>Nexorevn Inc.<br>140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, TP.HCM</p>
        <div class="ratio ratio-4x3 rounded overflow-hidden">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3546.5517694782366!2d106.62609067451758!3d10.80615915864564!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752be27d8b4f4d%3A0x92dcba2950430867!2sHCMC%20University%20of%20Industry%20and%20Trade!5e1!3m2!1sen!2s!4v1748351636256!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
