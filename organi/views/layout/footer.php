<?php
$query = "select * from categories limit 7";
$result = $connect->query($query);

$queryAuthors = "select * from authors limit 7";
$resultAuthors = $connect->query($queryAuthors);

$queryArticleCategories = "select * from article_categories limit 7";
$resultArticleCategories = $connect->query($queryArticleCategories);
?>
<!-- Footer Section Begin -->
<footer class="footer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="?option=home"><img style="object-fit: contain; border-radius: 50px;" height="100px" width="200px" src="../images/logo_new.png" alt=""></a>
                    </div>
                    <ul>
                        <li>Địa chỉ: 298 Cầu Diễn, Bắc Từ Liêm, Hà Nội</li>
                        <li>Điện thoại: +84 11.188.888</li>
                        <li>Email: starbook@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Truy cập nhanh</h6>
                    <ul>
                        <?php foreach ($result as $item) : ?>
                            <li><a href="?option=show_products&cat_id=<?= $item['id'] ?>"><?= $item['name'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <ul>
                        <?php foreach ($resultAuthors as $item) : ?>
                            <li><a href="?option=show_products&cat_id=<?= $item['id'] ?>"><?= $item['name'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__widget">
                    <h6>Danh mục bài viết</h6>
                    <ul>
                        <?php foreach ($resultArticleCategories as $item) : ?>
                            <li><a href="?option=show_products&cat_id=<?= $item['id'] ?>"><?= $item['name'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-1 col-md-6 col-sm-6">
                <div class="footer__widget" style="font-weight: bold">
                    S <i style="color: green" class="fa fa-heart" aria-hidden="true"></i><br/>
                    T <i style="color: green" class="fa fa-heart" aria-hidden="true"></i><br/>
                    A <i style="color: green" class="fa fa-heart" aria-hidden="true"></i><br/>
                    R <i style="color: green" class="fa fa-heart" aria-hidden="true"></i><br/>
                    B <i style="color: green" class="fa fa-heart" aria-hidden="true"></i><br/>
                    O <i style="color: green" class="fa fa-heart" aria-hidden="true"></i><br/>
                    O <i style="color: green" class="fa fa-heart" aria-hidden="true"></i><br/>
                    K <i style="color: green" class="fa fa-heart" aria-hidden="true"></i><br/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text">
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | <i class="fa fa-heart" aria-hidden="true"></i> Nhóm 3 - 20231IT6022003
                        </p>
                    </div>
                    <div class="footer__copyright__payment"><img src="img/payment-item.png" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->