<?php include "../home/navbar.php" ?> <!-- Bao gồm tệp navbar.php để hiển thị thanh điều hướng -->
<div class="wrapper container-fluid">
    <br>
    <?php 
        include "../db.php"; // Bao gồm tệp db.php để kết nối cơ sở dữ liệu
        // Lấy từ khóa tìm kiếm từ URL
        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
    ?>
    <div class="container col-inner">
        <h2 style="text-align: center" class="text-uppercase">
            <a href="" class="list-group-item">SEARCH FOR "<?php echo $searchKeyword ?>"
            </a>
        </h2>
        <div class="row">
            <?php
            // Định nghĩa các thông số
            $sql2 = "SELECT COUNT(*) as totalRecords FROM products WHERE productName LIKE '%$searchKeyword%'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $totalRecords = $row2["totalRecords"]; // Tổng số sản phẩm khớp với từ khóa tìm kiếm
            } else {
                $totalRecords = 0; // Nếu không có sản phẩm nào khớp
            }
            $recordsPerPage = 8; // Số sản phẩm hiển thị trên mỗi trang
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Trang hiện tại

            // Tính toán số trang và vị trí bắt đầu
            $totalPages = ceil($totalRecords / $recordsPerPage);
            $startPosition = ($currentPage - 1) * $recordsPerPage;
            
            // Sử dụng từ khóa tìm kiếm trong truy vấn SQL
            $sqlSearch = "SELECT * FROM products WHERE productName LIKE '%$searchKeyword%' LIMIT $recordsPerPage OFFSET $startPosition";
            $resultSearch = $conn->query($sqlSearch);

            // Hiển thị sản phẩm tìm kiếm được
            while ($row = $resultSearch->fetch_assoc()) {
        ?>
            <form action="" method="POST" class="col-md-3 mt-2">
                <div class="card custom-col">
                    <a href="../productDetail/viewProduct.php?productID=<?php echo $row['productID'];?>"
                        class="list-group-item align-items-center">
                        <img src="../<?php echo $row["imageLink"]?>" class="p-5 object-fit-contain home-custom-image"
                        alt="Product 3">
                    </a>

                    <div class="card-body text-center">
                        <h5 class="card-title text-center mt-2 home-custom-card-title fw-bold text-uppercase">
                            <a href="../productDetail/viewProduct.php?productID=<?php echo $row['productID'];?>"
                                class="list-group-item">
                                <?php echo $row["productName"] ?>
                            </a>
                        </h5>
                        <p class="card-text text-danger fw-bold">
                            <?php echo $row["unitPrice"] . "$" ?>
                        </p>

                        <!-- input hidden để lấy thông tin -->
                        <?php
                            // Chuyển đổi brandID sang tên thương hiệu
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
                                    $brand = "unknown brand";
                                    break;
                            }

                            // Chuyển đổi categoryID sang tên danh mục
                            switch ($row['categoryID']){
                                case 1:
                                    $category = "Hard Disk Drive - HDD";
                                    break;
                                case 2:
                                    $category = "Solid State Drive - SSD";
                                    break;
                                case 3:
                                    $category = "USB Flash Drive";
                                    break;
                                case 4:
                                    $category = "Memory Card";
                                    break;
                                case 5:
                                    $category = "Random Access Memory - RAM";
                                    break;
                                case 6:
                                    $category = "Portable Hard Drive";
                                    break;
                                default:
                                    $category = "unknown category";
                                    break;
                            }
                        ?>

                        <!-- Các input ẩn để lưu trữ thông tin sản phẩm -->
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

                        <!-- nút ADD TO CART -->
                        <div class="d-flex justify-content-center">
                            <a href="../productDetail/viewProduct.php?productID=<?php echo $row['productID'];?>"
                                class="btn btn-outline-danger fw-bold">ADD TO CART</a>
                        </div>
                    </div>
                </div>
            </form>
            <?php
            }
            ?>

            <!-- Phân trang -->
            <div class="justify-content-center d-flex">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = ($i == $currentPage) ? 'active-page' : '';
                    echo '<a href="?search=' . $_GET['search'] . '&page=' . $i . '" class="btn btn-danger list-btn-pagination ' . $activeClass . '">' . $i . '</a>';
                }
                ?>
            </div>

        </div>
    </div>
    <br>
</div>
<?php include "../home/footer.html" ?> <!-- Bao gồm tệp footer.html để hiển thị phần chân trang -->
