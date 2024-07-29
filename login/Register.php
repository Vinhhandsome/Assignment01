<?php

include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    if (
        !empty($_POST['username']) && !empty($_POST['password']) &&
        !empty($_POST['dob']) && !empty($_POST['phone']) &&
        !empty($_POST['email']) && !empty($_POST['address'])
    ) {

        $username = $_POST['username'];
        $hashedPassword = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $dob = $_POST['dob'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $roleUser = $_POST['roleUser'];

        function convertToDate($day)
        {
            $date = strtotime($day);
            return date("Y-m-d", $date);
        }

        $dateIntoDb = convertToDate($dob);

        $query = "INSERT INTO `user` (userName, password, dob, address, phone, email, roleUser)
                  VALUES ('$username', '$hashedPassword', '$dateIntoDb', '$address', '$phone', '$email', '$roleUser')";

        $result = $conn->query($query);

        if ($result === TRUE) {
            echo '<script>alert("Successfully Registered"); window.location.href="login.php";</script>';
            exit();
        } else {
            echo "Failed to Register: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="signIn-Up.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>
    <?php include "../home/navbar.php"; ?>
    <form action="" method="POST" class="sign-in-form">
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <div class="mb-md-5 mt-md-4 pb-5">
                                    <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
                                    <p class="text-white-50 mb-5">Please enter your details!</p>
                                    <div class="form-outline form-white mb-4">

                                        <input type="text" name="username" placeholder="Username" required class="form-control form-control-lg" />
                                    </div>
                                    <div class="form-outline form-white mb-4">

                                        <input type="password" name="password" placeholder="Password" required class="form-control form-control-lg" />
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        
                                        <input type="email" id="email" name="email" placeholder="Email" required class="form-control form-control-lg" />
                                    </div>
                                    <div class="form-outline form-white mb-4">

                                        <input type="date" name="dob" required class="form-control form-control-lg" />
                                    </div>
                                    <div class="form-outline form-white mb-4">

                                        <input type="tel" id="phone" name="phone" placeholder="Phone" required class="form-control form-control-lg" />
                                    </div>
                                    <div class="form-outline form-white mb-4">

                                        <input type="text" id="address" name="address" placeholder="Address" required class="form-control form-control-lg" />
                                    </div>
                                    <input type="hidden" id="roleUser" name="roleUser" value="0">
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="login">Sign Up</button>
                                </div>
                                <div>
                                    <p class="mb-0">Already have an account? <a href="login.php" class="text-white-50 fw-bold">Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</body>

</html>
