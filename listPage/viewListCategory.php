<?php include "../home/navbar.php" ?>
<div class="wrapper container-fluid">
    <br>
    <?php 
        include "../db.php";
        $sql1 = "SELECT * FROM category WHERE categoryID = ".$_GET['category'];
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
    ?>
    <div class="container col-inner">
        <h2 style="text-align: center" class="text-uppercase">
            <a href="" class="list-group-item">
                <?php echo $row1["categoryName"]?>
            </a>
        </h2>
        <div class="row">
            <?php

            // Định nghĩa các thông số
            $sql2 = "SELECT COUNT(*) as totalRecords FROM products WHERE categoryID =". $_GET['category'];
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $totalRecords = $row2["totalRecords"];
            } else {
                $totalRecords = 0;
            }
            $recordsPerPage = 8;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

            // Tính toán số trang và vị trí bắt đầu
            $totalPages = ceil($totalRecords / $recordsPerPage);
            $startPosition = ($currentPage - 1) * $recordsPerPage;

            // Truy vấn cơ sở dữ liệu
            $sql = "SELECT * FROM products WHERE categoryID =". $_GET['category'] ." LIMIT $recordsPerPage OFFSET $startPosition";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
        ?>
            <form action="" method="POST" class="col-md-3 mt-2">
                <div class="card custom-col">
                    
                    <a href="../productDetail/viewProduct.php?productID=<?php echo $row['productID'];?>"
                        class="list-group-item align-items-center">
                        <img src="../<?php echo $row["imageLink"]?>" class="p-5 object-fit-contain home-custom-image"
                        alt="Product 3">
                    </a>

                    <div class="card-body text-center">
                        <h5 class="card-title text-center mt-2 home-custom-card-title fw-bold text-uppercase"><a
                                href="../productDetail/viewProduct.php?productID=<?php echo $row['productID'];?>"
                                class="list-group-item">
                                <?php echo $row["productName"]?>
                            </a></h5>
                        <p class="card-text text-danger fw-bold">
                            <?php echo $row["unitPrice"]."$"?>
                        </p>


                        <!-- input hidden for get infomation -->
                        <?php
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
                                    $category ="unknown category";
                                    break;
                                }


                        ?>
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

                        <!-- button ADD TO CART -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" name="addToCartButton" class="btn btn-outline-danger fw-bold ">THÊM VÀO GIỎ</button>
                            
                        </div>
                    </div>
                </div>
            </form>
            <?php
        }
        ?>

            <div class="justify-content-center d-flex">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = ($i == $currentPage) ? 'active-page' : '';
                    echo '<a href="?category='.$_GET['category'].'&page=' . $i . '" class="btn btn-danger list-btn-pagination ' . $activeClass . '">' . $i . '</a>';
                }
            ?>
            </div>

        </div>
    </div>
    <br>

</div>
<?php include "../home/footer.html" ?>