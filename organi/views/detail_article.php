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
$query = "select * from articles where id = $id";
$result = $connect->query($query);
$item = mysqli_fetch_array($result);

$article_cat = $item['article_cat_id'];
$queryCat = "select * from article_categories where id = $article_cat";
$resultCat = $connect->query($queryCat);
$itemCat = mysqli_fetch_array($resultCat);

echo $itemCat['id'];
$queryArticles = "select * from articles where status = 1";
$resultArticles = $connect->query($queryArticles);
$numberArticles = mysqli_num_rows($resultArticles);
?>

<!-- Article Details div Begin -->
<div class="article-detail-container">
    <div class="article-detail-main">

        <div class="article-title">
            <h1><?= $item['name'] ?></h1>
        </div>
        <div class="article-audio">
            <audio src="../audios/<?=$item['audio']?>" controls></audio>
        </div>
        <div class="article-create-date">
            Ngày tạo: <i class="fa fa-calendar-o"></i> <?= $item['create_date'] ?>
        </div>
        <div class="article-summary">
            <h4><?= $item['summary'] ?></h4>
        </div>
        <!-- <div class="article-image">
            <img src="../images/<?= $item['image'] ?>" />
        </div> -->
        <div class="article-content">
            <?= $item['content'] ?>
        </div>
        <div class="article-video">
            <?php if ($item['youtube'] != "") { ?>
                <iframe src="https://www.youtube.com/embed/<?= $item['youtube'] ?>"></iframe>
            <?php } ?>
        </div>
    </div>
    <div class="article-relate">
        <h3>Các bài viết khác</h3>
        <?php foreach ($resultArticles as $item) : ?>
            <a href="?option=article_detail&id=<?= $item['id'] ?>">
                <div class="article-relate-item">
                    <img src="../images/<?= $item['image'] ?>" />
                    <div class="articles-relate-intro">
                        <b><?= $item['name'] ?></b><br />
                        <span><?= $item['summary'] ?></span>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Article Details div End -->

<!-- Related Product div Begin -->
<!-- <div class="related-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="div-title related__product__title">
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
</div> -->
<!-- Related Product div End -->