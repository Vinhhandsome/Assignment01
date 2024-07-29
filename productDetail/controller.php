<?php 
    // insert vào bảng cart khi click button check out
       // Xử lý khi check out được nhấn
       if(isset($_POST['checkOut'])){
        foreach ($_SESSION['cartItem'] as $item){
            $productID = $item['productID'];
            $quantity = $item['quantity'];
            $userID = $item['userID'];
            $unitPrice = $item['unitPrice'];
            $totalMoney = $quantity * $unitPrice;
    
            // Thêm thông tin sản phẩm vào bảng carts trong cơ sở dữ liệu
            $sqlInsertProduct = "INSERT INTO carts (cartID,productID, cartCode, userID, cartQuantity, totalMoney) 
                                 VALUES (DEFAULT,'$productID', '1', '$userID', '$quantity', '$totalMoney')";
            $resultInsertProduct = $conn->query($sqlInsertProduct);
        }
    
        // Xóa giỏ hàng sau khi đã thanh toán
        $_SESSION['cartItem'] = [];
        $_SESSION['cartNumber'] = 0;
        // unset($_SESSION['cartItem']);
        // unset($_SESSION['cartNumber']);
    
        // Chuyển hướng đến trang viewCheckout.php
        header("Location: viewCheckout.php");
        exit();
    }
?>