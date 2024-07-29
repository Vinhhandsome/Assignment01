<?php

include('../db.php');
include('../home/navbar.php'); 
if(isset($_POST['checkout'])){
    if(!empty($_POST['username'])&&!empty($_POST['phoneNumber'])&&!empty($_POST['email'])&&!empty($_POST['paymentMethod'])&&!empty($_POST['address'])){
        $userID = $_POST['userID'];
        $phoneNumber = $_POST['phoneNumber'];
        $orderEmail = $_POST['email'];
        $orderAddress = $_POST['address'];
    
        $truncateTableCart = "TRUNCATE TABLE `eproject`.`carts`;";
        $resultTruncateTableCart = $conn ->query($truncateTableCart);
        $sqlInsertOrder = "INSERT INTO `order`(orderID,userID,cartCode,orderEmail,orderAddress,orderPhone,orderDate)
                    VALUES (DEFAULT,'$userID', '1', '$orderEmail', '$orderAddress','$phoneNumber',DEFAULT);";
        $resultInsertOrder = $conn ->query($sqlInsertOrder);
    
        unset($_SESSION['cartItem']);
        unset($_SESSION['cartNumber']);
    
        if (!$resultInsertOrder) {
            echo "Error: " . $sqlInsertOrder . "<br>" . $conn->error;
        }  
    }    
}
if (isset($_SESSION["userName"])){
    $userName = $_SESSION["userName"];
    $sqlUser = "SELECT * FROM user WHERE userName = '$userName'";
    $resultUser = $conn->query($sqlUser);
    $userID = null;
    if ($resultUser && $resultUser->num_rows > 0) {
        while ($row = $resultUser->fetch_assoc()) {
            $userID = $row['userID'];
            $userName = $row['userName'];
            $userEmail = $row['email']; 
            $userAddress = $row['address'];
            $userPhone = $row['phone'];
        }
}

//Modal notification checkout completed
    echo "<div class='modal modalPaymentSuccess' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h1 class='modal-title fs-5' id='staticBackdropLabel'>NOTIFICATION</h1>
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-body text-success'>
          Payment successful <i class='fa-solid fa-check'></i>
          </div>
          <div class='modal-footer'>
            <a href='checkoutCompleted.php' class='btn btn-success'>Close</a>
          </div>
        </div>
      </div>
    </div>";
?>

<div class="view-Checkout d-flex justify-content-center py-5">
<div class="view-checkout-details  p-4">
    <h1 class="">Your Order</h1>
    <form action="" method="post">
    <table class=" table align-middle ">
        <tr class="">
            <th scope="col" class="">Product</th>
            <th scope="col" class="">Price</th>
            <th scope="col" class="text-center">Quantity</th>
            <th scope="col" class="">Money</th>
        </tr>
        <?php
            $totalCart = 0;
            foreach ($_SESSION['checkoutItems'] as $item){
                $productID = $item['productID'];
                $productName = $item['productName'];
                $imageLink = $item['imageLink'];
                $quantity = $item['quantity'];
                $unitPrice = $item['unitPrice'];
                $userID = $item['userID'];
                $totalMoney = $quantity * $unitPrice;
                $totalCart+=($quantity*$unitPrice);
        ?>
        <tr>
            <td class="d-flex align-items-center">
                <div class="cart-img p-1 m-1">
                    <img src="<?php echo  $imageLink; ?>" alt="Product img">
                </div>
                <div class="cart-name-product p-1 m-1 fw-bold"><?php echo $productName; ?></div>
            </td>
            <td class="price-product"><?php echo $unitPrice  ; ?></td>
            <td class="text-center"><?php echo $quantity; ?>
            </td>
            <td class="total-price" class=" mx-2"><?php echo $totalMoney; ?></td>
        </tr>
        <?php }?>
        <tr>
            <td colspan="3" class="fw-bold">Total</td>
            <td id="totalCart"class="fw-bold text-danger"><?php echo "$". $totalCart; ?></td>
        </tr>              
    </table>
    <div class="infor-user">
        <h3>Customer information</h3>
        <div class="d-flex m-2 p-2">
            <label class="p-2 text-lg" for="username">Username:</label>
            <input class="p-2" type="text" id="username" name="username" value="<?php echo $userName ?>" required oninput="checkInput()" placeholder="Please enter you user name">
        </div>
        <div class="d-flex m-2 p-2">
            <label class="p-2 text-lg" for="phoneNumber">Phone Number:</label>
            <input class="p-2" type="tel" id="phoneNumber" name="phoneNumber" value="<?php echo $userPhone ?>" required oninput="checkInput()" placeholder="Please enter you phone number">
        </div>
        <div class="d-flex m-2 p-2">
            <label class="p-2 text-lg" for="email">Email:</label>
            <input class="p-2" type="email" id="email" name="email" value="<?php echo $userEmail ?>" required oninput="checkInput()" placeholder="Please enter you email">
        </div>
        <div class="d-flex m-2 p-2 align-items-center">
                <label class="p-2 text-lg" for="email">Payment Method:</label>
                <div class="d-flex flex-wrap  align-items-center">
                <div class="mx-1 d-flex col-lg-3 align-items-center">
                    <input class="p-2" type="radio" id="cash" checked name="paymentMethod" value="cash" required>
                    <label for="cash">Cash</label><br>
                </div>
                <div class="mx-1 d-flex col-lg-3 align-items-center">
                    <input class="p-2" type="radio" id="bank" name="paymentMethod" value="bank" required>
                    <label for="cash">Bank </label><br>
                </div>
                <div class="mx-1 d-flex col-lg-3 align-items-center">
                    <input class="p-2" type="radio" id="mastercard" name="paymentMethod" value="mastercard" required>
                    <label for="cash">MasterCard</label><br>
                </div>
                </div>
        </div>
        <div class="d-flex m-2 p-2">
            <label class="p-2 text-lg" for="address">Address:</label>
            <textarea class="p-3" id="address" name="address" placeholder="Please enter your delivery address...." required oninput="checkInput()"></textarea>
        </div>
        <input type="hidden" name="userID" value="<?php echo $userID;  ?>">
        <div class="d-flex justify-content-center ">
        <button type="submit" name="checkout" class="btn btn-danger checkOut list-group=item" id ="paymentButton" data-bs-toggle="modal" data-bs-target="#notifyPaymentSuccess">Payment</button>
        </div>
    </div>     
</form>
</div>
</div>
<?php } ?>
<!-- footer -->
<?php include('../home/footer.html'); ?>
<!-- Link -->

<script src="controller.js"></script>
<script src="checkoutCompleted.js"></script>