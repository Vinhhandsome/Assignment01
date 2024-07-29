<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<?php
include ('../db.php'); // Bao gồm tệp db.php để kết nối cơ sở dữ liệu

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Kiểm tra kết nối cơ sở dữ liệu
}

$searchQuery = $_GET['search']; // Lấy từ khóa tìm kiếm từ URL

if (!empty($searchQuery)) { // Kiểm tra nếu từ khóa tìm kiếm không rỗng

    $sql = "SELECT productID, productName, imageLink FROM products WHERE productName LIKE '%$searchQuery%' LIMIT 4"; // Truy vấn cơ sở dữ liệu để lấy các sản phẩm khớp với từ khóa tìm kiếm, giới hạn kết quả là 4
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { // Kiểm tra nếu có kết quả trả về
        // Xuất kết quả dưới dạng danh sách HTML
        while ($row = $result->fetch_assoc()) { // Duyệt qua các kết quả truy vấn
            echo "<table>"; // Bắt đầu bảng
            echo "<tr>"; // Bắt đầu hàng trong bảng
            echo "<td>"; // Bắt đầu ô trong bảng
            echo "<a class='nav-link' href='../productDetail/viewproduct.php?productID=".$row['productID']."'>"; // Tạo liên kết đến trang chi tiết sản phẩm
            echo "<img src='../" . $row['imageLink'] . "' alt='' style='width: 30px; height: 30px;'>"; // Hiển thị hình ảnh sản phẩm
            echo "<h8 class='card-title fw-bold text-uppercase'>" . $row['productName'] . "</h8>"; // Hiển thị tên sản phẩm
            echo "</a>";
            echo "</td>"."</br>";
            echo "</tr>"; // Kết thúc hàng trong bảng
            echo "</table>"; // Kết thúc bảng
        }
    } else {
        // Không có kết quả tìm kiếm
        echo "<li>No products found.</li>";
    }
}
?>

</body>
</html>
