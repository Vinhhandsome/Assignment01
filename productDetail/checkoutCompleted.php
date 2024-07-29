<?php
session_start();
include("../db.php");

unset($_SESSION['cartNumber']);
unset($_SESSION['cartItem']);

$truncateTableCart = "TRUNCATE TABLE `eproject`.`carts`;";
$resultTruncateTableCart = $conn ->query($truncateTableCart);
if (!isset($_SESSION['checkoutItems'])) {
    $_SESSION['checkoutItems'] = [];
}
    $userName = $_SESSION["userName"];
    $sqlInforUser = "SELECT `userID`,`email`,`address`,`phone`,`dob` FROM `eproject`.`user` WHERE userName = '$userName'";
    $resultInforUser = $conn ->query($sqlInforUser);

    while ($row = $resultInforUser->fetch_assoc()) {
        $userID = $row['userID'];
        $orderEmail = $row['email'];
        $orderAddress = $row['address'];
        $orderPhone = $row['phone'];
    };
    $sqlInsertOrder = "INSERT INTO `eproject`.`order` (`orderID`, `userID`, `cartCode`, `orderEmail`, `orderAddress`, `orderPhone`, `orderDate`) VALUES (DEFAULT,'$userID', '1', '$orderEmail','$orderAddress','$orderPhone',DEFAULT)";
                $resultInsertOrder = $conn ->query($sqlInsertOrder);
        //INSERT INTO ORDER_DETAILS
        if (!empty($_SESSION['checkoutItems'])){
            foreach ($_SESSION['checkoutItems'] as $item){
                $productID = $item['productID'];
                $orderQuantity = $item['quantity'];
                $totalMoney = $item['quantity']*$item['unitPrice'];

                $sqlUserID = "SELECT `orderID` FROM `eproject`.`order` WHERE `userID` = '$userID'";
                $resultUserID = $conn ->query($sqlUserID);

                while ($row = $resultUserID->fetch_assoc()) {
                    $orderID = $row['orderID'];
                };

                $sqlInsertOrderDetails = "INSERT INTO `eproject`.`orderDetails` (`orderDetailsID`, `orderID`, `productID`, `discount`, `orderQuantity`, `totalMoney`) VALUES (DEFAULT,'$orderID', '$productID', '0','$orderQuantity','$totalMoney')";
                $resultInsertOrderDetail = $conn ->query($sqlInsertOrderDetails);
            }
        }

header ("Location: ../index/index.php");
?>