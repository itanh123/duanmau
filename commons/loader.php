<?php
// Tự động tải các file cần thiết

// Tải các hàm tiện ích
require_once "commons/env.php";
require_once "commons/function.php";

// Tự động load Model và Controller chính
spl_autoload_register(function ($className) {
    // Nếu là Admin Controller hoặc Admin Model
    if (file_exists("admin/controllers/$className.php")) {
        require_once "admin/controllers/$className.php";
    } elseif (file_exists("admin/models/$className.php")) {
        require_once "admin/models/$className.php";
    }
    // Nếu là Controller hoặc Model thường
    elseif (file_exists("controllers/$className.php")) {
        require_once "controllers/$className.php";
    } elseif (file_exists("models/$className.php")) {
        require_once "models/$className.php";
    }
});
