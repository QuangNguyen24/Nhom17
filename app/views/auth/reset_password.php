<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<style>
  .toggle-password {
    cursor: pointer;
    color: #0d6efd;
  }
  .progress {
    height: 5px;
  }
</style>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card p-4 shadow">
        <h3 class="text-center text-primary mb-4">Đặt lại mật khẩu</h3>
        <form method="POST" onsubmit="return validatePasswords();">
          <!-- Mật khẩu mới -->
          <div class="mb-3">
            <label class="form-label">Mật khẩu mới</label>
            <div class="input-group">
              <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu mới" required oninput="checkPasswordStrength()">
              <span class="input-group-text bg-white"><i class="fa fa-eye toggle-password" onclick="togglePassword('password', this)"></i></span>
            </div>
            <div class="progress mt-2">
              <div id="strengthBar" class="progress-bar" style="width: 0%;"></div>
            </div>
            <small id="strengthText" class="text-muted">Độ mạnh mật khẩu</small>
          </div>

          <!-- Xác nhận mật khẩu -->
          <div class="mb-3">
            <label class="form-label">Xác nhận mật khẩu</label>
            <div class="input-group">
              <input type="password" name="confirm_password" id="confirmPassword" class="form-control" placeholder="Nhập lại mật khẩu" required>
              <span class="input-group-text bg-white"><i class="fa fa-eye toggle-password" onclick="togglePassword('confirmPassword', this)"></i></span>
            </div>
          </div>

          <!-- Thông báo lỗi xác nhận -->
          <div id="clientError" class="alert alert-danger d-none text-center"></div>

          <!-- Nút submit -->
          <button type="submit" class="btn btn-primary w-100">Xác nhận</button>
          <?php if (isset($error)) echo "<div class='alert alert-danger mt-3 text-center'>$error</div>"; ?>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Script xử lý -->
<script>
  function togglePassword(id, icon) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }

  function checkPasswordStrength() {
    const pw = document.getElementById("password").value;
    const bar = document.getElementById("strengthBar");
    const text = document.getElementById("strengthText");
    let strength = 0;

    if (pw.length >= 8) strength++;
    if (/[a-z]/.test(pw)) strength++;
    if (/[A-Z]/.test(pw)) strength++;
    if (/\d/.test(pw)) strength++;
    if (/[\W_]/.test(pw)) strength++;

    if (strength <= 2) {
      bar.style.width = "25%";
      bar.className = "progress-bar bg-danger";
      text.textContent = "Yếu";
    } else if (strength <= 4) {
      bar.style.width = "60%";
      bar.className = "progress-bar bg-warning";
      text.textContent = "Trung bình";
    } else {
      bar.style.width = "100%";
      bar.className = "progress-bar bg-success";
      text.textContent = "Mạnh";
    }
  }

  function validatePasswords() {
    const pw = document.getElementById("password").value;
    const cpw = document.getElementById("confirmPassword").value;
    const alertBox = document.getElementById("clientError");

    if (pw !== cpw) {
      alertBox.textContent = "Mật khẩu xác nhận không khớp.";
      alertBox.classList.remove("d-none");
      return false;
    }

    alertBox.classList.add("d-none");
    return true;
  }
</script>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
