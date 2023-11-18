<?php
$query  = "select * from member where username='" . $_SESSION['member'] . "'";
$member = mysqli_fetch_array($connect->query($query));
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
    $query = "insert orders (order_method_id, member_id, receiver, address, phone, email, note) values ($order_method_id, $memberId, '$name', '$address', $phone, '$email', '$note')";
    $connect->query($query);
    $query = "select id from orders order by id desc limit 1";
    $orderId = mysqli_fetch_array($connect->query($query))['id'];
    foreach ($_SESSION['cart'] as $key => $value) {
        $productId = $key;
        $number = $value;
        $query = "select price from products where id = $key";
        $price = mysqli_fetch_array($connect->query($query))['price'];
        $query = "insert order_detail values ($productId, $orderId, $number, $price)";
        $connect->query($query);
    }
    unset($_SESSION['cart']);
    header("location: ?option=order_success");
}
?>

<h1>Đặt hàng</h1>

<section>
    <form method="post">
        <h2>Thông tin người nhận hàng</h2>
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
                <textarea name="address" rows="3"><?= $member['address'] ?></textarea>
            </section>
            <section>
                <label>Email: </label>
                <input name="email" type="email" value="<?= $member['email'] ?>">
            </section>
            <section>
                <label>Note: </label>
                <textarea name="note" rows="3"></textarea>
            </section>
        </section>
        <h2>Hình thức thanh toán</h2>
        <?php
        $query = "select * from order_methods where status";
        $result = $connect->query($query);
        ?>
        <select name="order_methods">
            <?php foreach ($result as $item) : ?>
            <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
            <?php endforeach ?>
        </select>
        <section>
            <input type="submit" value="Đặt hàng" name="order_btn" style="margin-top: 20px">
        </section>
        <section>
            <input type="submit" value="Thanh toán bằng Onepay" name="order_btn" style="margin-top: 20px">
        </section>
    </form>
</section>