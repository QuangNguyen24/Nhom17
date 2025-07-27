<?php
define('BASE_URL', rtrim((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST']
    . str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']), '/'));

