<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>GIAO HÀNG VÀ THANH TOÁN</title>
    <style>
        .container h1 {
            text-align: center;
            margin-top: 20px;
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

        .textDecreption {
            animation: fadeIn 0.8s ease-out;
        }

        .contact-info {
            margin-top: 20px;
        }

        .bank-info {
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .container img {
            width: 20%;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include '../home/navbar.php'; ?>

    <div class="wrapper container-fluid">
        <div class="container col-inner textDecreption text-justify ">

            <h1 class="my-3">GIAO HÀNG VÀ THANH TOÁN</h1>

            <h3 class="my-3">Thông tin giao hàng</h3>

            <p><strong>Trong nội thành Hà Nội:</strong></p>
            <ul>
                <li>Chúng tôi cam kết vận chuyển và giao hàng kịp thời, an toàn trong khu vực nội thành Hà Nội.</li>
                <li>Phí vận chuyển và giao hàng dao động từ 3 đến 10 USD, tùy thuộc vào địa điểm.</li>
                <li>Có thể miễn phí vận chuyển cho nhiều sản phẩm.</li>
                <li>Nhân viên giao hàng của chúng tôi sẽ liên hệ trước với khách hàng để hẹn lịch giao hàng.</li>
                <li>Chúng tôi đảm bảo giao hàng an toàn trong bao bì gốc.</li>
            </ul>

            <p><strong>Giao hàng tới các tỉnh và thành phố khác:</strong></p>
            <ul>
                <li>Sau khi đóng gói, khách hàng sẽ nhận được mã vận đơn để dễ dàng theo dõi.</li>
                <li>Chi phí vận chuyển dao động từ 10 đến 20 USD, tùy thuộc vào kích thước lô hàng.</li>
                <li>Nhân viên giao hàng của chúng tôi sẽ liên hệ với khách hàng để sắp xếp lịch giao hàng thuận tiện.</li>
                <li>Chúng tôi đảm bảo giao hàng an toàn trong bao bì gốc.</li>
            </ul>
            <p>Nếu bạn có bất kỳ thắc mắc hay cần hỗ trợ thêm về việc vận chuyển, vui lòng liên hệ với Trung Tâm Chăm Sóc Khách Hàng OceanGate. Sự hài lòng và an toàn của đơn hàng của bạn là ưu tiên hàng đầu của chúng tôi.</p>
            <h3 class="my-3">Thông tin thanh toán</h3>

            <p><strong>Thanh toán qua tài khoản ngân hàng:</strong></p>
            <p>Nếu bạn muốn thanh toán trước và nhận hàng sau, vui lòng chuyển khoản thanh toán vào tài khoản ngân hàng sau:</p>

            <div class="bank-info">
                <p><strong>Tài khoản ngân hàng:</strong> 19036828310118 <strong>TECHCOMBANK</strong></p>
            </div>
            <div>
                <p>Hoặc, bạn có thể sử dụng <strong>mã QR</strong> đã cung cấp:</p>
                <img src="../Photos/Logo/QR.jpg" alt="Công nghệ OceanGate" class="col-lg-6 mx-auto d-block my-3 textDecreption">
            </div>

            <p><strong><span style="color: #dc3545; font-style: italic;">Lưu ý:</span></strong> Bất kỳ tài khoản nào không được cập nhật ở trên đều không hợp lệ để thanh toán.</p>

            <div class="contact-info">
                <p>Vui lòng thông báo cho chúng tôi qua số điện thoại <strong>1800 1141</strong> sau khi chuyển khoản thành công để xác nhận thanh toán của bạn. Sự xác nhận kịp thời của bạn giúp chúng tôi xử lý đơn hàng hiệu quả và đảm bảo giao dịch suôn sẻ. Nếu bạn có bất kỳ câu hỏi nào hoặc cần hỗ trợ thêm, vui lòng liên hệ với Trung Tâm Chăm Sóc Khách Hàng OceanGate. Cảm ơn bạn đã chọn OceanGate!</p>
            </div>
        </div>
    </div>
    <?php include "../home/footer.html" ?>
</body>

</html>
