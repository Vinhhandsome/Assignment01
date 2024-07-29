<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carousel</title>
    <style>
        /* Định dạng cho container carousel */
        .carousel-container {
            width: 100%;
            margin: 0 auto;
            overflow: hidden;
            position: relative;
        }

        /* Định dạng cho các item trong carousel */
        .carouselThu {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        /* Định dạng cho từng item trong carousel */
        .carousel-itemThu {
            flex: 0 0 auto;
            width: 20%;
            /* Điều chỉnh width để hiển thị 5 items cùng lúc */
            box-sizing: border-box;
        }

        /* Định dạng cho các nút điều hướng */
        .prev,
        .next {
            position: absolute;
            top: 47%;
            width: 20px;
            padding: 5px;
            color: black;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            cursor: pointer;
        }

        .prev {
            left: 0%;
            border-radius: 3px 0 0 3px;
        }

        .next {
            right: 0%;
            border-radius: 3px 0 0 3px;
        }

        .prev:hover,
        .next:hover {
            background-color: rgba(227, 117, 117, 0.8);
        }
        .relPostition {
            position: relative;
        }
    </style>
</head>

<body>
    <!-- Container chính -->
    <div class="wrapper container-fluid">
        <br>
        <div class="container col-inner relPostition">
            <!-- Container của carousel -->
            <div class="carousel-container">
                <div class="carouselThu" id="categoryCarousel">
                    <!-- Category 1 -->
                    <div class="carousel-itemThu">
                        <a href="../listPage/viewListBrand.php?brand=1">
                            <img src="../Photos/category/LogoSamSung.png" class=" p-2 object-fit-contain" alt=""
                                width="100%" height="100%">
                        </a>
                    </div>

                    <!-- Category 2 -->
                    <div class="carousel-itemThu">
                        <a href="../listPage/viewListBrand.php?brand=2">
                            <img src="../Photos/category/LogoWesternDigital.jpg" class=" p-2 object-fit-contain" alt=""
                                width="100%" height="100%">
                        </a>
                    </div>

                    <!-- Category 3 -->
                    <div class="carousel-itemThu">
                        <a href="../listPage/viewListBrand.php?brand=3">
                            <img src="../Photos/category/LogoSeaGate.png" class=" p-2 object-fit-contain" alt=""
                                width="100%" height="100%">
                        </a>
                    </div>

                    <!-- Category 4 -->
                    <div class="carousel-itemThu">
                        <a href="../listPage/viewListBrand.php?brand=4">
                            <img src="../Photos/category/LogoSanDisk.png" class=" p-2 object-fit-contain" alt=""
                                width="100%" height="100%">
                        </a>
                    </div>

                    <!-- Category 5 -->
                    <div class="carousel-itemThu">
                        <a href="../listPage/viewListBrand.php?brand=5">
                            <img src="../Photos/category/LogoKingSton1.jpg" class=" p-2 object-fit-contain" alt=""
                                width="100%" height="100%">
                        </a>
                    </div>

                    <!-- Category 6 -->
                    <div class="carousel-itemThu">
                        <a href="../listPage/viewListBrand.php?brand=6">
                            <img src="../Photos/category/LogoTranscend.png" class=" p-2 object-fit-contain" alt=""
                                width="100%" height="100%">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Nút điều hướng -->
            <div class="prev" onclick="changeSlide(-1)">&#10094;</div>
            <div class="next" onclick="changeSlide(1)">&#10095;</div>

        </div>

    </div>

    <script>
        var currentIndex = 0; // Chỉ số hiện tại của slide
        var carousel = document.getElementById('categoryCarousel'); // Lấy element carousel
        var totalItems = document.querySelectorAll('.carousel-itemThu').length / 3; // Tổng số lượng item chia cho 3

        // Hàm thay đổi slide
        function changeSlide(n) {
            currentIndex = (currentIndex + n + totalItems) % totalItems; // Tính toán chỉ số slide mới
            updateCarousel(); // Cập nhật carousel
        }

        // Hàm cập nhật carousel
        function updateCarousel() {
            carousel.style.transform = 'translateX(' + (-currentIndex * 20) + '%)'; // Thay đổi vị trí của carousel
        }

        // Tự động chuyển slide sau mỗi 3 giây
        setInterval(function () {
            changeSlide(1);
        }, 3000);
    </script>

</body>

</html>
