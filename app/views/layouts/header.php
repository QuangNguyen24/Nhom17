<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../app/core/Database.php';
$conn = Database::connect();

$current_page = basename($_SERVER['PHP_SELF']);
$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
$current_route = $_GET['url'] ?? 'home/index'; // Mặc định nếu không có thì là trang chủ

?>

<!DOCTYPE html>
<html lang="vi">
  <link rel="icon" href="/images/logo/favicon.ico" type="image/x-icon">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Nexorevn E-commerce </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  


  <style>
    .navbar.blur-on-scroll {
      backdrop-filter: blur(8px);
      background-color: rgba(33, 37, 41, 0.85);
      transition: all 0.3s ease;
    }
    .navbar {
      background-color: #000000;
      transition: all 0.3s ease;
    }
    body { padding-top: 5rem; }
    .nav-link.active {
      border-bottom: 2px solid #ffc107;
      color: #ffc107 !important;
    }

    html {
  scroll-padding-top: 120px !important;
  scroll-behavior: smooth;
}
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top py-3">
  <div class="container">
    <a class="navbar-brand" href="<?= BASE_URL ?>/index.php?url=home/index"> <img src="<?= BASE_URL ?>/images/logo/Nexore_logo_unback.png" alt="Mô Hình " style="height: 48px; object-fit: contain;" ></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link <?= str_starts_with($current_route, 'home') ? 'active' : '' ?>" href="<?= BASE_URL ?>/index.php?url=home/index">Trang chủ</a></li>
        <li class="nav-item"><a class="nav-link <?= str_starts_with($current_route, 'about') ? 'active' : '' ?>" href="<?= BASE_URL ?>/index.php?url=about/index">Về chúng tôi</a></li>
        <li class="nav-item"><a class="nav-link <?= str_starts_with($current_route, 'guide') ? 'active' : '' ?>" href="<?= BASE_URL ?>/index.php?url=guide/index">Cẩm nang</a></li>
        <li class="nav-item"><a class="nav-link <?= str_starts_with($current_route, 'product') ? 'active' : '' ?>" href="<?= BASE_URL ?>/index.php?url=product/index">Sản phẩm</a></li>
        <li class="nav-item"><a class="nav-link <?= str_starts_with($current_route, 'faq') ? 'active text-warning fw-bold' : '' ?>" href="<?= BASE_URL ?>/index.php?url=faq/index">Hỏi đáp</a></li>

      </ul>
      <form class="d-flex me-3" action="<?= BASE_URL ?>/index.php" method="get">
        <input type="hidden" name="url" value="product/index">
        <input class="form-control me-2" type="search" name="keyword" placeholder="Tìm sản phẩm..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
      </form>

      <ul class="navbar-nav">
        <?php if (isset($_SESSION['user'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
              <i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['user']) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?= BASE_URL ?>/index.php?url=order/index">
                <i class="fas fa-box"></i> Lịch sử đơn hàng
              </a></li>

              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link btn btn-primary text-white" href="<?= BASE_URL ?>/index.php?url=auth/login"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link <?= str_starts_with($current_route, 'cart') ? 'active' : '' ?>" href="<?= BASE_URL ?>/index.php?url=cart/index">

            <i class="fas fa-cart-shopping"></i>
            <span class="badge bg-primary"><?= $cart_count ?></span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  window.addEventListener("scroll", function() {
    const navbar = document.querySelector(".navbar");
    if (window.scrollY > 30) {
      navbar.classList.add("blur-on-scroll");
    } else {
      navbar.classList.remove("blur-on-scroll");
    }
  });
</script>
