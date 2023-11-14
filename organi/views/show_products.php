<?php
$option = 'show_products';
$query = "select products.*, authors.id as 'author_id', authors.name as 'author_name' from products join authors on products.author_id = authors.id where products.status = 1";
// search by authors
if (isset($_GET['authorId'])) {
    $query .= " and author_id=" . $_GET['authorId'];
    $option = 'show_products&authorId=' . $_GET['authorId'];
}

if (isset($_GET['cat_id'])) {
    $query .= " and cat_id=" . $_GET['cat_id'];
    $option = 'show_products&cat_id=' . $_GET['cat_id'];
}
// search by keyword
elseif (isset($_GET['keyword'])) {
    $keyword = htmlspecialchars($_GET['keyword']);
    $query .= " and (products.name like '%" . $keyword . "%' or authors.name like '%" . $keyword . "%')";
    $option = 'show_products&keyword=' . $_GET['keyword'];
}
// search by range of price
if (isset($_GET['range'])) {
    $query .= " and price <= " . $_GET['range'];
    // $option = 'show_products&range=' . $_GET['range'];
}

// sort by price, name
if (isset($_GET['sort'])) {
    $query .= " order by " . $_GET['sort'];
    $option = 'show_products&sort=' . $_GET['sort'];
}

// watch products in page ?
$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

// number of products in one page
$product_per_page = 12;

// take products from index ? (0 means take from the first page)
$from = ($page - 1) * $product_per_page;

// count number of pages
$total_products = $connect->query($query);
if ($total_products)
    $total_pages = ceil(mysqli_num_rows($total_products) / $product_per_page);

// take products from current page
if (!isset($_GET['sort'])) {
    $query .= " ORDER BY RAND() limit $from, $product_per_page";
    $result = $connect->query($query);
    $number = mysqli_num_rows($result);
} else {
    $query .= " limit $from, $product_per_page";
    $result = $connect->query($query);
    $number = mysqli_num_rows($result);
}
?>

<?php
$query = "select * from categories";
$result_categories = $connect->query($query);
?>

<?php
$query_latest = "select * from products where status = 1 order by id desc limit 6";
$result_latest = $connect->query($query_latest);
$evenProducts = [];
$oddProducts = [];

while ($row = $result_latest->fetch_assoc()) {
    if ($row['id'] % 2 == 0) {
        $evenProducts[] = $row;
    } else {
        $oddProducts[] = $row;
    }
}
?>

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="../images/background_show_products.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Star Book</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.php">Home</a>
                        <span>Tìm kiếm sách</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5" style="animation-name: fadeIn; animation-duration: 2s">
                <div class="sidebar">
                    <div class="sidebar__item">
                        <h4>Danh Mục Sách</h4>
                        <ul>
                            <?php foreach ($result_categories as $item) : ?>
                                <li class="left-list-category"><a href="?option=show_products&cat_id=<?= $item['id'] ?>"><?= $item['name'] ?></a></li>
                            <?php endforeach; ?>
                            <li><a href="?option=show_products">Tất cả</li>
                        </ul>
                    </div>
                    <div class="sidebar__item">
                        <h4>Lọc theo giá</h4>
                        <div class="price-range-wrap">
                            <section>
                                <form>
                                    <input type="hidden" name="option" value="show_products">
                                    <div class="sidebar__item__size">
                                        <label for="btn-100000">
                                            <= 100.000 <input type="submit" name="range" value="100000" id="btn-100000">
                                        </label>
                                    </div>
                                    <div class="sidebar__item__size">
                                        <label for="btn-200000">
                                            <= 200.000 <input type="submit" name="range" value="200000" id="btn-200000">
                                        </label>
                                    </div>
                                    <div class="sidebar__item__size">
                                        <label for="btn-300000">
                                            <= 300.000 <input type="submit" name="range" value="300000" id="btn-300000">
                                        </label>
                                    </div>
                                    <div class="sidebar__item__size">
                                        <label for="btn-400000">
                                            <= 400.000 <input type="submit" name="range" value="400000" id="btn-400000">
                                        </label>
                                    </div>

                                </form>
                            </section>
                        </div>
                    </div>
                    <div class="sidebar__item">
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
                </div>
            </div>

            <div class="col-lg-9 col-md-7">
                <!-- Hero Section Begin -->
                <section class="hero hero-normal">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="hero__search">
                                    <div class="hero__search__form">
                                        <form>
                                            <div class="hero__search__categories">
                                                ALL BOOKS
                                                <span class="arrow_carrot-down"></span>
                                            </div>
                                            <input type="hidden" name="option" value="show_products">
                                            <input type="search" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                                            <button type="submit" class="site-btn">Tìm Kiếm</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Hero Section End -->
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sắp xếp theo</span>
                                <select onchange="redirectToPage(this)">
                                    <option value="0" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'name') echo 'selected'; ?>>Tên Sách</option>
                                    <option value="1" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'price') echo 'selected'; ?>>Giá Sách</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6><span>Các sản phẩm tìm được</h6>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                <span class="icon_grid-2x2"></span>
                                <span class="icon_ul"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"  style="animation-name: fadeIn; animation-duration: 2s">
                    <?php if ($number > 0) : ?>
                        <?php foreach ($result as $item) : ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="../images/<?= $item['image'] ?>">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="?option=wishlist&action=add&id=<?= $item['id'] ?>"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="?option=cart&action=add&id=<?= $item['id'] ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="?option=detail_product&id=<?= $item['id'] ?>"><?= $item['name'] ?></a></h6>
                                        <h5><?= number_format($item['price'], 0, ',', '.') ?>đ</h5>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p style="color: red">Không tìm thấy sản phẩm</p>
                    <?php endif; ?>
                </div>
                <div class="product__pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <a class="<?= (isset($_GET['page']) && $_GET['page'] == $i) || (empty($_GET['page']) && $i == 1) ? 'hightlight' : '' ?>" href="?option=<?= $option ?>&page=<?= $i ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
<script>
    function redirectToPage(selectElement) {
        var selectedOption = selectElement.value;
        var sortParam = "";

        if (selectedOption === "0") {
            sortParam = "name";
        } else if (selectedOption === "1") {
            sortParam = "price";
        }

        var url = "&sort=" + sortParam;
        window.location.href += url;
    }

    function addRangeParam(range) {
        // Redirect to the new URL
        window.location.href += "&range=" + range;
    }
    var btn100 = document.getElementById("btn-100000");
    btn100.addEventListener("click", function(e) {
        e.preventDefault();
        addRangeParam('100000');
    });
    var btn200 = document.getElementById("btn-200000");
    btn200.addEventListener("click", function(e) {
        e.preventDefault();
        addRangeParam('200000');
    });
    var btn300 = document.getElementById("btn-300000");
    btn300.addEventListener("click", function(e) {
        e.preventDefault();
        addRangeParam('300000');
    });
    var btn400 = document.getElementById("btn-400000");
    btn400.addEventListener("click", function(e) {
        e.preventDefault();
        addRangeParam('400000');
    });
</script>