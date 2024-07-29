<?php
include('../index/index.php');
include("../db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productID = $_POST["productID"];
    $productName = $_POST["productName"];
    $imageLink = $_POST["imageLink"];
    $unitPrice = $_POST["unitPrice"];
    $quantity = $_POST["quantity"];
    $categoryID = $_POST["categoryID"];
    $brandID = $_POST["brandID"];
    $memory = $_POST["memory"];
    $speed = $_POST["speed"];
    $color = $_POST["color"];
    $warranty = $_POST["warranty"];
    $dimension = $_POST["dimension"];
    $description = $_POST["description"];

    $sql = "UPDATE products SET 
                productName='$productName', 
                imageLink='$imageLink', 
                unitPrice='$unitPrice', 
                quantity='$quantity', 
                categoryID='$categoryID', 
                brandID='$brandID', 
                memory='$memory', 
                speed='$speed', 
                color='$color', 
                warranty='$warranty', 
                dimension='$dimension', 
                description='$description' 
            WHERE productID=$productID";

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully";
    } else {
        echo "Error updating product: " . $conn->error;
    }
} else {
    $productID = $_GET["id"];
    $sql = "SELECT * FROM products WHERE productID=$productID";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    
    
    <style>
        body {
            font-family: Courier, sans-serif;
        }
         h1 {
            margin-bottom: 30px;
        }

        .btn-back {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="javascript:history.back()" class="btn btn-secondary btn-back">Back</a>
        <h1 class="my-4">Edit Product</h1>
        <form method="post" action="products_edit.php">
            <input type="hidden" name="productID" value="<?php echo $row["productID"]; ?>">
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" id="productName" name="productName" class="form-control" value="<?php echo $row["productName"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="imageLink">Image Link</label>
                <input type="text" id="imageLink" name="imageLink" class="form-control" value="<?php echo $row["imageLink"]; ?>" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="unitPrice">Unit Price</label>
                    <input type="number" step="0.01" id="unitPrice" name="unitPrice" class="form-control" value="<?php echo $row["unitPrice"]; ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" value="<?php echo $row["quantity"]; ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="categoryID">Category ID</label>
                    <input type="number" id="categoryID" name="categoryID" class="form-control" value="<?php echo $row["categoryID"]; ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="brandID">Brand ID</label>
                    <input type="number" id="brandID" name="brandID" class="form-control" value="<?php echo $row["brandID"]; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="memory">Memory</label>
                <input type="text" id="memory" name="memory" class="form-control" value="<?php echo $row["memory"]; ?>">
            </div>
            <div class="form-group">
                <label for="speed">Speed</label>
                <input type="text" id="speed" name="speed" class="form-control" value="<?php echo $row["speed"]; ?>">
            </div>
            <div class="form-group">
                <label for="color">Color</label>
                <input type="text" id="color" name="color" class="form-control" value="<?php echo $row["color"]; ?>">
            </div>
            <div class="form-group">
                <label for="warranty">Warranty</label>
                <input type="text" id="warranty" name="warranty" class="form-control" value="<?php echo $row["warranty"]; ?>">
            </div>
            <div class="form-group">
                <label for="dimension">Dimension</label>
                <input type="text" id="dimension" name="dimension" class="form-control" value="<?php echo $row["dimension"]; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3"><?php echo $row["description"]; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    
</body>
</html>
