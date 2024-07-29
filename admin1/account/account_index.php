<?php
include("../index/index.php");
include("../db.php");

// Thiết lập số bản ghi trên mỗi trang
$records_per_page = 10;

// Lấy trang hiện tại từ tham số URL, mặc định là trang 1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start_from = ($page - 1) * $records_per_page;

// Tính tổng số bản ghi trong bảng user
$total_sql = "SELECT COUNT(*) FROM user";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_row();
$total_records = $total_row[0];

// Tính tổng số trang
$total_pages = ceil($total_records / $records_per_page);

// Lấy dữ liệu của trang hiện tại
$sql = "SELECT * FROM user LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Account</title>
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
            color: #ffff;
            text-decoration: none;
            background-color: #000000;
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
            background-color: #FFFFFF;
            border-color: #000000;

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
            color: #FFFFFF;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #f1f1f1;
        }

        .pagination a.active {
            background-color: #dc3545;
            color: #fff;
            border: 1px solid #000000;
        }
    </style>

</head>

<body>
    <div class="container-fuild">
        <div class="side-body">
            <h1 class="mt-4">Quản lý tài khoản</h1>
            <a class="btn mt-4" href="register.php">Tạo tài khoản mới</a>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tr>
                    <th>User Name</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Date of birth</th>
                    <th>Role User</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                         <td>" . $row["userName"] . "</td>
                         <td>" . $row["password"] . "</td>
                         <td>" . $row["email"] . "</td>
                         <td>" . $row["address"] . "</td>
                         <td>" . $row["phone"] . "</td>
                         <td>" . $row["dob"] . "</td>
                         <td>" . $row["roleUser"] . "</td>
                         <td>
                            <a class='btn btn-edit' href='#?id=" . $row["userID"] . "'>Chỉnh sửa</a>
                            <button class='btn btn-delete' onclick='confirmDelete(" . $row["userID"] . ")'>Xóa</button>
                         </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='14'>Không có bản ghi nào</td></tr>";
                }
                ?>

            </table>

            <div class="pagination">
                <?php
                if ($page > 1) {
                    echo "<a href='account_index.php?page=" . ($page - 1) . "' class='btn btn-default'>Trang trước</a> ";
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        echo "<a href='account_index.php?page=" . $i . "' class='btn btn-primary active'>" . $i . "</a> ";
                    } else {
                        echo "<a href='account_index.php?page=" . $i . "' class='btn btn-default'>" . $i . "</a> ";
                    }
                }

                if ($page < $total_pages) {
                    echo "<a href='account_index.php?page=" . ($page + 1) . "' class='btn btn-default'>Trang sau</a>";
                }
                ?>
            </div>
        </div>

    </div>

    <script>
        function confirmDelete(userID) {
            if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
                $.post("account_delete.php", { userID: userID }, function(data) {
                    if (data === "success") {
                        alert("Xóa sản phẩm thành công!");
                        window.location.href = "../account/account_index.php";
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