<?php
require_once("./config_vnpay.php");
$query  = "select * from member where username='" . $_SESSION['member'] . "'";
$member = mysqli_fetch_array($connect->query($query));
?>
<?php
$queryCart = " select * from `cart` where `member_id` = " . $member['id'];
echo $member['id'];
$resultQueryCart = $connect->query($queryCart);
?>
<?php
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $order_method_id = $_POST['order_methods'];

    $query = "insert orders (order_method_id, member_id, receiver, address, phone, email, note) values ($order_method_id, $memberId, '$name', '$address', $phone, '$email', '$note')";
    $connect->query($query);
    $query = "select id from orders order by id desc limit 1";
    $orderId = mysqli_fetch_array($connect->query($query))['id'];
    $queryCart = " select * from `cart` where `member_id` = " . $member['id'];
    echo $member['id'];
    $resultQueryCart = $connect->query($queryCart);
    $total = 0;
    foreach ($resultQueryCart as $item) {
        $productId = $item['product_id'];
        $number = $item['quantity'];
        $price = $item['product_price'];
        $query = "insert `order_detail` values ($productId, $orderId, $number, $price)";
        $connect->query($query);
        $total += $item['product_price'] * $item['quantity'];
    }

    switch ($order_method_id) {
        case 5:
            $vnp_TxnRef = $orderId;
            $vnp_OrderInfo = 'Thanh toán đơn hàng tại web';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = ($total + 30000) * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $expire;
            $vnp_ExpireDate = $expire;
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate" => $vnp_ExpireDate
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00', 'message' => 'success', 'data' => $vnp_Url
            );
            if (isset($_POST['redirect'])) {
                $queryDeleteCart = "delete from `cart` where `member_id` = " . $member['id'];
                $connect->query($queryDeleteCart);
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
            break;
        default:
            $queryDeleteCart = "delete from `cart` where `member_id` = " . $member['id'];
            $connect->query($queryDeleteCart);
            header("location: ?option=order_success");
            break;
    }
}
?>

<h2 class="text-center my-3"><b>Đặt hàng</b></h2>
<p class="text-center"><i>(Điền đầy đủ thông tin phía bên dưới)</i></p>

<section class="order-container">
    <form method="post">
        <h4 class="my-3">Thông tin người nhận hàng</h4>
        <section>
            <section>
                <label>Họ tên: </label>
                <input name="name" value="<?= $member['fullname'] ?>">
            </section>
            <section>
                <label>Điện thoại: </label>
                <input type="tel" name="phone" value="<?= $member['phonenumber'] ?>">
            </section>
            <section>
                <label>Địa chỉ: </label>
                <textarea name="address" rows="3" cols="50"><?= $member['address'] ?></textarea>
            </section>
            <section>
                <label>Email: </label>
                <input name="email" type="email" value="<?= $member['email'] ?>">
            </section>
            <section>
                <label>Note: </label>
                <textarea name="note" rows="3" cols="50"></textarea>
            </section>
        </section>
        <?php
        $query = "select * from order_methods where status";
        $result = $connect->query($query);
        ?>
        <span>Hình thức thanh toán:</span>
        <section>
            <select name="order_methods" class="order-select">
                <?php foreach ($result as $item) : ?>
                    <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                <?php endforeach ?>
            </select>
        </section>
        <br />
        <section class="order-button">
            <input type="submit" value="Đặt hàng" name="redirect" style="margin-top: 20px">
        </section>
    </form>
</section>