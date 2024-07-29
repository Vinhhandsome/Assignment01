<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Trang Tin Tức</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
            /* Bootstrap light background color */
        }

        h1 {
            text-align: center;
            color: #dc3545;
            /* Bootstrap danger color */
        }

        .article {
            width: 100%;
            margin-bottom: 20px;
            background-color: #fff;
            /* Bootstrap white background color */
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .article:hover {
            transform: translateY(-5px);
        }

        .imgNews {
            width: 100%;
            height: auto;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .article-content {
            padding: 20px;
        }

        .textDecreption {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <?php include '../home/navbar.php'; ?>
    <div class="wrapper container-fluid">
        <div class="container col-inner">
            <h1 class="my-3">TIN TỨC</h1>
            <div class="row m-4 g-4 textDecreption">
                <?php
                // Array containing news information
                $news = [
                    [
                        'title' => 'Tìm hiểu về USB-C',
                        'content' => 'USB-C là gì? Để giải quyết vấn đề về các cáp không còn tương thích...',
                        'image' => 'https://media.kingston.com/kingston/articles/ktc-articles-blog-personal-storage-understanding-file-systems-md.jpg',
                        'link' => 'news1.php'
                    ],
                    [
                        'title' => 'Thiết lập ổ SSD di động',
                        'content' => 'Cần thiết lập một ổ SSD di động IronKey Vault Privacy 80? Hướng dẫn này của Kingston..',
                        'image' => 'https://media.kingston.com/kingston/articles/ktc-blog-pc-performance-upgrade-dell-thumbnail-md.jpg',
                        'link' => 'news4.php'
                    ],
                    [
                        'title' => 'Cách định dạng SSD?',
                        'content' => 'Bạn mới nâng cấp lên SSD mới? Hoặc bạn đang có kế hoạch bán hoặc chuyển nhượng...',
                        'image' => 'https://media.kingston.com/kingston/articles/ktc-hero-blog-pc-performance-revive-old-computer-thumbnail-md.jpg',
                        'link' => 'news3.php'
                    ],
                    [
                        'title' => 'Có nên mua USB Kingston?',
                        'content' => 'USB Kingston có tốt không là vấn đề nhiều người quan tâm...',
                        'image' => 'https://media.kingston.com/kingston/articles/ktc-articles-solutions-pc-performance-memory-vs-storage-md.jpg',
                        'link' => 'news2.php'
                    ],
                    [
                        'title' => 'Cách định dạng ổ USB?',
                        'content' => 'Oceangate giới thiệu cách định dạng ổ USB. Định dạng...',
                        'image' => 'https://media.kingston.com/kingston/articles/ktc-blog-pc-performance-hdd-vs-external-ssd-thumbnail-md.jpg',
                        'link' => 'news5.php'
                    ],
                ];

                // Display news articles
                foreach ($news as $article) {
                    echo '<div class="col-md-6 col-lg-4">';
                    echo '<div class="card article">';
                    echo '<img class="card-img-top imgNews" src="' . $article['image'] . '" alt="' . $article['title'] . '">';
                    echo '<div class="article-content">';
                    echo '<h3 class="card-title">' . $article['title'] . '</h3>';
                    echo '<p class="card-text">' . $article['content'] . '</p>';
                    echo '<a href="' . $article['link'] . '" class="btn btn-danger">Đọc thêm</a>';
                    echo '</div></div></div>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php include '../home/footer.html'; ?>
</body>

</html>
