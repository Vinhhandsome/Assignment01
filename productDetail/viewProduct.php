<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">   <!-- Liên kết đến tập tin CSS tùy chỉnh -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Liên kết đến CSS của Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Liên kết đến các biểu tượng Font Awesome -->

    <title>Chi tiết sản phẩm</title> 
</head>
<body>
    <?php
    include('../home/navbar.php'); // Bao gồm thanh điều hướng từ tệp bên ngoài

    if (isset($_GET['productID'])) { // Kiểm tra xem tham số 'productID' có tồn tại trong URL không
        $productID = $_GET['productID']; // Lấy productID từ URL

        // Câu truy vấn SQL để lấy thông tin sản phẩm, tên danh mục và tên thương hiệu
        $sqlDetailPro = "SELECT p.*, c.categoryName, b.brandName
                         FROM products p
                         LEFT JOIN category c ON p.categoryID = c.categoryID
                         LEFT JOIN brand b ON p.brandID = b.brandID
                         WHERE p.productID = '$productID'";

        $resultDetailPro = mysqli_query($conn, $sqlDetailPro); // Thực thi câu truy vấn

        if ($resultDetailPro) {
            if (mysqli_num_rows($resultDetailPro) > 0) { // Kiểm tra nếu có kết quả trả về
                $rowProDetail = mysqli_fetch_assoc($resultDetailPro); // Lấy thông tin sản phẩm dưới dạng mảng kết hợp
                $productImg = $rowProDetail['imageLink']; // Lưu liên kết hình ảnh sản phẩm
                $categoryName = $rowProDetail['categoryName']; // Lưu tên danh mục
                $brandName = $rowProDetail['brandName']; // Lưu tên thương hiệu
            } else {
                echo "Không tìm thấy kết quả cho ID sản phẩm này."; // Thông báo nếu không tìm thấy sản phẩm
            }
        } else {
            echo "Lỗi: " . mysqli_error($conn); // Hiển thị lỗi SQL nếu truy vấn thất bại
        }
    ?>

    <!-- Phần chi tiết sản phẩm -->
    <div class="product-detail-container d-flex flex-wrap justify-content-center">

        <div class="product-details p-5">
            <form action="" method="POST" class="d-flex flex-wrap justify-content-around">
                <!-- Các trường ẩn để truyền thông tin sản phẩm -->
                <input type="hidden" name="productID" value="<?php echo $rowProDetail['productID']; ?>">
                <input type="hidden" name="productName" value="<?php echo $rowProDetail['productName']; ?>">
                <input type="hidden" name="imageLink" value="<?php echo "../" . $productImg; ?>">
                <input type="hidden" name="unitPrice" value="<?php echo $rowProDetail['unitPrice']; ?>">

                <!-- Hình ảnh và thông tin sản phẩm -->
                <img src="../<?php echo $productImg; ?>" alt="" class="product-detail-img col-lg-5 col-md-5 col-sm-12 col-12">
                <div class="product-info col-lg-5 col-md-5 col-sm-12 col-12">
                    <h3 class="product-detail-name fw-bold text-start"><?php echo $rowProDetail['productName']; ?></h3>
                    <h3 class="product-detail-price p-2 text-red"><?php echo $rowProDetail['unitPrice'] . "$"; ?></h3>
                    <div class="product-detail-color d-flex my-1">
                        <label for="" class="fw-bold p-2 font-size-sm mt-1">Màu sắc</label>
                        <p class="product-color mx-2 my-0 p-2"><?php echo $rowProDetail['color']; ?></p>
                    </div>

                    <!-- Chọn số lượng -->
                    <div class="product-details-quantity my-1">
                        <label for="" class="fw-bold p-2 font-size-sm mt-1">Số lượng</label>
                        <button type="button" class="decrementBtn btn btn-danger align-middle">-</button>
                        <input type="number" class="quantityInput align-middle text-center" name="quantity" value="1" min="1">
                        <button type="button" class="incrementBtn btn btn-danger align-middle">+</button>
                    </div>

                    <!-- Các nút hành động -->
                    <div class="product-detail-action">
                        <div class="justify-content-center">
                            <div class="d-flex flex-wrap justify-content-between">
                                <button type="submit" name="addToCart" class="btn btn-add col-lg-5 col-md-12 col-sm-12 col-12 text-dark fw-bold my-1">
                                    Thêm vào giỏ hàng
                                </button>
                                <button type="submit" name="buyNow" class="btn btn-buy bg-red col-lg-5 col-md-12 col-sm-12 col-12 text-white fw-bold my-1">Mua ngay</button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-contact text-white fw-bold col-lg-12 col-md-12 col-12 col-sm-12 col-12 my-1">
                                    <a href="../contactUs/contact.php" class="list-group-item font-size-sm">Liên hệ để có giá tốt hơn</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Phần lợi ích sản phẩm -->
                <div class="product-details-benefit d-flex justify-content-center flex-wrap">
                    <div class="col-12 col-lg-6 d-flex p-1 justify-content-between">
                        <img class="col-12 col-lg-4" src="../Photos/IconProductDetails/atm-card.svg" alt="atm-card">
                        <div class="col-12 col-lg-8 d-flex flex-wrap align-items-center mx-1">
                            <p class="my-0 p-0 col-lg-12 text-uppercase font-size-smsm">Thanh toán</p>
                            <p class="my-0 p-0 text-uppercase font-size-smsm fw-bold">TIỆN LỢI</p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 d-flex p-1 justify-content-between">
                        <img class="col-12 col-lg-4" src="../Photos/IconProductDetails/check.svg" alt="check">
                        <div class="col-12 col-lg-8 d-flex flex-wrap align-items-center mx-1">
                            <p class="my-0 p-0 col-lg-12 text-uppercase font-size-smsm">SẢN PHẨM</p>
                            <p class="my-0 p-0 text-uppercase font-size-smsm fw-bold">CHÍNH HÃNG</p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 d-flex p-1 justify-content-between">
                        <img class="col-12 col-lg-4" src="../Photos/IconProductDetails/comments.svg" alt="comment">
                        <div class="col-12 col-lg-8 d-flex flex-wrap align-items-center mx-1">
                            <p class="my-0 p-0 col-lg-12 text-uppercase font-size-smsm">GIAO HÀNG TOÀN QUỐC</p>
                            <p class="my-0 p-0 text-uppercase font-size-smsm fw-bold">Giao COD</p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 d-flex p-1 justify-content-between">
                        <img class="col-12 col-lg-4" src="../Photos/IconProductDetails/delivery-truck.svg" alt="delivery-truck">
                        <div class="col-12 col-lg-8 d-flex flex-wrap align-items-center mx-1">
                            <p class="my-0 p-0 col-lg-12 text-uppercase font-size-smsm">HỖ TRỢ 24/7</p>
                            <p class="my-0 p-0 text-uppercase font-size-smsm fw-bold">CHUYÊN NGHIỆP</p>
                        </div>
                    </div>
                </div>

                <!-- Bảng thông tin sản phẩm -->
                <div class="product-decription d-flex flex-wrap col-md-12 justify-content-around m-2">
                    <p class="border-bot-red fw-bold col-12 col-lg-12 text-center p-2">Thông tin sản phẩm</p>
                    
                    <table class="table text-center">
                        <tbody>
                            <tr>
                                <td class="fw-bold font-size-sm p-2">Thương hiệu</td>
                                <td class="font-size-sm p-2"><?php echo $brandName; ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold font-size-sm p-2">Danh mục</td>
                                <td class="font-size-sm p-2"><?php echo $categoryName; ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold font-size-sm p-2">Bộ nhớ</td>
                                <td class="font-size-sm p-2"><?php echo $rowProDetail['memory']; ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold font-size-sm p-2">Tốc độ</td>
                                <td class="font-size-sm p-2"><?php echo $rowProDetail['speed']; ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold font-size-sm p-2">Màu sắc</td>
                                <td class="font-size-sm p-2"><?php echo $rowProDetail['color']; ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold font-size-sm p-2">Bảo hành</td>
                                <td class="font-size-sm p-2"><?php echo $rowProDetail['warranty']; ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold font-size-sm p-2">Kích thước</td>
                                <td class="font-size-sm p-2"><?php echo $rowProDetail['dimension']; ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold font-size-sm p-2 align-middle">Mô tả</td>
                                <td class="font-size-sm text-justify"><?php echo $rowProDetail['description']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Phần phản hồi của khách hàng -->
                <div class="product-feeback col-lg-12">
                    <form action="" method="POST" class="d-flex flex-wrap">
                        <label for="" class="fw-bold col-lg-12 p-1 my-2">Phản hồi của khách hàng</label>
                        <textarea placeholder="Nhập phản hồi của bạn..." name="message" class="product-text-feedback col-lg-12 p-4 my-2" id="myTextArea"></textarea>
                        <button type="submit" name="sendFeedback" class="btn btn-danger"><a href="#" class="list-group-item">Gửi</a></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php } ?> <!-- Kết thúc khối PHP -->

    <!-- Xử lý gửi phản hồi -->
    <?php if (isset($_POST['sendFeedback'])) {
        if (isset($_SESSION['userName'])) { // Kiểm tra xem người dùng có đăng nhập không
            if (!empty($_POST['message'])) { // Kiểm tra xem phản hồi có rỗng không
                $productID = $_GET['productID'];
                // Thêm mã để lưu phản hồi vào cơ sở dữ liệu ở đây
            } else {
                echo "<p class='text-danger'>Phản hồi không được để trống</p>"; // Thông báo nếu phản hồi rỗng
            }
        } else {
            echo "<p class='text-danger'>Bạn cần đăng nhập!</p>"; // Thông báo nếu người dùng chưa đăng nhập
        }
    } ?>

    <!-- Bao gồm phần chân trang -->
    <?php include('../home/footer.html'); ?> <!-- Bao gồm chân trang từ tệp bên ngoài -->

    <!-- Liên kết các tệp JavaScript -->
    <!-- Bỏ chọn nếu cần -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
    
    <script src="controller.js"></script> <!-- Liên kết đến tệp JavaScript tùy chỉnh -->

</body>
</html>
