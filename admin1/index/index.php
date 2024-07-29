<?php

session_start();
include("../db.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>Document</title>
    <style>
        
        body {
            display: flex;
        }
        .side-menu {
            width: 250px;
            background-color: #f8f8f8;
            border-right: 1px solid #ddd;
            position: fixed;
            height: 100%;
            overflow: auto;
        }
        .main-content {
            margin-left: 100px;
            padding: 20px;
            width: calc(40% - 250px);
        }
        .navbar-nav > li {
            width: 100%;
        }
        .navbar-nav > li > a {
            padding: 10px 15px;
        }
        .nav-link1 {
            color: #000000;
            font-weight: bold;
        }

    </style>
</head>

<body>
    <div class="side-menu">
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <div class="brand-wrapper">
                    <a class="navbar-brand" href="../home/home.php">
                        <img src="../../Photos/logo/logo.png" alt="Logo" width="80" height="20">
                    </a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
            </div>
            <div class="side-menu-container collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="../home/home.php"><i class="fa-solid fa-house"></i> Admin dashboard</a></li>
                    <li><a href="../search/search.php"><i class="fa-solid fa-magnifying-glass"></i> search</a></li>
                    <li><a href="../product/products_index.php"><i class="fa-solid fa-bag-shopping"></i> Quản lý sản phẩm</a></li>
                    <li><a href="../order/order_index.php"><i class="fa-brands fa-buy-n-large"></i> Đơn hàng</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa-solid fa-user"></i> Account <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <?php if (isset($_SESSION['userName'])) {
                                    echo "<div class='nav-item'>
                                    <a class='nav-link1'>" . $_SESSION['userName'] . "</a>
                                    </div>";
                                } ?>
                            </li>
                            <li><a href="../account/account_index.php">Quản lý tài khoản</a></li>
                            <li><a href="#" id="logout-link">Đăng xuất</a></li>
                        </ul>
                    </li>
                    <li><a href="../feedback/feedback_index.php"><i class="fa-solid fa-envelope"></i> FeedBack</a></li>
                    <li><a href="#"><i class="fa-solid fa-gear"></i> Setting</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="main-content">
        <!-- Your main content goes here -->
    </div>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script>
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm("Bạn có chắc muốn đăng xuất không?")) {
                sessionStorage.removeItem('isLoggedIn');
                window.location.href = "../login/logout.php";
            }
        });
        $(document).ready(function () {
            $('.navbar-toggle').click(function () {
                $('.side-menu .navbar-nav').toggleClass('active');
            });
        });
    </script>
</body>
</html>