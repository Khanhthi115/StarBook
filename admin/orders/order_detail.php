<?php
if (isset($_GET['action'])) {
    $condition = "orderId = " . $_GET['id'] . " and productId = " . $_GET['product_id'];
    if ($_GET['type'] == 'asc') {
        $query = "update order_detail set quantity = quantity + 1
        where $condition";
    } else {
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

<h1>CHI TIẾT ĐƠN HÀNG<br>(Mã đơn hàng: <?= $order['id'] ?>)</h1>
<h2>NGÀY TẠO ĐƠN</h2>
<section><?= $order['order_date'] ?></section>
<h2>Thông tin người đặt hàng: </h2>
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
<h2>Thông tin người nhận hàng: </h2>
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
<h2>PHƯƠNG THỨC THANH TOÁN</h2>
<section><?= $order['order_method_name'] ?></section>
<?php
$query = "select a.status, b.*, c.name, c.image 
    from orders a join order_detail b on a.id = b.orderId 
    join products c on b.productId = c.id 
    where a.id = " . $order['id'];
$order_detail = $connect->query($query);
?>
<form method="post">
    <h2>CÁC SẢN PHẨM ĐẶT MUA</h2>
    <?php $count = 1; ?>
    <table class="table table-bordered">
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
                    <input <?= $item['quantity'] == 1 ? 'disabled' : '' ?> type="button" value="-" onclick="location='?option=order_detail&id=<?= $_GET['id'] ?>&action=update&type=dec&order_id=<?= $item['orderId'] ?>&product_id=<?= $item['productId'] ?>';">
                    <?= $item['quantity'] ?>
                    <input type="button" value="+" onclick="location='?option=order_detail&id=<?= $_GET['id'] ?>&action=update&type=asc&order_id=<?= $item['orderId'] ?>&product_id=<?= $item['productId'] ?>';">
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h2>TRẠNG THÁI ĐƠN HÀNG</h2>
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