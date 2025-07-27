<!DOCTYPE html>
<html lang="vi">
  <link rel="icon" href="/images/logo/favicon.ico" type="image/x-icon">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body { background-color: #ffffff; color: #fff; }
        .sidebar {
            height: 100vh; background-color: #1e1e2f; padding-top: 20px; position: fixed; width: 250px;
        }
        .sidebar a {
            color: #ccc; text-decoration: none; padding: 12px 20px; display: block;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #2a2a40; color: #fff;
        }
        .content {
            margin-left: 260px; padding: 20px;
        }
        .card {
            background-color: #ffffff; border: none; color: #000000;
        }
        form, .form-control, .form-check-label {
            color: #212529;
        }
        .bg-white {
            background-color: #fff !important;
        }
    </style>
</head>
<body>
<div class="d-flex">

    <div class="sidebar">
        <h4 class="text-center text-white"> QUẢN TRỊ VIÊN</h4>

        <a class="d-block text-white" href="<?= BASE_URL ?>/admin.php?url=dashboard/index">
            <i class="fas fa-solid fa-bars"></i> Bảng điều khiển
        </a>
        <a class="d-block text-white" href="<?= BASE_URL ?>/admin.php?url=banner/index">
            <i class="bi bi-image"></i> Quản lý banner
        </a>
        <a class="d-block text-white" href="<?= BASE_URL ?>/admin.php?url=category/index">
            <i class="bi bi-tags"></i> Quản lý danh mục
        </a>
        <a class="d-block text-white" href="<?= BASE_URL ?>/admin.php?url=brand/index">
            <i class="bi bi-building"></i> Quản lý thương hiệu
        </a>
        <a class="d-block text-white" href="<?= BASE_URL ?>/admin.php?url=product/index">
            <i class="bi bi-box-seam"></i> Quản lý sản phẩm
        </a>
        <a class="d-block text-white" href="<?= BASE_URL ?>/admin.php?url=order/index">
            <i class="bi bi-cart4"></i> Quản lý đơn hàng
        </a>
        <a class="d-block text-white" href="<?= BASE_URL ?>/admin.php?url=user/index">
            <i class="bi bi-people"></i> Quản lý người dùng
        </a>
        <a class="d-block text-white" href="<?= BASE_URL ?>/admin.php?url=contact/index">
            <i class="bi bi-envelope"></i> Liên hệ khách hàng
        </a>
        <a class="d-block text-white" href="<?= BASE_URL ?>/../index.php?url=home/index">
            <i class="bi bi-house"></i> Về trang người dùng
        </a>
        <a class="d-block text-white" href="<?= BASE_URL ?>/admin.php?url=auth/logout">
            <i class="bi bi-box-arrow-right"></i> Đăng xuất
        </a>
    </div>

</div>
<div class="content">
