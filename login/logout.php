<?php
// Bắt đầu phiên làm việc
session_start();

// Hủy tất cả dữ liệu đã đăng ký trong phiên làm việc
session_destroy();

// Chuyển hướng người dùng quay lại trang trước đó
// HTTP_REFERER là một biến máy chủ chứa địa chỉ của trang trước đó
header("Location: {$_SERVER['HTTP_REFERER']}");

// Kết thúc script để đảm bảo không có mã nào khác được thực thi
exit();
?>
