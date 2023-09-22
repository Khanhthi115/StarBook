<?php
$id = $_GET['id'];
$query = "select * from products where id = $id";
$result = $connect->query($query);
$item = mysqli_fetch_array($result);
?>
<h1>Chi tiết snar phẩm</h1>
<section class="product">
    <section class="pro_img"><img src="images/<?= $item['image'] ?>"></section>
    <section class="pro_name"><?= $item['name'] ?></section>
    <section class="pro_name"><?= number_format($item['price'], 0, ',', '.') ?>đ</section>
    <section class="pro_name"><input type="submit" value="Đặt mua"></section>
    <section class="description">
    <?= $item['description'] ?>
    </section>
</section>
<?php
    include ("home.php");
?>