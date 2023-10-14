<?php
if (isset($_POST['content'])) {
    $content = $_POST['content'];
    $productId = $_GET['id'];
    // when user have signed in and comment
    if (isset($_SESSION['member'])) {
        $date = time();
        $memberId = mysqli_fetch_array($connect->query("select * from member where username='" . $_SESSION['member'] . "'"));
        $memberId = $memberId['id'];
        $connect->query("insert comments (memberId, productId, date, content) values ($memberId, $productId, now(), '$content')");
        echo "<script>alert('Bình luận đã được gửi đi và sẽ sớm xuất hiện!')</script>";
    } else {
        // when user have not signed in and comment
        $_SESSION['content'] = $content;
        echo "
        <script>
            alert('Đăng nhập để thực hiện chức năng này!');
            location='?option=signin&product_id=$productId';
        </script>";
    }
}
?>
<?php
$id = $_GET['id'];
$query = "select * from products where id = $id";
$result = $connect->query($query);
$item = mysqli_fetch_array($result);

$id_author = $item['author_id'];
$queryAuthor = "select * from authors where id = $id_author";
$resultAuthor = $connect->query($queryAuthor);
$itemAuthor = mysqli_fetch_array($resultAuthor);
?>

<!-- Product Details Section Begin -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        <img class="product__details__pic__item--large" src="../images/<?= $item['image'] ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product__details__text">
                    <h3><?= $item['name'] ?></h3>
                    <div class="product__details__price"><?= number_format($item['price'], 0, ",", ".") ?>đ</div>
                    <!-- <div class="product__details__quantity">
                        <div class="quantity">
                            <div class="pro-qty">
                                <input type="text" value="1">
                            </div>
                        </div>
                    </div> -->
                    <a href="?option=cart&action=add&id=<?= $item['id'] ?>" class="primary-btn">Thêm vào giỏ hàng</a>
                    <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                    <ul>
                        <li><b>Tình Trạng</b> <span>Còn hàng</span></li>
                        <li><b>Giao hàng</b> <span>3 - 5 ngày trên toàn quốc</span></li>
                        <li><b>Tác giả</b> <a href="?option=show_products&authorId=<?= $itemAuthor['id'] ?>"><span><?= $itemAuthor['name'] ?></span></a></li>
                        <li><b>Share on</b>
                            <div class="share">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Mô tả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Bình luận</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Mô tả sản phẩm</h6>
                                <p><?= $item['description'] ?></p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Bình luận về sản phẩm</h6>
                                <section>
                                    <?php
                                    $comment = $connect->query("select * from member a join comments b on a.id = b.memberId join products c on b.productId = c.id where b.status = 0 and productId = " . $_GET['id']);
                                    if (mysqli_num_rows($comment) == 0) :
                                        echo "<section>Chưa có bình luận nào</section>";
                                    else :
                                        foreach ($comment as $item) :
                                    ?>
                                            <div style="display: flex; align-items: center; ">
                                                <b>
                                                    <section><?= $item['username'] ?></section>
                                                </b>
                                                <section style="padding-left: 20px; display: flex; align-items: center;">
                                                    <p style="padding: 5px; margin-top: 20px; border-radius: 5px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;"><?= $item['content'] ?></p>
                                                </section>
                                            </div>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                    <form method="post">
                                        <section style="margin: 20px 0;">
                                            <textarea name="content" style="width: 100%" row="5" class="form-control" placeholder="Nhập bình luận tại đây ..."></textarea>
                                        </section>
                                        <section>
                                            <input type="submit" value="Gửi" class="btn btn-primary px-5">
                                        </section>
                                    </form>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Details Section End -->

<!-- Related Product Section Begin -->
<section class="related-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related__product__title">
                    <h2>Related Product</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="../images/<?= $item['image'] ?>">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Crab Pool Security</a></h6>
                        <h5>$30.00</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="img/product/product-2.jpg">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Crab Pool Security</a></h6>
                        <h5>$30.00</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="img/product/product-3.jpg">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Crab Pool Security</a></h6>
                        <h5>$30.00</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="img/product/product-7.jpg">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Crab Pool Security</a></h6>
                        <h5>$30.00</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Related Product Section End -->