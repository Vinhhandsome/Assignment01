<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
</head>
<body>
<div class="wrapper container-fluid">

<?php  
    // Kết nối tới cơ sở dữ liệu
    include "../db.php";
    
    // Truy vấn tất cả các danh mục từ cơ sở dữ liệu
    $sql1 = "SELECT * FROM category";
    $result1 = $conn->query($sql1);  
    
    // Vòng lặp qua từng danh mục
    while ($row1 = $result1->fetch_assoc()) {
    ?>
    
    <!-- Hiển thị từng danh mục -->
    <div class="container col-inner">
        <h2 class="text-uppercase text-center">
            <!-- Liên kết để xem các sản phẩm của danh mục -->
            <a href="../listPage/viewListCategory.php?category=<?php echo (int)$row1["categoryID"] ?>" class="list-group-item">
                <?php echo $row1["categoryName"]?>
            </a>
        </h2>
        <div class="row">
    
    <?php
        // Truy vấn tối đa 8 sản phẩm của danh mục hiện tại
        $sql = "SELECT * FROM products where categoryID =". $row1["categoryID"] ." limit 8";
        $result = $conn->query($sql);
        $compareProduct =[];
        
        // Vòng lặp qua từng sản phẩm
        while ($row = $result->fetch_assoc()) {
    ?>
                <!-- Hiển thị từng sản phẩm -->
                <form action="" method="POST" class="col-md-3 mt-2">
                    <div class="card custom-col">
                        <!-- Liên kết đến trang chi tiết sản phẩm với hình ảnh -->
                        <a href="../productDetail/viewProduct.php?productID=<?php echo $row['productID'];?>" class="list-group-item align-items-center">
                            <img src="<?php echo "../".$row["imageLink"]?>" class="p-5 object-fit-contain home-custom-image" alt="Product 3">
                        </a>
                        
                        <div class="card-body text-center">
                            <!-- Hiển thị tên sản phẩm -->
                            <h5 class="card-title text-center mt-2 home-custom-card-title fw-bold text-uppercase">
                                <a href="../productDetail/viewProduct.php?productID=<?php echo $row['productID'];?>" class="list-group-item">
                                    <?php echo $row["productName"]?>
                                </a>
                            </h5>
                            <!-- Hiển thị giá sản phẩm -->
                            <p class="card-text text-danger fw-bold"><?php echo $row["unitPrice"]."$"?></p>

                            <!-- Các input ẩn để truyền thông tin sản phẩm -->
                            <?php
                                // Xác định tên thương hiệu dựa trên brandID
                                switch ($row['brandID']){
                                case 1:
                                    $brand = "Samsung";
                                    break;
                                case 2:
                                    $brand = "Western Digital (WD)";
                                    break;
                                case 3:
                                    $brand = "Seagate";
                                    break;
                                case 4:
                                    $brand = "SanDisk";
                                    break;
                                case 5:
                                    $brand = "Kingston";
                                    break;
                                case 6:
                                    $brand = "Transcend";
                                    break;
                                default:
                                    $brand ="unknown brand";
                                    break;
                                }

                                // Xác định tên danh mục dựa trên categoryID
                                switch ($row['categoryID']){
                                    case 1:
                                        $category = "Ổ cứng HDD";
                                        break;
                                    case 2:
                                        $category = "Ổ cứng SSD";
                                        break;
                                    case 3:
                                        $category = "USB";
                                        break;
                                    case 4:
                                        $category = "Thẻ nhớ";
                                        break;
                                    case 5:
                                        $category = "RAM";
                                        break;
                                    case 6:
                                        $category = "Ổ cứng di động";
                                        break;
                                    default:
                                        $category ="Danh mục không xác định";
                                        break;
                                    }
                            ?>
                            <!-- Các input ẩn để chứa thông tin chi tiết sản phẩm -->
                            <input type="hidden" name="productID" value="<?php echo $row['productID'];?>">
                            <input type="hidden" name="imageLink" value="<?php echo $row['imageLink'];?>">
                            <input type="hidden" name="productName" value="<?php echo $row['productName'];?>">
                            <input type="hidden" name="unitPrice" value="<?php echo $row['unitPrice'];?>">
                            <input type="hidden" name="categoryID" value="<?php echo $category ?>">
                            <input type="hidden" name="brandID" value="<?php echo $brand ?>">
                            <input type="hidden" name="memory" value="<?php echo $row['memory']; ?>">
                            <input type="hidden" name="speed" value="<?php echo $row['speed'];?>">
                            <input type="hidden" name="color" value="<?php echo $row['color'];?>">
                            <input type="hidden" name="warranty" value="<?php echo $row['warranty'];?>">
                            <input type="hidden" name="dimension" value="<?php echo $row['dimension'];?>">

                            <!-- Nút thêm sản phẩm vào giỏ hàng -->
                            <div class="d-flex justify-content-center">
                                <button type="submit" name="addToCartButton" class="btn btn-outline-danger fw-bold">THÊM VÀO GIỎ</button>
                            </div>
                        </div>
                    </div>
                </form>
        <?php
        }
        ?>
        <!-- Liên kết để hiển thị thêm sản phẩm của danh mục -->
        <div class="justify-content-center d-flex">
            <a href="../listPage/viewListCategory.php?category=<?php echo (int)$row1["categoryID"] ?>" class="btn btn-danger home-btn-showmore ">XEM THÊM</a>
        </div>
        </div>
        </div>
        <br>
    <?php
    }
    ?>
</div>

</body>
</html>
