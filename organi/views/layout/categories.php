<?php
$query = "select * from `categories`";
$result = $connect->query($query);
?>
<!-- Hero Section Begin -->
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Danh mục sách</span>
                    </div>
                    <ul>
                        <?php foreach ($result as $item) : ?>
                            <li class='list-category'><a href="?option=show_products&cat_id=<?= $item['id'] ?>"><?= $item['name'] ?></a></li>
                        <?php endforeach; ?>
                        <li class='list-category'><a href="?option=show_products">Tất Cả</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form>
                            <div class="hero__search__categories">
                                Finding books
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="hidden" name="option" value="show_products">
                            <input type="search" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                            <button type="submit" class="site-btn">TÌM KIẾM</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+84 11.188.888</h5>
                            <span>hỗ trợ 24/7</span>
                        </div>
                    </div>
                </div>
                <div class="hero__item set-bg" data-setbg="../images/banner.webp" style="animation-name: fadeInUp; animation-duration: 1s">
                    <!-- <div class="hero__text">
                            <span>SÁCH MỚI</span>
                            <h2>Cho mùa hè thêm xanh</h2>
                            <p>Những cuốn sách hay cho mùa hè</p>
                            <a href="#" class="primary-btn">Mua ngay</a>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->