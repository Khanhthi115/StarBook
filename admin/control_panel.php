<?php
$chuaXuLy = mysqli_num_rows($connect->query("select * from orders where status=1"));
$dangXuLy = mysqli_num_rows($connect->query("select * from orders where status=2"));
$daXuLy = mysqli_num_rows($connect->query("select * from orders where status=3"));
$huy = mysqli_num_rows($connect->query("select * from orders where status=4"));
?>
<table class="table table-bordered tbl-admin">
    <tr>
        <td width="15%" height="100">
            Hello: <?= $_SESSION['admin'] ?><br />
            <a href="?option=logout">Đăng xuất</a>
        </td>
        <td align="center">
            ADMIN CONTROL PANEL
        </td>
    </tr>
    <tr>
        <td>
            <section><a href="?option=member">Người dùng</a></section>
            <section><a href="?option=author">Tác giả</a></section>
            <section><a href="?option=product_categories">Danh mục sản phẩm</a></section>
            <section><a href="?option=product">Sản phẩm</a></section>
            <section><a href="?option=article_categories">Danh mục bài viết</a></section>
            <section><a href="?option=article">Bài viết</a></section>
            <section>
                <a>Đơn hàng</a>
                <section><a href="?option=order&status=1">&nbsp;&nbsp;Đơn hàng chưa xử lý (<?= $chuaXuLy ?>)</a>
                </section>
                <section><a href="?option=order&status=2">&nbsp;&nbsp;Đơn hàng đang xử lý (<?= $dangXuLy ?>)</a>
                </section>
                <section><a href="?option=order&status=3">&nbsp;&nbsp;Đơn hàng đã xử lý (<?= $daXuLy ?>)</a></section>
                <section><a href="?option=order&status=4">&nbsp;&nbsp;Hủy (<?= $huy ?>)</a></section>
            </section>
        </td>
        <td>
            <?php
            if (isset($_GET['option'])) {
                switch ($_GET['option']) {
                    case 'logout':
                        unset($_SESSION['admin']);
                        header("Location: .");
                        break;
                    case 'member':
                        include "./member/show_member.php";
                        break;
                    case 'member_add':
                        include "member/member_add.php";
                        break;
                    case 'member_update':
                        include "member/update_member.php";
                        break;
                    case 'author':
                        include "./authors/show_author.php";
                        break;
                    case 'author_add':
                        include "authors/author_add.php";
                        break;
                    case 'author_update':
                        include "authors/update_author.php";
                        break;
                    case 'product':
                        include "./products/show_product.php";
                        break;
                    case 'product_add':
                        include "./products/product_add.php";
                        break;
                    case "product_update":
                        include "./products/product_update.php";
                        break;
                    case "product_categories":
                        include "./product_categories/show_product_cat.php";
                        break;
                    case "product_cat_add":
                        include "./product_categories/product_cat_add.php";
                        break;
                    case "product_cat_update":
                        include "./product_categories/product_cat_update.php";
                        break;
                    case "article_categories":
                        include "./article_categories/show_articles_cat.php";
                        break;
                    case "article_categories_add":
                        include "./article_categories/articles_cat_add.php";
                        break;
                    case "article_categories_update":
                        include "./article_categories/articles_cat_update.php";
                        break;
                    case "article":
                        include "./articles/show_article.php";
                        break;
                    case "article_update":
                        include "./articles/article_update.php";
                        break;
                    case "article_add":
                        include "./articles/article_add.php";
                        break;
                    case "order":
                        include "./orders/show_order.php";
                        break;
                    case "order_detail":
                        include "./orders/order_detail.php";
                        break;
                }
            }
            ?>
        </td>
    </tr>
</table>