<?php
include ("../db.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["productID"])){
        $productID = $_POST["productID"];
        $sql = "DELETE FROM products WHERE productID=$productID";
        if($conn->query($sql) === TRUE){
            echo "Product deleted successfully";
        } else {
            echo "Error deleting product: ". $conn->error;
        }
    } else {
        echo "Error: Product ID is not set.";
    }
}
$conn->close();
?>
