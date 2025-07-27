<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<style>
    .login-card {
        width: 100%;
        max-width: 450px;
        background: rgba(255, 255, 255, 0.95);
        padding: 30px 25px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
        width: 100%;
        background-color: #007bff;
        transition: 0.3s;
    }

    

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .toggle-password {
        cursor: pointer;
       color: #0d6efd;
         cursor: pointer;
    }

    body {
        background: #f8f9fa;
    }
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-8">
            <div class="login-card">
                <h2 class="text-center text-primary fw-bold mb-4">
                    <i class="fas fa-sign-in-alt me-2"></i> ĐĂNG NHẬP
                </h2>
                <form method="POST" autocomplete="on">
                    <!-- Username -->
                    <div class="form-floating mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Tài khoản" required>
                        <label><i class="fas fa-user me-1"></i> Tài khoản</label>
                    </div>

                    <!-- Password with input-group -->
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock me-1"></i> Mật khẩu</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Mật khẩu" required>
                            <span class="input-group-text bg-white">
                                <i class="fas fa-eye toggle-password" id="togglePassword" onclick="togglePassword('password', this)"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Button -->
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>

                    <!-- Links -->
                    <div class="mt-3 text-center">
                        Bạn chưa có tài khoản?
                        <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="text-primary fw-semibold text-decoration-none">Đăng ký</a>
                    </div>
                    <div class="mt-2 text-center">
                        <a href="<?= BASE_URL ?>/index.php?url=auth/forgot_password" class="text-danger fw-semibold text-decoration-none">
                            <i class="fas fa-unlock-alt me-1"></i> Quên mật khẩu?
                        </a>
                    </div>

                    <!-- Error -->
                    <?php if (isset($error)) echo "<p class='mt-3 text-danger text-center'>$error</p>"; ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast container -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
    <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
        <div class="toast-body fw-semibold">
            <?= $error ?? '' ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    </div>

</div>

<script>
    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }

    <?php if (isset($error)): ?>
    window.addEventListener("DOMContentLoaded", () => {
      const toast = new bootstrap.Toast(document.getElementById('errorToast'), { delay: 4000 });
      toast.show();
    });
  <?php endif; ?>
</script>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
