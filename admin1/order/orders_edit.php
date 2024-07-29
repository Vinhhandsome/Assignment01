<?php
include('../index/index.php');
include('../db.php');

$orderID = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['userID'];
    $cartCode = $_POST['cartCode'];
    $orderEmail = $_POST['orderEmail'];
    $orderAddress = $_POST['orderAddress'];
    $orderPhone = $_POST['orderPhone'];

    $sql = "UPDATE `order` SET userID='$userID', cartCode='$cartCode', orderEmail='$orderEmail', orderAddress='$orderAddress', orderPhone='$orderPhone' WHERE orderID='$orderID'";

    if ($conn->query($sql) === TRUE) {
        echo "Cập nhật đơn hàng thành công";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
} else {
    $sql = "SELECT * FROM `order` WHERE orderID='$orderID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy đơn hàng";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Chỉnh sửa đơn hàng</title>
</head>
<body>
    <div class="container">
        <div class="side-body">
        <h1>Chỉnh sửa đơn hàng</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="userID">ID Người dùng:</label>
                <input type="text" class="form-control" id="userID" name="userID" value="<?php echo $row['userID']; ?>" required>
            </div>
            <div class="form-group">
                <label for="cartCode">Mã giỏ hàng:</label>
                <input type="text" class="form-control" id="cartCode" name="cartCode" value="<?php echo $row['cartCode']; ?>" required>
            </div>
            <div class="form-group">
                <label for="orderEmail">Email đơn hàng:</label>
                <input type="email" class="form-control" id="orderEmail" name="orderEmail" value="<?php echo $row['orderEmail']; ?>" required>
            </div>
            <div class="form-group">
                <label for="orderAddress">Địa chỉ đơn hàng:</label>
                <input type="text" class="form-control" id="orderAddress" name="orderAddress" value="<?php echo $row['orderAddress']; ?>" required>
            </div>
            <div class="form-group">
                <label for="orderPhone">Điện thoại đơn hàng:</label>
                <input type="text" class="form-control" id="orderPhone" name="orderPhone" value="<?php echo $row['orderPhone']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật đơn hàng</button>
        </form>
    </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
