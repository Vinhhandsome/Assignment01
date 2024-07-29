<?php
include("../index/index.php");
include('../db.php');

$searchResults = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    $query = $_GET['query'];
    $query = $conn->real_escape_string($query);

    // Tìm kiếm trong bảng sản phẩm
    $sql = "SELECT productName, productID FROM products WHERE productName LIKE '%$query%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $searchResults['products'][] = $row;
        }
    }

    // Tìm kiếm trong bảng đơn hàng
    $sql = "SELECT orderID, orderEmail FROM `order` WHERE orderEmail LIKE '%$query%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $searchResults['orders'][] = $row;
        }
    }

    // Tìm kiếm trong bảng tài khoản
    $sql = "SELECT userID, userName, email FROM user WHERE userName LIKE '%$query%' OR email LIKE '%$query%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $searchResults['users'][] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Search</title>
    <style>
        body {
            font-family: Courier, sans-serif;
        }

        .search-container {
            margin-top: 20px;
        }

        .result-table {
            margin-top: 20px;
        }

        .result-table th, .result-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .result-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container search-container">
        <div class="side-body">
        <h1>Search</h1>
        <form action="search.php" method="get">
            <div class="form-group">
                <input type="text" class="form-control" name="query" placeholder="Enter search term..." required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
    </div>

    <?php if (!empty($searchResults)) { ?>
    <div class="container result-table">
        <?php if (!empty($searchResults['products'])) { ?>
        <h2>Products</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($searchResults['products'] as $product) { ?>
                <tr>
                    <td><?php echo $product['productName']; ?></td>
                    <td><?php echo $product['productID']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>

        <?php if (!empty($searchResults['orders'])) { ?>
        <h2>Orders</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order Email</th>
                    <th>Order ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($searchResults['orders'] as $order) { ?>
                <tr>
                    <td><?php echo $order['orderEmail']; ?></td>
                    <td><?php echo $order['orderID']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>

        <?php if (!empty($searchResults['users'])) { ?>
        <h2>Users</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>User ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($searchResults['users'] as $user) { ?>
                <tr>
                    <td><?php echo $user['userName']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['userID']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
    <?php } ?>
</body>
</html>

<?php
$conn->close();
?>
