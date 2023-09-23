<?php
$option = 'home';
$query = "select * from products where status = 1";
// search by authors
if (isset($_GET['authorId'])) {
    $query .= " and author_id=" . $_GET['authorId'];
    $option = 'show_products&authorId='.$_GET['authorId'];
}
// search by keyword
elseif (isset($_GET['keyword'])) {
    $query .= " and name like '%" . $_GET['keyword'] . "%'";
    $option = 'show_products&keyword='.$_GET['keyword'];
}
// search by range of price
elseif (isset($_GET['range'])) {
    $query .= " and price <= " . $_GET['range'];
    $option = 'show_products&range='.$_GET['range'];
}

// watch products in page ?
$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

// number of products in one page
$product_per_page = 2;

// take products from index ? (0 means take from the first page)
$from = ($page - 1)*$product_per_page;

// count number of pages
$total_products = $connect->query($query);
if ($total_products)
$total_pages = ceil(mysqli_num_rows($total_products) / $product_per_page);

// take products from current page
$query.=" limit $from, $product_per_page";
$result = $connect->query($query);
?>

<section class="products">
    <?php foreach ($result as $item) : ?>
        <section class="product">
            <section class="pro_img"><a href="?option=detail_product&id=<?= $item['id'] ?>"><img src="images/<?= $item['image'] ?>"></a></section>
            <section class="pro_name"><?= $item['name'] ?></section>
            <section class="pro_name"><?= number_format($item['price'], 0, ',', '.') ?>đ</section>
            <section class="pro_name"><input type="submit" value="Đặt mua" onclick="location='?option=cart&action=add&id=<?=$item['id']?>';"></section>
        </section>
    <?php endforeach; ?>
</section>
<section class="pages">
    <?php for ($i = 1; $i <= $total_pages ; $i++):?>
        <a class="<?=(isset($_GET['page']) && $_GET['page']==$i) ||(empty($_GET['page'])&&$i==1)?'hightlight':''?>" href="?option=<?=$option?>&page=<?=$i?>"><?=$i?></a>
    <?php endfor;?>
</section>