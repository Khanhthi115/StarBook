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
$query = "select a.status, b.quantity, b.price, c.name, c.image 
    from orders a join order_detail b on a.id = b.orderId 
    join products c on b.productId = c.id 
    where a.id = " . $order['id'];
$order_detail = $connect->query($query);
?>
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
            <td><?=$count++?></td>
            <td><?=$item['name']?></td>
            <td><img width="100px" src="../images/<?=$item['image']?>"></td>
            <td><?=number_format($item['price'], 0, ',', '.')?></td>
            <td><?=$item['quantity']?></td>
        </tr>
    <?php endforeach; ?>
</table>