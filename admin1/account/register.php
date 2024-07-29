<?php

include('../index/index.php');
include("../db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {

        $username = $_POST['username'];
        $hashedPassword = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $dob = !empty($_POST['dob']) ? $_POST['dob'] : null;
        $phone = !empty($_POST['phone']) ? $_POST['phone'] : null;
        $email = !empty($_POST['email']) ? $_POST['email'] : null;
        $address = !empty($_POST['address']) ? $_POST['address'] : null;
        $roleUser = $_POST['roleUser'];

        function convertToDate($day) {
            $date = strtotime($day);
            return date("Y-m-d", $date);
        }

        $dateIntoDb = $dob ? convertToDate($dob) : null;

        $query = "INSERT INTO `user` (userName, password, dob, address, phone, email, roleUser) VALUES ('$username', '$hashedPassword', ";

        if ($dateIntoDb) {
            $query .= "'$dateIntoDb', ";
        } else {
            $query .= "NULL, ";
        }

        if ($address) {
            $query .= "'$address', ";
        } else {
            $query .= "NULL, ";
        }

        if ($phone) {
            $query .= "'$phone', ";
        } else {
            $query .= "NULL, ";
        }

        if ($email) {
            $query .= "'$email', ";
        } else {
            $query .= "NULL, ";
        }

        $query .= "'$roleUser')";

        $result = $conn->query($query);

        if ($result === TRUE) {
            echo '<script>alert("Successfully Registered"); window.location.href="account_index.php";</script>';
            exit();
        } else {
            echo "Failed to Register: " . $conn->error;
        }
    } else {
        echo "Username and Password are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="container">
        <a href="javascript:history.back()" class="btn btn-secondary btn-back">Back</a>
        <div class="side-body form-container sign-up">
            <h1 class="text-center">Register New User</h1>
            <form method="post" action="">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#general">
                            <h4 class="panel-title">
                                General Information
                            </h4>
                        </div>
                        <div id="general" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date of Birth (optional):</label>
                                    <input type="text" class="form-control" id="dob" name="dob">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone (optional):</label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email (optional):</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address (optional):</label>
                                    <input type="text" class="form-control" id="address" name="address">
                                </div>
                                <div class="form-group">
                                    <label for="roleUser">Role:</label>
                                    <select class="form-control" id="roleUser" name="roleUser" required>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
            </form>
        </div>
    </div>
</body>

</html>
