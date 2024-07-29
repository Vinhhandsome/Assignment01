<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderID = $_POST['orderID'];

    $sql = "DELETE FROM `order` WHERE orderID='$orderID'";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
