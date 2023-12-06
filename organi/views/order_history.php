<?php
if (isset($_SESSION['member'])) {
    $query  = "select * from `member` where `username`='" . $_SESSION['member'] . "'";
    $member = mysqli_fetch_array($connect->query($query));
    $queryOrders = " select * from `orders` where `member_id` = " . $member['id']  . " order by `id` DESC";
    $resultQueryOrders = $connect->query($queryOrders);
    if (isset($_GET['id'])) {
        $connect->query("update orders set status = 4 where id = " . $_GET['id']);
        header ("location: ?option=order_history");
    }
} else {
    header("location: ?option=signin");
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
                <div style="display: flex; gap: 30px">
                    <div>Phương thức thanh toán: <?= $item['order_method_id'] == 1 ? "Thanh toán khi nhận hàng" : ($item['order_method_id'] == 5 ? "VNPAY" : ($item['order_method_id'] == 4 ? "Paypal" : "Phương thức khác")) ?></div>
                    <div>Trạng thái: <?= $item['status'] == 1 ? "Chưa xử lý" : ($item['status'] == 2 ? "Đang xử lý" : ($item['status'] == 3 ? "Đã xử lý" : "Hủy")) ?></div>
                </div>

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
                <?php if ($item['status'] == 1) : ?>
                    <span class="btn btn-danger" onclick="if(confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) location='?option=order_history&id=<?= $item['id'] ?>';">Hủy đơn hàng</span>
                <?php endif; ?>
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