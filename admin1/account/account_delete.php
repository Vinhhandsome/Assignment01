<?php
include ("../db.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["userID"])){
        $userID = $_POST["userID"];
        $sql = "DELETE FROM user WHERE userID=$userID";
        if($conn->query($sql) === TRUE){
            echo "Account deleted successfully";
        } else {
            echo "Error deleting user: ". $conn->error;
        }
    } else {
        echo "Error: User ID is not set.";
    }
}
$conn->close();
?>
