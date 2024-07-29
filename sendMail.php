<?php
function GuiMail(){   
    require "PHPMailer-master/src/PHPMailer.php"; 
    require "PHPMailer-master/src/SMTP.php"; 
    require 'PHPMailer-master/src/Exception.php'; 
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);//true:enables exceptions
    try {
        $mail->SMTPDebug = 2; //0,1,2: chế độ debug. khi chạy ngon thì chỉnh lại 0 nhé
        $mail->isSMTP();  
        $mail->CharSet  = "utf-8";
        $mail->Host = 'smtp.gmail.com';  //SMTP servers
        $mail->SMTPAuth = true; // Enable authentication
        $mail->Username = 'mtest2912@gmail.com'; // SMTP username
        $mail->Password = 'Ngocvinh203';   // SMTP password
        $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
        $mail->Port = 465;  // port to connect to neu la TLS = 587           
        $mail->setFrom('mtest2912@gmail.com', 'Mail TesT' ); 
        $mail->addAddress('vinhngocdang203@gmail.com', 'Đặng Ngọc Vinh'); //mail và tên người nhận  
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Tiêu đề thư';
        $noidungthu = '<P>Chào bạn! <hr><b>Chúc bạn an lành!</b></P>'; 
        $mail->Body = $noidungthu;
        $mail->smtpConnect( array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
                "allow_self_signed" => true
            )
        ));
        $mail->send();
        echo 'Đã gửi mail xong';
    } catch (Exception $e) {
        echo 'Mail không gửi được. Lỗi: ', $mail->ErrorInfo;
    }
 }//function GuiMail
?>

<?PHP
guimail();
?> 