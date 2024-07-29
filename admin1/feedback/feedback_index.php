<?php
include("../index/index.php");
include('../db.php');

// Số bản ghi hiển thị trên mỗi trang
$records_per_page = 10;

// Lấy số trang hiện tại từ chuỗi truy vấn, mặc định là 1 nếu không có
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start_from = ($page - 1) * $records_per_page;

// Truy xuất tổng số bản ghi
$total_sql = "SELECT COUNT(*) FROM feedback";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_row();
$total_records = $total_row[0];

// Tính tổng số trang
$total_pages = ceil($total_records / $records_per_page);

// Truy xuất bản ghi cho trang hiện tại
$sql = "SELECT * FROM feedback LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Quản lý Feedback</title>
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
    <div class="container">
        <h1>Quản lý Feedback</h1>
       
        <table class="table table-bordered">
            <tr>
                <th>ID Feedback</th>
                <th>ID User</th>
                <th>ID Đơn hàng</th>
                <th>ID Sản phẩm</th>
                <th>Thông điệp</th>
                <th>Hành động</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $row["feedbackID"] . "</td>
                    <td>" . $row["userID"] . "</td>
                    <td>" . $row["orderID"] . "</td>
                    <td>" . $row["productID"] . "</td>
                    <td>" . $row["message"] . "</td>
                    <td>
                        <a class='btn btn-edit' href='feedback_edit.php?id=" . $row["feedbackID"] . "'>Chỉnh sửa</a>
                        <button class='btn btn-delete' onclick='confirmDelete(" . $row["feedbackID"] . ")'>Xóa</button>
                    </td>
                  </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Không có bản ghi nào</td></tr>";
            }
            ?>
        </table>

        <div class="pagination">
            <?php
            if ($page > 1) {
                echo "<a href='feedback_index.php?page=" . ($page - 1) . "' class='btn btn-default'>Trang trước</a> ";
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<a href='feedback_index.php?page=" . $i . "' class='btn btn-primary active'>" . $i . "</a> ";
                } else {
                    echo "<a href='feedback_index.php?page=" . $i . "' class='btn btn-default'>" . $i . "</a> ";
                }
            }

            if ($page < $total_pages) {
                echo "<a href='feedback_index.php?page=" . ($page + 1) . "' class='btn btn-default'>Trang sau</a>";
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function confirmDelete(feedbackID) {
            if (confirm("Bạn có chắc chắn muốn xóa Feedback này không?")) {
                $.post("feedback_delete.php", { feedbackID: feedbackID }, function(data) {
                    if (data === "success") {
                        alert("Xóa Feedback thành công!");
                        window.location.href = "feedback_index.php";
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
