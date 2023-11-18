<?php
$query  = "select * from `member` where `username`='" . $_SESSION['member'] . "'";
$member = mysqli_fetch_array($connect->query($query));
$queryOrders = " select * from `orders` where `member_id` = " . $member['id'];
$resultQueryOrders = $connect->query($queryOrders);
if ($resultQueryOrders) {
    // Truy vấn thành công, lưu kết quả vào một mảng
    $orders = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }

    // Sử dụng mảng $orders cho các xử lý tiếp theo
    // Ví dụ: lặp qua từng đơn hàng và hiển thị thông tin
    foreach ($orders as $order) {
        echo "Order ID: " . $order['id'] . "<br>";
        // Hiển thị các thông tin khác của đơn hàng
    }
} else {
    // Truy vấn thất bại, xử lý lỗi (ví dụ: hiển thị thông báo lỗi)
    echo "Error executing the query: " . $connect->error;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StarBook</title>
</head>

<body>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="../images/background_show_products.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Lịch sử đơn hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="?option=home">Trang Chủ</a>
                            <span>Lịch sử đơn hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    <div class="order-history-container">
        <?php foreach ($resultQueryOrders as $item) : ?>
            <div class="order-history-child">
                <span style="color: green"><b>Mã đơn hàng: <?= $item['id'] ?></b></span> <br />
                <span>Phương thức thanh toán: <?= $item['order_method_id'] ?><span>
                        <hr />
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
                                <?php
                                // $queryItems = " select * from `order_detail` where `orderId` = " . $item['id'];
                                $queryItems = "select a.name, a.image, b.orderId, b.productId, b.price, b.quantity from products a join 
                        order_detail b on a.id = b.productId where b.orderId = " . $item['id'];
                                $resultQueryItems = ($connect->query($queryItems));
                                ?>
                                <?php foreach ($resultQueryItems as $item1) : ?>
                                    <tr>
                                        <td class="shoping__cart__item">
                                            <span><?= $item1['name'] ?><span>
                                        </td>
                                        <td>
                                            <img width="100px" src="../images/<?= $item1['image'] ?>" alt="">
                                        </td>
                                        <td class="shoping__cart__total">
                                            <span><?= $item1['quantity'] ?><span>
                                        </td>
                                        <td class="shoping__cart__total">
                                            <span><?= $item1['price'] ?><span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
            </div>
        <?php endforeach; ?>
        <?php if ($resultQueryOrders->num_rows === 0) : ?>
            <h3 class="text-center my-5">Bạn chưa có đơn hàng nào!</h3>
            <div class="text-center mb-5">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-cart-3428238-2902697.png" alt="" />
                <br />
                <a class="btn btn-info" href="?option=show_products">Khám phá ngay tại đây</a>
                <a class="btn btn-success" href="?option=cart">Đi đến giỏ hàng</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>