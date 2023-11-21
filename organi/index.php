<?php
$connect = new MySQLi('localhost', 'root', '', 'starbook_databse', 3310);
CONST min_money = 200000;
CONST shipping_fee = 30000;
?>
<?php
ob_start();
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zxx">
<?php
if (isset($_SESSION['member'])) {
    $query  = "select * from `member` where `username`='" . $_SESSION['member'] . "'";
    $member = mysqli_fetch_array($connect->query($query));
    $query = "select `id` from `orders` order by id desc limit 1";
    $orderId = mysqli_fetch_array($connect->query($query))['id'];
    $queryCart = " select * from `cart` where `member_id` = " . $member['id'];
    $resultQueryCart = $connect->query($queryCart);
    $total_paypal = 0.0;
    foreach ($resultQueryCart as $item) {
        $productId = $item['product_id'];
        $number = $item['quantity'];
        $price = $item['product_price'];
        $query = "insert `order_detail` values ($productId, $orderId, $number, $price)";
        $connect->query($query);
        $total_paypal += $item['product_price'] * $item['quantity'];
    }
    if ($total_paypal < min_money) {
        $total_paypal += shipping_fee;
    }
    $total_paypal = number_format($total_paypal / 24000, 2);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Star Book</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css" />
    <link rel="stylesheet" href="css/nice-select.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css" />
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/wishlist.css" type="text/css" />
    <link rel='stylesheet' href='css/animate.min.css' type='text/css' />
</head>

<body>
    <section><?php include "views/layout/header.php"; ?></section>
    <section><?php include("views/layout/main.php"); ?> </section>
    <section><?php include "views/layout/footer.php"; ?></section>

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="../public/ckeditor5/ckeditor.js"></script>


    <!---------Tích hợp thanh toán paypal-------------------->
    <script src="https://www.paypal.com/sdk/js?client-id=AVYk5egfKaRv3HGriaCdV2lJyLXHHS-UEucTmFzCIY4LP6QWxFHRjnY_B2CgqgeCXYBjwp-LLCjMrfK9&currency=USD"></script>
    <script>
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'blue',
                shape: 'rect',
                label: 'paypal'
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?= number_format($total_paypal, 2, '.', '') ?>,
                            currency: 'USD'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nSee console for details');
                    window.location.replace('http://localhost/project-php/organi/?option=order_success&method=paypal')
                });
            },
            onCancel: function(data) {
                window.location.replace('http://localhost/project-php/organi/?option=order');
            }
        }).render('#paypal-button-container');
    </script>
</body>

</html>
<?php
ob_end_flush()
?>
<script>
    ClassicEditor
        .create(document.querySelector('#contact'))
        .catch(error => {
            console.error(error);
        });
</script>