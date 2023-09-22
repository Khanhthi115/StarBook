<?php
$query = "select * from products where status = 1";
$result = $connect->query($query);
?>
<section class="products">
    <?php foreach ($result as $item) : ?>
        <section class="product">
            <section class="pro_img"><a href="?option=detail_product&id=<?=$item['id']?>"><img src="images/<?= $item['image'] ?>"></a></section>
            <section class="pro_name"><?= $item['name'] ?></section>
            <section class="pro_name"><?= number_format($item['price'],0,',','.') ?>đ</section>
            <section class="pro_name"><input type="submit" value="Đặt mua"></section>
        </section>
    <?php endforeach; ?>
</section>