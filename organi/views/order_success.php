<?php
$query  = "select * from `member` where `username`='" . $_SESSION['member'] . "'";
$member = mysqli_fetch_array($connect->query($query));
$memberId = $member['id'];
if (isset($_GET['vnp_Amount']) && isset($_GET['vnp_BankTranNo'])) {
    $vnp_Amount = $_GET['vnp_Amount'];
    $vnp_BankCode = $_GET['vnp_BankCode'];
    $vnp_BankTranNo = $_GET['vnp_BankTranNo'];
    $vnp_OrderInfo = $_GET['vnp_OrderInfo'];
    $vnp_PayDate = $_GET['vnp_PayDate'];
    $vnp_TmnCode = $_GET['vnp_TmnCode'];
    $vnp_TransactionNo = $_GET['vnp_TransactionNo'];
    $vnp_CardType = $_GET['vnp_CardType'];
    $query = "select id from orders order by id desc limit 1";
    $orderId = mysqli_fetch_array($connect->query($query))['id'];
    $insert_vnpay = "insert into `vnpay` (`vnp_Amount`, `vnp_BankCode`, `vnp_BankTranNo`, `vnp_OrderInfo`, 
    `vnp_PayDate`, `vnp_TmnCode`, `vnp_TransactionNo`, `order_id`) values ('$vnp_Amount', '$vnp_BankCode', '$vnp_BankTranNo', '$vnp_OrderInfo', 
    '$vnp_PayDate', '$vnp_TmnCode', '$vnp_TransactionNo', '$orderId')";
    $connect->query($insert_vnpay);
} else if (isset($_GET['vnp_Amount']) && empty($_GET['vnp_BankTranNo'])) {
    $query = "select id from orders order by id desc limit 1";
    $orderId = mysqli_fetch_array($connect->query($query))['id'];
    $connect->query("update orders set status = 4 where id = " . $orderId);
} else if (isset($_GET['method']) == 'paypal') {
    $receiver = $member['fullname'];
    $address = $member['address'];
    $phone = $member['phonenumber'];
    $email = $member['email'];
    $query = "INSERT INTO orders (order_method_id, member_id, receiver, address, phone, email)
    VALUES (4, $memberId, '$receiver', '$address', '$phone', '$email')";
    $connect->query($query);
    $query = "select id from orders order by id desc limit 1";
    $orderId = mysqli_fetch_array($connect->query($query))['id'];
    $queryCart = " select * from `cart` where `member_id` = " . $member['id'];
    $resultQueryCart = $connect->query($queryCart);
    $total = 0;
    foreach ($resultQueryCart as $item) {
        $productId = $item['product_id'];
        $number = $item['quantity'];
        $price = $item['product_price'];
        $query = "insert `order_detail` values ($productId, $orderId, $number, $price)";
        $pay_result = $connect->query($query);
        $total += $item['product_price'] * $item['quantity'];
    }
    $connect->query("delete from cart where member_id = " . $memberId);
}
else if (isset($_GET['vpc_AdditionData'])) {
    $receiver = $member['fullname'];
    $address = $member['address'];
    $phone = $member['phonenumber'];
    $email = $member['email'];
    $query = "INSERT INTO orders (order_method_id, member_id, receiver, address, phone, email)
    VALUES (3, $memberId, '$receiver', '$address', '$phone', '$email')";
    $connect->query($query);
    $query = "select id from orders order by id desc limit 1";
    $orderId = mysqli_fetch_array($connect->query($query))['id'];
    $queryCart = " select * from `cart` where `member_id` = " . $member['id'];
    $resultQueryCart = $connect->query($queryCart);
    $total = 0;
    foreach ($resultQueryCart as $item) {
        $productId = $item['product_id'];
        $number = $item['quantity'];
        $price = $item['product_price'];
        $query = "insert `order_detail` values ($productId, $orderId, $number, $price)";
        $pay_result = $connect->query($query);
        $total += $item['product_price'] * $item['quantity'];
    }
    $connect->query("delete from cart where member_id = " . $memberId);
}
?>
<?php

?>

<section class="order_success-container">
    <?php if ((isset($_GET['vnp_Amount'])) && (empty($_GET['vnp_BankTranNo']))) : ?>
    <div style="text-align: center; display: flex; flex-direction: column; gap: 20px">
        <img src="https://static-00.iconduck.com/assets.00/sad-emoji-1024x1024-ibj29re8.png" alt="" />
        <h4>Thanh toán không thành công</h4>
        <div style="display: flex; justify-content: center; gap: 20px">
            <a href="?option=show_products" class="btn btn-info">Tiếp tục mua sắm</a>
            <a href="?option=cart" class="btn btn-success">Quay lại giỏ hàng</a>
        </div>
    </div>
    <?php else : ?>
    <div class="img-order-success">
        <img src="../images/order_success.webp" />
    </div>
    <h3 class="text-center mt-2">Bạn đã đặt hàng thành công</h3>
    <h5 class="text-center mt-3 mb-4"><i>Chúng tôi sẽ sớm giao sách đến trong vòng 3-5 ngày</i></h5>
    <div class="btn-order-success">
        <a href="?option=home"><button class="btn btn-outline-info">Trang chủ</button></a>
        <a href="?option=show_products"><button class="btn btn-success">Tiếp tục mua hàng</button></a>
    </div>
    <?php endif; ?>
</section>