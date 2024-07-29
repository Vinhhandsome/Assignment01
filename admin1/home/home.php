<?php
include('../db.php'); // Kết nối với cơ sở dữ liệu
include('../index/index.php'); // Nhúng file index.php nếu cần

// Lấy số liệu tổng số người dùng từ cơ sở dữ liệu
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM user";
$totalProductsQuery = "SELECT COUNT(*) AS total_products FROM products";
$totalOrdersQuery = "SELECT COUNT(*) AS total_orders FROM `order`";

// Thực thi truy vấn và lấy kết quả
$totalUsersResult = $conn->query($totalUsersQuery);
if ($totalUsersResult) {
    $totalUsers = $totalUsersResult->fetch_assoc()['total_users'];
} else {
    $totalUsers = "Lỗi"; // Nếu có lỗi khi truy vấn
}

$totalProductsResult = $conn->query($totalProductsQuery);
if ($totalProductsResult) {
    $totalProducts = $totalProductsResult->fetch_assoc()['total_products'];
} else {
    $totalProducts = "Lỗi"; // Nếu có lỗi khi truy vấn
}

$totalOrdersResult = $conn->query($totalOrdersQuery);
if ($totalOrdersResult) {
    $totalOrders = $totalOrdersResult->fetch_assoc()['total_orders'];
} else {
    $totalOrders = "Lỗi"; // Nếu có lỗi khi truy vấn
}

$conn->close(); // Đóng kết nối với cơ sở dữ liệu
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ Admin</title>
    <link rel="stylesheet" href="../style.css"> <!-- Nhúng file CSS để định dạng giao diện -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }

        .dashboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        .stats-card,
        .chart-container,
        .info-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 30%;
            text-align: center;
        }

        .info-card {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .info-card div {
            width: 48%;
        }

        .stats-card h2,
        .info-card h2 {
            font-size: 2em;
            margin: 0;
        }

        .stats-card p,
        .info-card p {
            margin: 5px 0 0;
        }

        .chart-container {
            width: 100%;
        }

        .chart-container canvas {
            width: 100%;
            height: 200px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Nhúng thư viện Chart.js để vẽ biểu đồ -->
</head>
<body>
    <div class="container">
        <h1 class="text-center">Admin Dashboard</h1> <!-- Tiêu đề trang -->
        <div class="dashboard">
            <div class="stats-card">
                <h2><?php echo $totalUsers; ?></h2> <!-- Hiển thị tổng số người dùng -->
                <p>Tổng Số Người Dùng</p>
            </div>
            <div class="stats-card">
                <h2><?php echo $totalProducts; ?></h2> <!-- Hiển thị tổng số sản phẩm -->
                <p>Tổng Số Sản Phẩm</p>
            </div>
            <div class="stats-card">
                <h2><?php echo $totalOrders; ?></h2> <!-- Hiển thị tổng số đơn hàng -->
                <p>Tổng Số Đơn Hàng</p>
            </div>
        </div>
        <div class="info-card">
            <div>
                <h2>Thống Kê Thiết Bị</h2>
                <p>Thời Gian Hoạt Động: 195 ngày, 8 giờ</p>
                <p>Lần Đầu Tiên Thấy: 23 tháng 9 năm 2019</p>
                <p>Thời Gian Thu Thập: 23 tháng 9 năm 2019</p>
                <p>Bộ Nhớ: 168.3 GB</p>
            </div>
            <div>
                <h2>Thu Nhập</h2>
                <p>Tổng Thu Nhập: $287,493</p>
                <p>Tăng Trưởng: 1.4% so với tháng trước</p>
                <p>Tổng Doanh Số: $87,493</p>
                <p>Tăng Trưởng: 5.43% so với tháng trước</p>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="salesChart"></canvas> <!-- Biểu đồ phân tích bán hàng -->
        </div>
        <div class="chart-container">
            <canvas id="eventChart"></canvas> <!-- Biểu đồ sự kiện -->
        </div>
    </div>

    <script>
        // Dữ liệu cho biểu đồ phân tích bán hàng
        const salesData = {
            labels: ['Trực tuyến', 'Ngoại tuyến', 'Tiếp thị'],
            datasets: [{
                label: 'Phân Tích Bán Hàng',
                data: [23342, 13221, 1542],
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56'],
                hoverBackgroundColor: ['#ff6384', '#36a2eb', '#ffce56']
            }]
        };

        // Dữ liệu cho biểu đồ sự kiện
        const eventChartData = {
            labels: ['Phê bình', 'Lỗi', 'Cảnh báo'],
            datasets: [{
                label: 'Sự Kiện',
                data: [20, 30, 50],
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56'],
                hoverBackgroundColor: ['#ff6384', '#36a2eb', '#ffce56']
            }]
        };

        // Cấu hình chung cho biểu đồ
        const config = {
            type: 'doughnut',
            data: {},
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        };

        // Khởi tạo biểu đồ phân tích bán hàng
        const salesChart = new Chart(
            document.getElementById('salesChart'),
            { ...config, data: salesData }
        );

        // Khởi tạo biểu đồ sự kiện
        const eventChart = new Chart(
            document.getElementById('eventChart'),
            { ...config, data: eventChartData }
        );
    </script>
</body>
</html>
