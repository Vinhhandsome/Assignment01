<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>SEND THE CONTACT</title>
    <style>
        :root {
            --primary-color: #dc3545;
            /* Red color */
        }

        .custom-button {
            background-color: var(--primary-color);
            color: #fff;
        }

        .custom-link {
            color: var(--primary-color) !important;
            text-decoration: none !important;
        }

        .short-input {
            width: 300px !important;
            margin-bottom: 0px !important;
        }

        .form-row {
            margin-bottom: 10px !important;
        }

        .form-row .form-group {
            margin-right: 10px !important;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
        }

        .contact-section {
            flex: 1;
            margin-right: 20px;
        }
        .textDecreption {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include '../home/navbar.php'; ?>
    <div class="wrapper container-fluid textDecreption">
        <div class="container col-inner"> <br>


            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $fullName = $_POST["fullName"];
                $phoneNumber = $_POST["phoneNumber"];
                $email = $_POST["email"];
                $title = $_POST["title"];
                $note = $_POST["note"];

                echo "<h3>CONTACT INFO</h3>";
                echo "<p><strong>Name:</strong> $fullName</p>";
                echo "<p><strong>Phone Number:</strong> $phoneNumber</p>";
                echo "<p><strong>Email:</strong> $email</p>";
                echo "<p><strong>Title:</strong> $title</p>";
                echo "<p><strong>Note:</strong> $note</p>";

                exit;
            }
            ?>

            <div class="flex-container">
                <div class="contact-section">
                    <h2>SEND THE CONTACT</h2>
                    <form id="contactForm" method="post" action="index.php">
                        <div class="form-group">
                            <label for="fullName"></label>
                            <input type="text" class="form-control" id="fullName" placeholder="Enter your full name" name="fullName" required>
                        </div>

                        <div class="form-group">
                            <label for="phoneNumber"></label>
                            <input type="text" class="form-control" id="phoneNumber" placeholder="Enter your phone number" name="phoneNumber" required>
                        </div>

                        <div class="form-group">
                            <label for="email"></label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="title"></label>
                            <input type="text" class="form-control" id="title" placeholder="Enter a title" name="title">
                        </div>

                        <div class="form-group">
                            <label for="note"></label>
                            <textarea class="form-control" rows="3" placeholder="Write your note" name="note"></textarea>
                        </div>
                        <div class="p-2">   
                            <button type="button" class="btn btn-danger" onclick="onSubmitForm()">SEND</button>
                        </div>
                    </form>

                </div>

                <div class="contact-section">
                    <h2 class="p-3">CONTACT INFO</h2>
                    <p><strong>OCEANGATE GENUINE DISTRIBUTOR IN VIETNAM – VIETNAM IT TECHNOLOGY SERVICES AND TRADING COMPANY LIMITED</strong></p>
                    <p><strong>Address:</strong> 3rd floor, 19 Le Thanh Nghi Street, Bach Mai Ward, Hai Ba Trung District, Ha Noi City</p>
                    <p><strong>Hotline:</strong> 1800 1141</p>
                    <p><strong>Website:</strong> OceanGate@</p>
                    <p><strong>Email:</strong> <a href="../index/index.php" class="custom-link bold-link">OceanGate@oceangate.com.vn</a></p>
                </div>
            </div>

            <iframe class="my-3" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.7402958370076!2d105.84755407564155!3d21.003044988660463!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac748cd9d447%3A0xaf1371c17f07550c!2zMTkgUC4gTMOqIFRoYW5oIE5naOG7iywgQuG6oWNoIE1haSwgSGFpIELDoCBUcsawbmcsIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1703469850204!5m2!1svi!2s" width="100%" height="300px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <?php include '../home/footer.html'; ?>
    <script>
        function onSubmitForm() {

            var fullName = document.getElementById('fullName').value;
            var phoneNumber = document.getElementById('phoneNumber').value;
            var email = document.getElementById('email').value;


            if (fullName === '' || phoneNumber === '' || email === '') {
                alert('Please fill in all required fields.');
            } else {
                alert('Information sent successfully!');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>