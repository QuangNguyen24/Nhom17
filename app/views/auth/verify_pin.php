<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card p-4">
        <h3 class="text-center text-primary">Xác thực mã PIN</h3>
        <form method="POST">
          <div class="form-floating mb-3">
            <input type="text" name="pin" class="form-control" placeholder="Nhập mã PIN" required>
            <label>Mã PIN</label>
          </div>
          <button type="submit" class="btn btn-primary w-100">Xác nhận</button>
          <?php if (isset($error)) echo "<div class='alert alert-danger mt-3 text-center'>$error</div>"; ?>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
