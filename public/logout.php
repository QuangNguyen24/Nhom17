<?php
session_start();
session_unset(); // hoặc unset($_SESSION['user']);
session_destroy();

// Điều hướng về trang chủ
header('Location: index.php');
exit;
