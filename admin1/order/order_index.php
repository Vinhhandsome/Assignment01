<?php
include('../index/index.php');
include('../db.php');

// Số bản ghi hiển thị trên mỗi trang
$records_per_page = 10;

// Lấy số trang hiện tại từ chuỗi truy vấn, mặc định là 1 nếu không có
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start_from = ($page - 1) * $records_per_page;

// Truy xuất tổng số bản ghi
$total_sql = "SELECT COUNT(*) FROM `order`";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_row();
$total_records = $total_row[0];

// Tính tổng số trang
$total_pages = ceil($total_records / $records_per_page);

// Truy xuất bản ghi cho trang hiện tại
$sql = "SELECT * FROM `order` LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Quản lý đơn hàng</title>
    <style>
        body {
            font-family: Courier, sans-serif;
        }

        h1 {
            color: #333;
            margin-top: 20px;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-bottom: 15px;
            color: #fff;
            text-decoration: none;
            background-color: #000;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #fff;
            color: #000;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            margin: 4px;
            text-decoration: none;
            color: #fff;
            background-color: #000;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #f1f1f1;
            color: #000;
        }

        .pagination a.active {
            background-color: #dc3545;
            color: #fff;
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="side-body">
            <h1 class="mt-4">Quản lý đơn hàng</h1>
            
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tr>
                    <th>ID đơn hàng</th>
                    <th>ID người dùng</th>
                    <th>Mã giỏ hàng</th>
                    <th>Email đơn hàng</th>
                    <th>Địa chỉ đơn hàng</th>
                    <th>Điện thoại đơn hàng</th>
                    <th>Ngày đặt hàng</th>
                    <th>Hành động</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>" . $row["orderID"] . "</td>
                        <td>" . $row["userID"] . "</td>
                        <td>" . $row["cartCode"] . "</td>
                        <td>" . $row["orderEmail"] . "</td>
                        <td>" . $row["orderAddress"] . "</td>
                        <td>" . $row["orderPhone"] . "</td>
                        <td>" . $row["orderDate"] . "</td>
                        <td>
                            <a class='btn btn-edit' href='orders_edit.php?id=" . $row["orderID"] . "'>Chi tiết đơn hàng </a>
                            <button class='btn btn-delete' onclick='confirmDelete(" . $row["orderID"] . ")'>Xóa</button>
                        </td>
                      </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Không có bản ghi nào</td></tr>";
                }
                ?>
            </table>

            <div class="pagination">
                <?php
                if ($page > 1) {
                    echo "<a href='orders_index.php?page=" . ($page - 1) . "' class='btn btn-default'>Trang trước</a> ";
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        echo "<a href='orders_index.php?page=" . $i . "' class='btn btn-primary active'>" . $i . "</a> ";
                    } else {
                        echo "<a href='orders_index.php?page=" . $i . "' class='btn btn-default'>" . $i . "</a> ";
                    }
                }

                if ($page < $total_pages) {
                    echo "<a href='orders_index.php?page=" . ($page + 1) . "' class='btn btn-default'>Trang sau</a>";
                }
                ?>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(orderID) {
            if (confirm("Bạn có chắc chắn muốn xóa đơn hàng này không?")) {
                $.post("orders_delete.php", { orderID: orderID }, function(data) {
                    if (data === "success") {
                        alert("Xóa đơn hàng thành công!");
                        window.location.href = "orders_index.php";
                    } else {
                        alert(data);
                    }
                });
            }
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>
