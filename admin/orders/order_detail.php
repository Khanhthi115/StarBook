<?php
if (isset($_GET['action'])) {
    $condition = "orderId = " . $_GET['id'] . " and productId = " . $_GET['product_id'];
    if ($_GET['type'] == 'asc') {
        $connect->query("update `products` set `product_quantity` = `product_quantity` - 1 where `id` = " . $_GET['product_id']);
        $query = "update order_detail set quantity = quantity + 1
        where $condition";
    } else {
        $connect->query("update `products` set `product_quantity` = `product_quantity` + 1 where `id` = " . $_GET['product_id']);
        $query = "update order_detail set quantity = quantity - 1
        where $condition";
    }
    $connect->query($query);
    header("Location: ?option=order_detail&id=" . $_GET['id']);
}
if (isset($_POST['status'])) {
    $connect->query("update orders set status=" . $_POST['status'] . " where id=" . $_GET['id']);
    header("Refresh: 0");
}
?>
<?php
$query = "select a.fullname, a.phonenumber as 'member_phone', a.address as 'member_address', a.email  as 'member_email',
    b.*, c.name as 'order_method_name' from member a join orders b on a.id = b.member_id
    join order_methods c on b.order_method_id = c.id
    where b.id = " . $_GET['id'];
$order = mysqli_fetch_array($connect->query($query));

?>

<h2>CHI TIẾT ĐƠN HÀNG<br/>(Mã đơn hàng: <?= $order['id'] ?>)</h2>
<p>Ngày tạo đơn: <?= $order['order_date'] ?></p>
<h4>Thông tin người đặt hàng: </h4>
<table class="table table-bordered">
    <tbody>
        <tr>
            <td>Họ tên</td>
            <td><?= $order['fullname'] ?></td>
        </tr>
        <tr>
            <td>Điện thoại</td>
            <td><?= $order['member_phone'] ?></td>
        </tr>
        <tr>
            <td>Địa chỉ</td>
            <td><?= $order['member_address'] ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?= $order['member_email'] ?></td>
        </tr>
        <tr>
            <td>Note</td>
            <td><?= $order['note'] ?></td>
        </tr>
    </tbody>
</table>
<h4>Thông tin người nhận hàng: </h4>
<table class="table table-bordered">
    <tbody>
        <tr>
            <td>Họ tên</td>
            <td><?= $order['receiver'] ?></td>
        </tr>
        <tr>
            <td>Điện thoại</td>
            <td><?= $order['phone'] ?></td>
        </tr>
        <tr>
            <td>Địa chỉ</td>
            <td><?= $order['address'] ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?= $order['email'] ?></td>
        </tr>
    </tbody>
</table>
<h4>Phương thức thanh toán</h4>
<section><?= $order['order_method_name'] ?></section>
<?php
$query = "select a.status, b.*, c.name, c.image 
    from orders a join order_detail b on a.id = b.orderId 
    join products c on b.productId = c.id 
    where a.id = " . $order['id'];
$order_detail = $connect->query($query);
?>
<br/>
<form method="post">
    <h4>Các sản phẩm đặt mua</h4>
    <?php $count = 1; ?>
    <table class="table table-bordered" style="text-align: center">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Ảnh</th>
                <th>Giá (VND)</th>
                <th>Số lượng</th>
            </tr>
        </thead>
        <?php foreach ($order_detail as $item) : ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= $item['name'] ?></td>
                <td><img width="100px" src="../images/<?= $item['image'] ?>"></td>
                <td><?= number_format($item['price'], 0, ',', '.') ?></td>
                <td>
                    <input <?= $order['status'] == 3 || $order['status'] == 4 ? 'disabled' : '' ?> <?= $item['quantity'] == 1 ? 'disabled' : '' ?> type="button" value="-" onclick="if (confirm('Bạn có chắc muốn giảm số lượng sản phẩm cho đơn hàng này?')) location='?option=order_detail&id=<?= $_GET['id'] ?>&action=update&type=dec&order_id=<?= $item['orderId'] ?>&product_id=<?= $item['productId'] ?>';">
                    <?= $item['quantity'] ?>
                    <input <?= $order['status'] == 3 || $order['status'] == 4 ? 'disabled' : '' ?> type="button" value="+" onclick="if (confirm('Bạn có chắc muốn tăng số lượng sản phẩm cho đơn hàng này')) location='?option=order_detail&id=<?= $_GET['id'] ?>&action=update&type=asc&order_id=<?= $item['orderId'] ?>&product_id=<?= $item['productId'] ?>';">
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h4>TRẠNG THÁI ĐƠN HÀNG</h4>
    <p style="display: <?= $order['status'] == 2 || $order['status'] == 3 || $order['status'] == 4 ? 'none' : 'block' ?>">
        <input type="radio" name="status" value="1" <?= $order['status'] == 1 ? 'checked' : '' ?>> Chưa xử lý
    </p>
    <p style="display: <?= $order['status'] == 3 || $order['status'] == 4 ? 'none' : 'block' ?>">
        <input type="radio" name="status" value="2" <?= $order['status'] == 2 ? 'checked' : '' ?>> Đang xử lý
    </p>
    <p style="display: <?= $order['status'] == 4 ? 'none' : 'block' ?>">
        <input type="radio" name="status" value="3" <?= $order['status'] == 3 ? 'checked' : '' ?>> Đã xử lý
    </p>
    <p>
        <input type="radio" name="status" value="4" <?= $order['status'] == 4 ? 'checked' : '' ?>> Hủy
    </p>
    <section>
        <input <?= $order['status'] == 3 || $order['status'] == 4 ? 'disabled' : '' ?> type="submit" value="Update đơn hàng" class="btn btn-success">
        <a href="?option=order&status=1" class="btn btn-outline-secondary">Back</a>
    </section>
</form>