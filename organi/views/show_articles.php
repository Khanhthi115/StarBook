<?php
$option = 'show_articles';
$queryArticles = "select * from `articles` where `status` = 1";

// search by keyword
if (isset($_GET['article_cat'])) {
    $cat_id = $_GET['article_cat'];
    $queryArticles .= " and article_cat_id = " . $cat_id;
    $option = 'show_articles&article_cat=' . $cat_id;
}

// watch products in page ?
$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

// number of products in one page
$articles_per_page = 8;

// take products from index ? (0 means take from the first page)
$from = ($page - 1) * $articles_per_page;

// count number of pages
$total_articles = $connect->query($queryArticles);
if ($total_articles)
    $total_pages = ceil(mysqli_num_rows($total_articles) / $articles_per_page);

// take products from current page
$queryArticles .= " limit $from, $articles_per_page";
$resultArticles = $connect->query($queryArticles);
$numberArticles = mysqli_num_rows($resultArticles);
?>

<!-- Product Section Begin -->
<section class="show-articles-container">
    <div style="margin: 20px auto" class="container">
        <div class="col-lg-12 col-md-7">
            <div class="row" style="animation-name: fadeInUp; animation-duration: 2s">
                <?php if ($numberArticles > 0) : ?>
                    <?php foreach ($resultArticles as $item) : ?>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="../images/<?= $item['image'] ?>">
                                </div>
                                <div class="product__item__text">
                                    <h6><b><a href="?option=article_detail&id=<?= $item['id'] ?>"><?= $item['name'] ?></a></b></h6>
                                    <p style="height: 50px; overflow: hidden"><?= $item['summary'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p style="color: red">Không tìm thấy sản phẩm</p>
                <?php endif; ?>
            </div>
            <div class="product__pagination" style="text-align: center">
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <a class="<?= (isset($_GET['page']) && $_GET['page'] == $i) || (empty($_GET['page']) && $i == 1) ? 'hightlight' : '' ?>" href="?option=<?= $option ?>&page=<?= $i ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->