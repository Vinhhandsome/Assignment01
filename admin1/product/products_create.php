<?php
// Kết nối đến cơ sở dữ liệu bằng PDO
$conn = new PDO('mysql:host=localhost;dbname=eproject', 'root', 'Vinh2003');

// Fetch categories: Lấy tất cả danh mục sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM `category`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$listCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch brands: Lấy tất cả thương hiệu sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM `brand`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$listBrands = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Xử lý khi form được gửi đi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $productName = $_POST['productName'];
    $unitPrice = $_POST['unitPrice'];
    $quantity = $_POST['quantity'];
    $categoryID = $_POST['categoryID'];
    $brandID = $_POST['brandID'];
    $memory = $_POST['memory'];
    $speed = $_POST['speed'];
    $color = $_POST['color'];
    $warranty = $_POST['warranty'];
    $dimension = $_POST['dimension'];
    $description = $_POST['description'];
    $imageLink = $_FILES['imageLink']['name'];
    $imagePath = '../image/' . $imageLink;

    // Upload hình ảnh
    move_uploaded_file($_FILES['imageLink']['tmp_name'], $imagePath);

    // Thêm sản phẩm vào cơ sở dữ liệu
    $sql = "INSERT INTO products (`productName`, `unitPrice`, `quantity`, `categoryID`, `brandID`, `memory`, `speed`, `color`, `warranty`, `dimension`, `description`, `imageLink`)
            VALUES (:productName, :unitPrice, :quantity, :categoryID, :brandID, :memory, :speed, :color, :warranty, :dimension, :description, :imageLink)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':productName', $productName);
    $stmt->bindParam(':unitPrice', $unitPrice);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':categoryID', $categoryID);
    $stmt->bindParam(':brandID', $brandID);
    $stmt->bindParam(':memory', $memory);
    $stmt->bindParam(':speed', $speed);
    $stmt->bindParam(':color', $color);
    $stmt->bindParam(':warranty', $warranty);
    $stmt->bindParam(':dimension', $dimension);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':imageLink', $imageLink);

    $result = $stmt->execute();

    // Thông báo và điều hướng nếu việc thêm sản phẩm thành công hoặc thất bại
    if ($result) {
        echo "<script>alert('Thêm mới sản phẩm thành công')</script>";
        echo "<script>window.location.href='?url=product-list'</script>";
    } else {
        echo "<script>alert('Lỗi khi thêm sản phẩm')</script>";
    }
}
?>
