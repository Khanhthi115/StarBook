<?php
require_once("./config_vnpay.php");
$query  = "select * from `member` where `username`='" . $_SESSION['member'] . "'";
$member = mysqli_fetch_array($connect->query($query));
?>
<?php
$queryCart = " select * from `cart` where `member_id` = " . $member['id'];
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
    $memberId = $member['id'];
    $query = "insert `orders` (order_method_id, member_id, receiver, address, phone, email, note) values ($order_method_id, $memberId, '$name', '$address', $phone, '$email', '$note')";
    $connect->query($query);
    $query = "select `id` from `orders` order by id desc limit 1";
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
            header("Location: ?option=order_success");
            break;
    }
}
?>

<?php
$queryCart = "select * from cart where member_id = $memberId";
$productsInCart = $connect->query($queryCart);
$total = 0;
?>
<div class="container-order">
    <h2 class="text-center my-3"><b>Đặt hàng</b></h2>
    <p class="text-center"><i>(Điền đầy đủ thông tin phía bên dưới trừ các phương thức thanh toán ngay)</i></p>

    <div class="order-container">
        <div class="order-list-products">
            <p>Danh sách sản phẩm đặt</p>
            <table>
                <thead>
                    <tr>
                        <th class="shoping__product">Tên Sách</th>
                        <th>Ảnh</th>
                        <th>Số Lượng</th>
                        <th>Thành Tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productsInCart as $item) : ?>
                        <tr>
                            <td class="shoping__cart__item">
                                <span><?= $item['product_name'] ?><span>
                            </td>
                            <td>
                                <img width="100px" src="../images/<?= $item['product_image'] ?>" alt="">
                            </td>
                            <td class="shoping__cart__total">
                                <span><?= $item['quantity'] ?><span>
                            </td>
                            <td class="shoping__cart__total">
                                <?= number_format($subTotal = $item['product_price'] * $item['quantity'], 0, ',', '.') ?>đ
                                <?php $total += $subTotal; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p></p>
            <b>Tổng tiền: <?= number_format($total + 30000)?>đ (đã tính phí ship)</b>
        </div>
        <div class="order-info">
            <form method="post">
                <h4 class="my-3">Thông tin người nhận hàng</h4>
                <section>
                    <section>
                        <label>Họ tên: </label>
                        <input name="name" value="<?= $member['fullname'] ?>" required>
                    </section>
                    <section>
                        <label>Điện thoại: </label>
                        <input type="tel" name="phone" value="<?= $member['phonenumber'] ?>" required>
                    </section>
                    <section style="display: flex; align-items: center;">
                        <label>Địa chỉ: </label>
                        <textarea name="address" rows="3" cols="50" required><?= $member['address'] ?></textarea>
                    </section>
                    <section>
                        <label>Email: </label>
                        <input name="email" type="email" value="<?= $member['email'] ?>">
                    </section>
                    <section style="display: flex; align-items: center;">
                        <label>Note: </label>
                        <textarea name="note" rows="3" cols="50"></textarea>
                    </section>
                </section>
                <?php
                $query = "select * from `order_methods` where status";
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
                <p style="text-align: center">Hoặc thanh toán ngay với Paypal</p>
                <section>
                    <div id="paypal-button-container" style="width: 50%; margin: 0 auto"></div>
                </section>
            </form>
            <p style="text-align: center">Hoặc thanh toán ngay với Momo</p>
            <form class="btn-momo-container" action="views\momoQR.php" class="" method="POST" target="_blank" enctype="application/x-www-form-urlencoded" action="init_payment.php">
                <input type="submit" name="momo" value="Thanh toán MOMO QRcode" class="btn btn-danger btn-momo">
            </form>
            <p></p>
            <form class="btn-momo-container" action="views\momoATM.php" class="" method="POST" target="_blank" enctype="application/x-www-form-urlencoded" action="init_payment.php">
                <input type="submit" name="momo" value="Thanh toán MOMO ATM" class="btn btn-danger btn-momo">
            </form>
        </div>
    </div>
</div>