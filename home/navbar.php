<?php
session_start(); // Khởi tạo phiên làm việc

include("../db.php"); // Kết nối cơ sở dữ liệu

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cartNumber'])) {
    $_SESSION['cartNumber'] = 0;
    $_SESSION['cartItem'] = [];
}

// CLICK "THÊM VÀO GIỎ HÀNG" TRONG TRANG CHI TIẾT SẢN PHẨM
if (isset($_POST['addToCart'])) {

    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!isset($_SESSION['userName'])) {
        // Nếu chưa đăng nhập, lưu trang hiện tại và chuyển hướng đến trang đăng nhập
        $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
        header("Location: ../login/login.php");
        exit(); 
    } else {
        $_SESSION['cartNumber']++; // Tăng số lượng sản phẩm trong giỏ hàng
        $userName = $_SESSION["userName"];
        
        // Lấy userID của người dùng từ cơ sở dữ liệu
        $sqlUseerID = "SELECT userID FROM user WHERE userName = '$userName'";
        $resultUserID = $conn->query($sqlUseerID);

        $userID = null;

        if ($resultUserID && $resultUserID->num_rows > 0) {
            while ($row = $resultUserID->fetch_assoc()) {
                $userID = $row['userID'];
            }

            // Tạo mảng thông tin sản phẩm
            $productCart = array(
                'productID' => $_POST['productID'],
                'productName' => $_POST['productName'],
                'imageLink' => $_POST['imageLink'],
                'quantity' => $_POST['quantity'],
                'unitPrice' => $_POST['unitPrice'],
                'userID' => $userID
            );

            // Kiểm tra nếu sản phẩm đã có trong giỏ hàng, thì chỉ tăng số lượng
            $flag = true;
            foreach ($_SESSION['cartItem'] as &$item) {
                if ($item['productID'] == $_POST['productID']) {
                    $item['quantity'] += $_POST['quantity'];
                    $_SESSION['cartNumber']--;
                    $flag = false;
                }
            }
            unset($item); // Hủy tham chiếu của biến $item
            
            // Nếu sản phẩm không có trong giỏ hàng, thêm sản phẩm mới vào giỏ
            if ($flag) {
                $_SESSION['cartItem'][] = $productCart;

                // Cập nhật cơ sở dữ liệu giỏ hàng
                if (!empty($_SESSION['cartItem'])) {
                    foreach ($_SESSION['cartItem'] as $item) {
                        $productID = $item['productID'];
                        $cartQuantity = $item['quantity'];
                        $totalMoney = $item['quantity'] * $item['unitPrice'];

                        $sqlInsertCart = "TRUNCATE TABLE `eproject`.`carts`; 
                        INSERT INTO `eproject`.`carts` (`cartID`, `productID`, `cartCode`, `userID`, `cartQuantity`, `totalMoney`)
                        VALUES (DEFAULT,'$productID', '1', '$userID','$cartQuantity','$totalMoney')";
                        $resultInsertCart = $conn->query($sqlInsertCart);
                    }
                }
            }
        }
    }
}

// CLICK "MUA NGAY" 
if (isset($_POST['buyNow'])) {

    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!isset($_SESSION['userName'])) {
        // Nếu chưa đăng nhập, lưu trang hiện tại và chuyển hướng đến trang đăng nhập
        $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
        header("Location: ../login/login.php");
        exit(); 
    } else {
        $_SESSION['cartNumber']++; // Tăng số lượng sản phẩm trong giỏ hàng
        $userName = $_SESSION["userName"];
        
        // Lấy userID của người dùng từ cơ sở dữ liệu
        $sqlUseerID = "SELECT userID FROM user WHERE userName = '$userName'";
        $resultUserID = $conn->query($sqlUseerID);

        $userID = null;

        if ($resultUserID && $resultUserID->num_rows > 0) {
            while ($row = $resultUserID->fetch_assoc()) {
                $userID = $row['userID'];
            }

            // Tạo mảng thông tin sản phẩm
            $productCart = array(
                'productID' => $_POST['productID'],
                'productName' => $_POST['productName'],
                'imageLink' => $_POST['imageLink'],
                'quantity' => $_POST['quantity'],
                'unitPrice' => $_POST['unitPrice'],
                'userID' => $userID
            );

            // Kiểm tra nếu sản phẩm đã có trong giỏ hàng, thì chỉ tăng số lượng
            $flag = true;
            foreach ($_SESSION['cartItem'] as &$item) {
                if ($item['productID'] == $_POST['productID']) {
                    $item['quantity'] += $_POST['quantity'];
                    $_SESSION['cartNumber']--;
                    $flag = false;
                }
            }
            unset($item); // Hủy tham chiếu của biến $item
            
            // Nếu sản phẩm không có trong giỏ hàng, thêm sản phẩm mới vào giỏ
            if ($flag) {
                $_SESSION['cartItem'][] = $productCart;

                // Cập nhật cơ sở dữ liệu giỏ hàng
                $productID = $_POST['productID'];
                $cartQuantity = $_POST['quantity'];
                $totalMoney = $_POST['quantity'] * $_POST['unitPrice'];

                $sqlInsertCart = "INSERT INTO `eproject`.`carts` (`cartID`, `productID`, `cartCode`, `userID`, `cartQuantity`, `totalMoney`)
                VALUES (DEFAULT,'$productID', '1', '$userID','$cartQuantity','$totalMoney')";
                $resultInsertCart = $conn->query($sqlInsertCart);
            }
        }
        
        // Chuyển hướng đến trang giỏ hàng
        header("Location: ../productDetail/viewCart.php");
    }
}

// CLICK "THANH TOÁN" TRONG TRANG GIỎ HÀNG
if (!isset($_SESSION['checkoutItems'])) {
    $_SESSION['checkoutItems'] = [];
}

if (isset($_POST["submitCheckout"])) {
    $_SESSION['checkoutItems'] = []; // Xóa danh sách sản phẩm đã thanh toán
    $userName = $_SESSION["userName"];
    
    // Lấy userID của người dùng từ cơ sở dữ liệu
    $sqlUseerID = "SELECT userID FROM user WHERE userName = '$userName'";
    $resultUserID = $conn->query($sqlUseerID);

    while ($row = $resultUserID->fetch_assoc()) {
        $userID = $row['userID'];
    }

    // Thêm các sản phẩm vào danh sách thanh toán
    for ($i = 0; $i < count($_SESSION['cartItem']); $i++) {
        $checkoutItem = array(
            "productID" => $_POST["productID$i"],
            "productName" => $_POST["productName$i"],
            "imageLink" => $_POST["imageLink$i"],
            "quantity" => $_POST["quantity$i"],
            "unitPrice" => $_POST["unitPrice$i"],
            "userID" => $_POST["userID$i"]
        );
        $_SESSION['checkoutItems'][] = $checkoutItem;
    }

    // Cập nhật cơ sở dữ liệu giỏ hàng sau khi thanh toán
    if (!empty($_SESSION['cartItem'])) {
        $truncateTableCart = "TRUNCATE TABLE `eproject`.`carts`;";
        $resultTruncateTableCart = $conn->query($truncateTableCart);

        foreach ($_SESSION['checkoutItems'] as $item) {
            $productID = $item['productID'];
            $cartQuantity = $item['quantity'];
            $totalMoney = $item['quantity'] * $item['unitPrice'];

            $sqlInsertCart = "INSERT INTO `eproject`.`carts` (`cartID`, `productID`, `cartCode`, `userID`, `cartQuantity`, `totalMoney`) 
            VALUES (DEFAULT,'$productID', '1', '$userID','$cartQuantity','$totalMoney')";
            $resultInsertCart = $conn->query($sqlInsertCart);
        }
    }
    
    // Chuyển hướng đến trang thanh toán
    header("Location: viewCheckout.php");
}

// CLICK "THÊM VÀO GIỎ HÀNG" TRONG TRANG DANH SÁCH SẢN PHẨM
if (isset($_POST['addToCartButton'])) {

    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!isset($_SESSION['userName'])) {
        // Nếu chưa đăng nhập, lưu trang hiện tại và chuyển hướng đến trang đăng nhập
        $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
        header("Location: ../login/login.php");
        exit(); 
    } else {
        $_SESSION['cartNumber']++; // Tăng số lượng sản phẩm trong giỏ hàng
        $userName = $_SESSION["userName"];
        
        // Lấy userID của người dùng từ cơ sở dữ liệu
        $sqlUseerID = "SELECT userID FROM user WHERE userName = '$userName'";
        $resultUserID = $conn->query($sqlUseerID);

        while ($row = $resultUserID->fetch_assoc()) {
            $userID = $row['userID'];
        }

        // Tạo mảng thông tin sản phẩm
        $productCart = array(
            'productID' => $_POST['productID'],
            'productName' => $_POST['productName'],
            'imageLink' => "../".$_POST['imageLink'],
            'quantity' => 1,
            'unitPrice' => $_POST['unitPrice'],
            'userID' => $userID
        );

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng, thì chỉ tăng số lượng
        $flag = true;
        foreach ($_SESSION['cartItem'] as &$item) {
            if ($item['productID'] == $_POST['productID']) {
                $item['quantity'] += 1;
                $_SESSION['cartNumber']--;
                $flag = false;
            }
        }
        unset($item); // Hủy tham chiếu của biến $item
        
        // Nếu sản phẩm không có trong giỏ hàng, thêm sản phẩm mới vào giỏ
        if ($flag) {
            $_SESSION['cartItem'][] = $productCart;

            // Cập nhật cơ sở dữ liệu giỏ hàng
            if (!empty($_SESSION['cartItem'])) {
                $truncateTableCart = "TRUNCATE TABLE `eproject`.`carts`;";
                $resultTruncateTableCart = $conn->query($truncateTableCart);

                foreach ($_SESSION['cartItem'] as $item) {
                    $productID = $item['productID'];
                    $cartQuantity = $item['quantity'];
                    $totalMoney = $item['quantity'] * $item['unitPrice'];

                    $sqlInsertCart = "INSERT INTO `eproject`.`carts` (`cartID`, `productID`, `cartCode`, `userID`, `cartQuantity`, `totalMoney`) 
                    VALUES (DEFAULT,'$productID', '1', '$userID','$cartQuantity','$totalMoney')";
                    $resultInsertCart = $conn->query($sqlInsertCart);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oceangate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="fixed-top">
        <nav class="navbar navbar-expand-md navbar-light bg-white">
            <a class="navbar-brand" href="../index/index.php">
                <img src="../Photos/Logo/logo.png" alt="Logo" width="125" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav m-auto font-size-25">
                    <li class="nav-item m-3">
                        <a class="nav-link fw-bold" id="home" href="../index/index.php">HOME</a>
                    </li>

                    <li class="nav-item  m-3 dropdown">
                        <a class="nav-link dropdown-toggle fw-bold" id="category" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            CATEGORIES
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownCate">
                            <a class="dropdown-item" href="../listPage/viewListCategory.php?category=1">HDD</a>
                            <a class="dropdown-item" href="../listPage/viewListCategory.php?category=2">SSD</a>
                            <a class="dropdown-item" href="../listPage/viewListCategory.php?category=3">USB</a>
                            <a class="dropdown-item" href="../listPage/viewListCategory.php?category=4">Memory Card</a>
                            <a class="dropdown-item" href="../listPage/viewListCategory.php?category=5">RAM</a>
                            <a class="dropdown-item" href="../listPage/viewListCategory.php?category=6">Portable Hard
                                Drive</a>
                        </div>
                    </li>

                    <li class="nav-item  m-3 dropdown">
                        <a class="nav-link dropdown-toggle fw-bold" id="brand" href="" id="navbarDropdownBrand"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            BRAND
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="../listPage/viewListBrand.php?brand=1">Samsung</a>
                            <a class="dropdown-item" href="../listPage/viewListBrand.php?brand=2">WD</a>
                            <a class="dropdown-item" href="../listPage/viewListBrand.php?brand=3">Seagate</a>
                            <a class="dropdown-item" href="../listPage/viewListBrand.php?brand=4">Sandisk</a>
                            <a class="dropdown-item" href="../listPage/viewListBrand.php?brand=5">Kingston</a>
                            <a class="dropdown-item" href="../listPage/viewListBrand.php?brand=6">Transcend</a>
                        </div>
                    </li>

                    <li class="nav-item  m-3">
                        <a class="nav-link fw-bold" id="privacy" href="../contactUs/privacy.php">PRIVACY</a>
                    </li>
                    <li class="nav-item  m-3">
                        <a class="nav-link fw-bold" id="shipping" href="../contactUs/shippingPayment.php">SHIPPING
                            PAYMENT</a>
                    </li>
                   
                    <li class="nav-item  m-3">
                        <a class="nav-link fw-bold" id="news" href="../news/news.php">NEWS</a>
                    </li>
                    <li class="nav-item  m-3">
                        <a class="nav-link fw-bold" id="contact" href="../contactUs/contact.php">CONTACT</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">

                        <!-- Search function -->

                        <form id="searchForm" onsubmit="redirectToSearch(); return false;" method="GET" class="d-flex">
                            <input class="form-control" type="text" id="searchInput" placeholder="Search for..."
                                oninput="searchProducts()">
                            <button type="submit" class="search-btn btn btn-outline-danger mx-1 my-0">
                                <i class="fa-solid fa-magnifying-glass" ></i>
                            </button>
                        </form>
                        <div id="searchResults"></div>
                        <!-- cart logo -->
                    </li>
                    <li class="nav-item">
                        <a href="../productDetail/viewCart.php" class="nav-link">
                            <span class="px-2 text-danger" id="logoCart">
                                <i class="fas fa-shopping-cart"></i>
                                <b class="text-center" id="numberCart">
                                    <?php echo $_SESSION['cartNumber']?>
                                </b>
                            </span>
                        </a>
                    </li>

                </ul>

                <!-- User logo-->
                <ul class="navbar-nav m-lg-3">
                    <li class="nav-item dropdown">
                        <?php if(isset($_SESSION['userName'])){
                            echo "<li class='nav-item  m-3 dropdown'>
                            <a class='nav-link dropdown-toggle text-dark fw-bold' href='#' id='navbarDropdownBrand' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>".
                            $_SESSION['userName'].
                            "</a>
                            <div class='dropdown-menu' style='left: -75px; width: 50px;' aria-labelledby='navbarDropdown'>
                                <a class='dropdown-item' href='../login/logout.php'>Log out</a>
                            </div>
                        </li>";
                        }else{
                            echo "<a class='nav-link text-dark' href='../login/login.php' role='button'>
                            <span class='px-3 py-2 rounded-pill'><i class='far fa-user'></i></span>
                        </a>";
                        }; ?>

                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <script>
          // Hàm để tìm kiếm sản phẩm
    function searchProducts() {
        // Lấy giá trị từ ô nhập liệu tìm kiếm
        var searchInput = document.getElementById("searchInput").value;

        // Tạo một đối tượng XMLHttpRequest mới
        var xhttp = new XMLHttpRequest();

        // Định nghĩa hàm xử lý phản hồi từ server
        xhttp.onreadystatechange = function () {
            // Kiểm tra nếu trạng thái của yêu cầu là hoàn thành (readyState == 4)
            // và mã trạng thái HTTP là OK (status == 200)
            if (this.readyState == 4 && this.status == 200) {
                // Đặt nội dung phản hồi vào phần tử HTML có id là "searchResults"
                document.getElementById("searchResults").innerHTML = this.responseText;
            }
        };

        // Mở một yêu cầu GET đến tệp search-process.php với tham số tìm kiếm
        xhttp.open("GET", "../search/search-process.php?search=" + searchInput, true);

        // Gửi yêu cầu
        xhttp.send();
    }

    // Hàm để chuyển hướng đến trang tìm kiếm sản phẩm
    function redirectToSearch() {
        // Lấy giá trị từ ô nhập liệu tìm kiếm
        var searchInput = document.getElementById("searchInput").value;
        
        // Chuyển hướng trình duyệt đến trang productSearch.php với tham số tìm kiếm
        window.location.href = "../search/productSearch.php?search=" + searchInput;
    }

        //Xử lý việc click vào content nào trong navbar thì sẽ highlight màu đỏ
        document.addEventListener("DOMContentLoaded", function () {
            // Lấy tất cả các thẻ a có class "nav-link"
            var navLinks = document.querySelectorAll('.nav-link');

            // Lặp qua từng thẻ a và thêm sự kiện click
            navLinks.forEach(function (link) {
                link.addEventListener('click', function (event) {
                    // Loại bỏ class 'text-danger' từ tất cả các thẻ a
                    navLinks.forEach(function (innerLink) {
                        innerLink.classList.remove('text-danger');
                    });

                    // Thêm class 'text-danger' vào thẻ a được click
                    this.classList.add('text-danger');

                    // Lưu trạng thái vào localStorage
                    localStorage.setItem('selectedNavLink', this.getAttribute('id'));
                });
            });

            // Kiểm tra xem có trạng thái đã lưu hay không
            var selectedNavLink = localStorage.getItem('selectedNavLink');
            if (selectedNavLink) {
                // Thêm class 'text-danger' vào thẻ a tương ứng với trạng thái đã lưu
                var selectedLink = document.querySelector('a[id="' + selectedNavLink + '"]');
                if (selectedLink) {
                    selectedLink.classList.add('text-danger');
                } else {
                    // Trường hợp đặc biệt: "Home"
                    if (selectedNavLink.includes('index.php')) {
                        document.querySelector('a[href*="index.php"]').classList.add('text-danger');
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta2/js/bootstrap.min.js"></script>

</body>

</html>