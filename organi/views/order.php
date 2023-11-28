<?php
include "../PHPMailer/src/PHPMailer.php";
include "../PHPMailer/src/Exception.php";
// include "../PHPMailer/src/OAuth.php";
include "../PHPMailer/src/POP3.php";
include "../PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once("./config_vnpay.php");
$query  = "select * from `member` where `username`='" . $_SESSION['member'] . "'";
$member = mysqli_fetch_array($connect->query($query));
?>
<?php
$queryCart = " select * from `cart` where `member_id` = " . $member['id'];
$resultQueryCart = $connect->query($queryCart);

?>
<?php
if (isset($_SESSION['member'])) {
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
                $vnp_Amount = $total < min_money ? ($total + shipping_fee) * 100 : $total * 100;
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
                    // echo json_encode($returnData);
                    die();
                }
                break;
            default:
                if(isset($_POST["redirect"])){
                    $queryCart = "select * from `cart` where `member_id` = $memberId";
                    $productsInCart = $connect->query($queryCart);
                    $cartItemCount = mysqli_num_rows($productsInCart);
                    $email=$_POST["email"];
                    $orderMethodsId = $_POST["order_methods"];
                    $query = "select `name` from `order_methods` where `id` = $orderMethodsId";
                    $orderMethodName = mysqli_fetch_array($connect->query($query))['name'];
                
                    $orderInfo = "Loại sản phẩm: Sách<br>";
                    foreach ($productsInCart as $item) {
                        $orderInfo .= "Tên sách: " . $item['product_name'] . " - Số Lượng:" . $item['quantity'] . "<br>";
                        // Thêm thông tin khác của sản phẩm nếu cần thiết
                    }
                    $total = $total < min_money ? number_format($total + shipping_fee) : number_format($total);
                    $orderInfo .= "Tổng tiền: " . $total . "<br>";
                    $orderInfo .= "Phương thức thanh toán: " . $orderMethodName . "<br>";
                    $orderInfo .= "Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi!";
                    $mail = new PHPMailer(true);                           
                    try {
                        //Server settings
                        $mail->SMTPDebug = 0;                             
                        $mail->isSMTP();                               
                        $mail->Host = 'smtp.gmail.com';                   
                        $mail->SMTPAuth = true;                   
                        $mail->Username = 'hangt7708@gmail.com';              
                        $mail->Password = 'mkts qeug zmrm snav';                     
                        $mail->SMTPSecure = 'tls';                           
                        // $mail->SMTPAutoTLS = false;
                        // $mail->SMTPSecure = false;
                        $mail->Port = 587;                                                                                                              // Cổng kết nối SMTP sẽ là 25
                
                        //Recipients
                        $mail->setFrom('hangt7708@gmail.com', 'Star Book');           // Địa chỉ email và tên người gửi
                        $mail->addAddress($email);     // Địa chỉ người nhận
                        //$mail->addAddress('ellen@example.com');               // Name is optional
                        //$mail->addReplyTo('info@example.com', 'Information');
                        //$mail->addCC('cc@example.com');
                        //$mail->addBCC('bcc@example.com');
                
                        //Attachments
                        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Nếu muốn gửi thêm tệp thì uncomment dòng này
                        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Và cả dòng này nữa nếu gửi trên một file
                
                        //Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Order Details';                             // Tiêu đề
                        $mail->Body = $orderInfo;                      // Nội dung
                        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                        $mail->send();
                    } catch (Exception $e) {
                                // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                    }
                }
                $queryDeleteCart = "delete from `cart` where `member_id` = " . $member['id'];
                $connect->query($queryDeleteCart);
                header("Location: ?option=order_success");
                break;
        }
    }
} else {
    header("location: ?option=signin");
}
?>

<?php
$queryCart = "select * from `cart` where `member_id` = $memberId";
$productsInCart = $connect->query($queryCart);
$cartItemCount = mysqli_num_rows($productsInCart);
$total = 0;
?>
<?php if ($cartItemCount > 0) : ?>
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
                <b>Tổng tiền: <?= $total < min_money ? number_format($total + shipping_fee) : number_format($total) ?>đ (đã tính phí ship)</b>
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
                    <input type="hidden" value="<?= $total < min_money ? $total + shipping_fee : $total ?>" name="total_momo">
                    <input style="max-width: 50%; margin-left: 25%;" type="submit" name="momo" value="Thanh toán MOMO QRcode" class="btn btn-danger btn-momo">
                </form>
                <p></p>
                <form class="btn-momo-container" action="views\momoATM.php" class="" method="POST" target="_blank" enctype="application/x-www-form-urlencoded" action="init_payment.php">
                    <input type="hidden" value="<?= $total < min_money ? $total + shipping_fee : $total ?>" name="total_momo">
                    <input style="max-width: 50%; margin-left: 25%;" type="submit" name="momo" value="Thanh toán MOMO ATM" class="btn btn-danger btn-momo">
                </form>
            </div>
        </div>
    </div>
<?php else : ?>
    <section style="text-align: center; font-size: 30px;">
        <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-cart-3428238-2902697.png" alt="" />
        <h3 class="text-center my-5">Không có sản phẩm để đặt hàng</h3>
    </section>
<?php endif; ?>