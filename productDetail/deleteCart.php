<?php
session_start();
include("../db.php");
if (isset($_GET["productID"])) {
    $productID = $_GET["productID"];
    $sqlDelete = "DELETE FROM carts WHERE productID = '$productID'";
    $result = $conn->query($sqlDelete);

    foreach ($_SESSION['cartItem'] as $key => &$item) {
    if ($item['productID'] === $_GET["productID"]) {
        array_splice($_SESSION['cartItem'], $key, 1);
        $_SESSION['cartNumber']--; //giảm số lượng hiển thị
    }
}
header ("Location: viewCart.php");
}
?>