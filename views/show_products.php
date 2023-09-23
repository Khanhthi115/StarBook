<?php
$query = "select * from products where status = 1";
// search by authors
if (isset($_GET['authorId'])) {
    $query .= " and author_id=" . $_GET['authorId'];
}
// search by keyword
elseif (isset($_GET['keyword'])) {
    $query .= " and name like '%" . $_GET['keyword'] . "%'";
}
// search by range of price
elseif (isset($_GET['range'])) {
    $query .= " and price <= " . $_GET['range'];
}
$result = $connect->query($query);
?>
<section class="products">
    <?php foreach ($result as $item) : ?>
        <section class="product">
            <section class="pro_img"><a href="?option=detail_product&id=<?= $item['id'] ?>"><img src="images/<?= $item['image'] ?>"></a></section>
            <section class="pro_name"><?= $item['name'] ?></section>
            <section class="pro_name"><?= number_format($item['price'], 0, ',', '.') ?>đ</section>
            <section class="pro_name"><input type="submit" value="Đặt mua"></section>
        </section>
    <?php endforeach; ?>
</section>