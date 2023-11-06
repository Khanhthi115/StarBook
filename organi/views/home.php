<?php
$queryAuthors = "select * from authors where status = 1 and image != ''";
$resultAuthors = $connect->query($queryAuthors);
?>
<?php include("views/layout/categories.php"); ?>
<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                <?php foreach ($resultAuthors as $item) : ?>
                    <a href="?option=show_products&authorId=<?= $item['id'] ?>">
                        <div class="list-author">
                            <img src="../images/authors/<?= $item['image'] ?>" alt="" />
                            <h5><?= $item['name'] ?></h5>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<?php include("views/layout/featured_products.php"); ?>

<?php include("views/layout/banner_bonus.php"); ?>

<?php include("views/layout/latest_product.php"); ?>

<?php include("views/layout/blog.php"); ?>