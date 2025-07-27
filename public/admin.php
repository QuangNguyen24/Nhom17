<?php
session_start();
require_once __DIR__ . '/../app/init.php';


if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php'); exit;
}

new App('admin'); // nạp controller theo namespace admin
