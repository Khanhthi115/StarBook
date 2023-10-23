<?php
$query = "select * from products where status = 1";
$query .= "  ORDER BY RAND() limit 8";
$result = $connect->query($query);
$query_categories = "select * from categories limit 5";
$result_categories = $connect->query($query_categories);
?>
<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Sách hay</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*"><a href="?option=show_products">Tất cả</a></li>
                        <?php foreach ($result_categories as $item) : ?>
                            <li data-filter=".oranges"><a href="?option=show_products&cat_id=<?= $item['id'] ?>"><?= $item['name'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            <?php foreach ($result as $item) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="../images/<?= $item['image'] ?>">
                            <ul class="featured__item__pic__hover">
                                <li><a href="?option=wishlist&action=add&id=<?= $item['id'] ?>"><i class="fa fa-heart"></i></a></li>
                                <li><a href="?option=cart&action=add&id=<?= $item['id'] ?>"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="?option=detail_product&id=<?= $item['id'] ?>"><?= $item['name'] ?></a></h6>
                            <h5><?= number_format($item['price'], 0, ",", ".") ?>đ</h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- Featured Section End -->