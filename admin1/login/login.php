<?php
session_start();
include "../db.php";

// Hiển thị tất cả các lỗi (Chỉ sử dụng trong quá trình phát triển)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error_message = "";

if (isset($_POST["login"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    
    // Khởi tạo biến $result
    $result = null;

    // Kiểm tra tên đăng nhập và mật khẩu không được để trống
    if (empty($username) && empty($password)) {
        $error_message = "Tên đăng nhập và mật khẩu không được để trống";
    } elseif (empty($username)) {
        $error_message = "Tên đăng nhập không được để trống";
    } elseif (empty($password)) {
        $error_message = "Mật khẩu không được để trống";
    } else {
        $sql = "SELECT * FROM user WHERE userName='$username'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                if ($row['roleUser'] == 1) {  // Kiểm tra role có bằng 1 không
                    $_SESSION['userName'] = $row['userName'];
                    if (!empty($_SESSION['previous_page'])) {
                        header("Location: " . $_SESSION['previous_page']);
                    } else {
                        header("Location: ../home/home.php");
                    }
                    exit();
                } else {
                    $error_message = "Bạn không có quyền truy cập vào trang này.";
                }
            } else {
                $error_message = "Sai tên đăng nhập hoặc mật khẩu.";
            }
        } else {
            $error_message = "Sai tên đăng nhập hoặc mật khẩu.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
/* Đặt các thuộc tính cơ bản cho toàn bộ trang */
body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: #f0f0f0; /* Màu nền cho trang */
}

/* Cấu hình cho phần chứa form đăng nhập */
.form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Cấu hình cho form đăng nhập */
.sign-in-form {
    background: #ffffff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

/* Cấu hình cho tiêu đề của form */
.title {
    font-size: 1.8rem;
    color: #333;
    margin-bottom: 1rem;
}

/* Cấu hình cho các trường nhập liệu */
.input-field {
    margin-bottom: 1rem;
}

.input-field input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1rem;
}

/* Cấu hình cho thông báo lỗi */
.error-message {
    font-size: 0.9rem;
    color: #dc3545; /* Màu đỏ cho thông báo lỗi */
    margin-bottom: 1rem;
}

/* Cấu hình cho nút bấm */
.btn {
    background-color: #007bff; /* Màu nền của nút */
    color: #fff;
    border: none;
    padding: 0.75rem;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn.solid:hover {
    background-color: #0056b3; /* Màu nền khi di chuột qua */
}

    </style>
</head>
<body>
<div class="form-container sign-in">
    <form action="" method="POST" class="sign-in-form">
        <h1 class="title">Admin</h1>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-message" style="color: red;">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="input-field">
            <input type="text" name="username" placeholder="Username" />
        </div>
        <div class="input-field">
            <input type="password" name="password" placeholder="Password" />
        </div>
        
        <button type="submit" name="login" value="Login" class="btn solid">Sign In</button>
    </form>
</div>
</body>
</html>
