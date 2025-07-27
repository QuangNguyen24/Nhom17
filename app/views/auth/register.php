<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<style>
    .register-card {
        background: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
    }

    .toggle-password {
      
        cursor: pointer;
        font-size: 1rem;
        color: #0d6efd;
    }

    .progress {
        height: 5px;
    }

    .btn-success {
        background-color: #007bff;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #0056b3;
    }

    body {
        background-color: #f8f9fa;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div class="register-card">
                <h2 class="text-center mb-4 text-primary fw-bold">
                    <i class="fas fa-user-plus me-2"></i>ĐĂNG KÝ
                </h2>
                <form method="POST" autocomplete="off">
                    <div class="form-floating mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Tên tài khoản" required>
                        <label><i class="fas fa-user me-1"></i> Tên tài khoản</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                        <label><i class="fas fa-envelope me-1"></i> Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" required>
                        <label><i class="fas fa-phone me-1"></i> Số điện thoại</label>
                    </div>

                   <!-- MẬT KHẨU -->
                    <div class="mb-3">
                        <label for="password" class="form-label"><i class="fas fa-lock me-1"></i> Mật khẩu</label>
                        <div class="input-group position-relative">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required oninput="checkPasswordStrength()">
                            <span class="input-group-text bg-white">
                                <i class="fa fa-eye toggle-password" id="togglePassword" onclick="togglePassword('password')"></i>
                            </span>
                        </div>
                        <div class="progress mt-2">
                            <div id="strengthBar" class="progress-bar" style="width: 0;"></div>
                        </div>
                        <small id="strengthText" class="text-muted">Độ mạnh mật khẩu</small>
                    </div>

                    <!-- XÁC NHẬN -->
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label"><i class="fas fa-lock me-1"></i> Xác nhận mật khẩu</label>
                        <div class="input-group position-relative">
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                            <span class="input-group-text bg-white">
                                <i class="fa fa-eye toggle-password" id="toggleConfirmPassword" onclick="togglePassword('confirmPassword')"></i>
                            </span>
                        </div>
                    </div>     

                    <button type="submit" class="btn btn-primary w-100">Xác nhận đăng ký</button>

                    <p class="mt-3 text-center">Bạn đã có tài khoản?
                        <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-primary fw-semibold">Đăng nhập</a>
                    </p>

                    <?php if (isset($error)) echo "<p class='mt-3 text-danger text-center'>$error</p>"; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById(id === 'password' ? 'togglePassword' : 'toggleConfirmPassword');
        if (input.type === "password") {
            input.type = "text";
            icon.className = "fa fa-eye-slash toggle-password";
        } else {
            input.type = "password";
            icon.className = "fa fa-eye toggle-password";
        }
    }

    function checkPasswordStrength() {
        const password = document.getElementById("password").value;
        const strengthBar = document.getElementById("strengthBar");
        const strengthText = document.getElementById("strengthText");

        let strength = 0;
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/\d/.test(password)) strength++;
        if (/[\W_]/.test(password)) strength++;

        if (strength <= 2) {
            strengthText.textContent = "Yếu";
            strengthBar.style.width = "25%";
            strengthBar.className = "progress-bar bg-danger";
        } else if (strength <= 4) {
            strengthText.textContent = "Trung bình";
            strengthBar.style.width = "60%";
            strengthBar.className = "progress-bar bg-warning";
        } else {
            strengthText.textContent = "Mạnh";
            strengthBar.style.width = "100%";
            strengthBar.className = "progress-bar bg-success";
        }
    }
</script>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
