<?php
session_start();
include "../db.php";

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Kiểm tra username và password có trống không
    if (empty($username)) {
        header("Location: login.php?error=User Name is required");
        exit();
    } elseif (empty($password)) {
        header("Location: login.php?error=Password is required");
        exit();
    } else {
        // Sử dụng Prepared Statement để tránh SQL Injection
        $sql = "SELECT * FROM user WHERE userName = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            // Kiểm tra mật khẩu
            if (password_verify($password, $row['password'])) {
                $_SESSION['userName'] = $row['userName'];
                // Điều hướng đến trang trước đó hoặc trang chủ
                if (!empty($_SESSION['previous_page'])) {
                    header("Location: " . $_SESSION['previous_page']);
                } else {
                    header("Location: ../index/index.php");
                }
                exit();
            } else {
                header("Location: login.php?error=Incorrect User name or password");
                exit();
            }
        } else {
            header("Location: login.php?error=Incorrect User name or password");
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>
