<?php
$id = $_GET['id'];
$query = "select * from articles where id = $id";
$result = $connect->query($query);
$item = mysqli_fetch_array($result);

$article_cat = $item['article_cat_id'];
$queryCat = "select * from article_categories where id = $article_cat";
$resultCat = $connect->query($queryCat);
$itemCat = mysqli_fetch_array($resultCat);

$queryArticles = "select * from articles where status = 1 order by rand() limit 6";
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