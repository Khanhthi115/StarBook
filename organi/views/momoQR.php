<?php
if (isset($_SESSION['member'])) {
    $query  = "select * from `member` where `username`='" . $_SESSION['member'] . "'";
    $member = mysqli_fetch_array($connect->query($query));
    $query = "select `id` from `orders` order by id desc limit 1";
    $orderId = mysqli_fetch_array($connect->query($query))['id'];
    $queryCart = " select * from `cart` where `member_id` = " . $member['id'];
    $resultQueryCart = $connect->query($queryCart);
    $total1 = 0.0;
    foreach ($resultQueryCart as $item) {
        $productId = $item['product_id'];
        $number = $item['quantity'];
        $price = $item['product_price'];
        $query = "insert `order_detail` values ($productId, $orderId, $number, $price)";
        $connect->query($query);
        $total1 += $item['product_price'] * $item['quantity'];
    }
    if ($total1 < 200000) {
        $total1 += 30000;
    }
}
if (!function_exists('curl_init')) {
    die('Phần mở rộng cURL không được cài đặt/hoạt động.');
}

header('Content-type: text/html; charset=utf-8');

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $result = curl_exec($ch);

    
    if (curl_errno($ch)) {
        die('Lỗi cURL: ' . curl_errno($ch) . ' - ' . curl_error($ch));
    }
    
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo 'Mã trạng thái HTTP: ' . $http_status;

    curl_close($ch);
    return $result;
}

$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

$orderInfo = "Thanh toán qua MoMo QRcode";
$amount = strval($total1);
$orderId = time();
$requestId = time();
$redirectUrl = "http://localhost/starbook/organi/index.php?option=order_success";
$ipnUrl = "http://localhost/starbook/organi/index.php?option=order_success";
$extraData = "";

$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . 
    "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=captureWallet";

$signature = hash_hmac("sha256", $rawHash, $secretKey);

$data = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    "storeId" => "MomoTestStore",
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'lang' => 'vi',
    'extraData' => $extraData,
    'requestType' => 'captureWallet',
    'signature' => $signature
);

$result = execPostRequest($endpoint, json_encode($data));
$jsonResult = json_decode($result, true);

// Kiểm tra lỗi hoặc xử lý phản hồi theo cách phù hợp

header('Location: ' . $jsonResult['payUrl']);
?>
