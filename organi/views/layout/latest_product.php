<?php
$query = "select * from products where status = 1 order by id desc limit 6";
$result = $connect->query($query);
$evenProducts = [];
$oddProducts = [];

while ($row = $result->fetch_assoc()) {
    if ($row['id'] % 2 == 0) {
        $evenProducts[] = $row;
    } else {
        $oddProducts[] = $row;
    }
}

$queryNNA = "select
            products.name as 'name',
            products.image,
            products.price,
            products.author_id,
            authors.id,
            products.id
            from products inner join authors 
            on products.author_id = authors.id 
            where authors.name = 'Nguyễn Nhật Ánh'
            limit 6";
$resultNNA = $connect->query($queryNNA);
$evenProductsNNA = [];
$oddProductsNNA = [];
while ($row = $resultNNA->fetch_assoc()) {
    if ($row['id'] % 2 == 0) {
        $evenProductsNNA[] = $row;
    } else {
        $oddProductsNNA[] = $row;
    }
}

$queryNPV = "select
products.name as 'name',
products.image,
products.price,
products.cat_id,
categories.id,
products.id
from products inner join categories 
on products.cat_id = categories.id 
where categories.id = 6
limit 6";
$resultNPV = $connect->query($queryNPV);
$evenProductsNPV = [];
$oddProductsNPV = [];

while ($row2 = $resultNPV->fetch_assoc()) {
    if ($row2['id'] % 2 == 0) {
        $evenProductsNPV[] = $row2;
    } else {
        $oddProductsNPV[] = $row2;
    }
}

?>
<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Sách Mới</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <?php foreach ($evenProducts as $item) : ?>
                                <a href="?option=detail_product&id=<?= $item['id'] ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="../images/<?= $item['image'] ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?= $item['name'] ?></h6>
                                        <span><?= number_format($item['price']) ?>đ</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <div class="latest-prdouct__slider__item">
                            <?php foreach ($oddProducts as $item) : ?>
                                <a href="?option=detail_product&id=<?= $item['id'] ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="../images/<?= $item['image'] ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?= $item['name'] ?></h6>
                                        <span><?= number_format($item['price']) ?>đ</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Nguyễn Nhật Ánh</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <?php foreach ($evenProductsNNA as $item) : ?>
                                <a href="?option=detail_product&id=<?= $item['id'] ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="../images/<?= $item['image'] ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?= $item['name'] ?></h6>
                                        <span><?= number_format($item['price']) ?>đ</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <div class="latest-prdouct__slider__item">
                            <?php foreach ($oddProductsNNA as $item) : ?>
                                <a href="?option=detail_product&id=<?= $item['id'] ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="../images/<?= $item['image'] ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?= $item['name'] ?></h6>
                                        <span><?= number_format($item['price']) ?>đ</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Nguyen Phong Viet</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <?php foreach ($evenProductsNPV as $item) : ?>
                                <a href="?option=detail_product&id=<?= $item['id'] ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="../images/<?= $item['image'] ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?= $item['name'] ?></h6>
                                        <span><?= number_format($item['price']) ?>đ</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <div class="latest-prdouct__slider__item">
                            <?php foreach ($oddProductsNPV as $item) : ?>
                                <a href="?option=detail_product&id=<?= $item['id'] ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="../images/<?= $item['image'] ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?= $item['name'] ?></h6>
                                        <span><?= number_format($item['price']) ?>đ</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Trinh thám hot</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <?php foreach ($evenProductsNPV as $item) : ?>
                                <a href="?option=detail_product&id=<?= $item['id'] ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="../images/<?= $item['image'] ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?= $item['name'] ?></h6>
                                        <span><?= number_format($item['price']) ?>đ</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <div class="latest-prdouct__slider__item">
                            <?php foreach ($oddProductsNPV as $item) : ?>
                                <a href="?option=detail_product&id=<?= $item['id'] ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="../images/<?= $item['image'] ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?= $item['name'] ?></h6>
                                        <span><?= number_format($item['price']) ?>đ</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest Product Section End -->