<?php
    $chuaXuLy = mysqli_num_rows($connect->query("select * from orders where status=1"));
    $dangXuLy = mysqli_num_rows($connect->query("select * from orders where status=2"));
    $daXuLy = mysqli_num_rows($connect->query("select * from orders where status=3"));
    $huy = mysqli_num_rows($connect->query("select * from orders where status=4"));
?>
<table class="table table-bordered tbl-admin">
    <tr>
        <td width="15%" height="100">
            Hello: <?= $_SESSION['admin'] ?> <br><a href="?option=logout">Logout</a>
        </td>
        <td align="center">
            ADMIN CONTROL PANEL
        </td>
    </tr>
    <tr>
        <td>
            <section><a href="?option=author">Tác giả</a></section>
            <section><a href="?option=product">Sản phẩm</a></section>
            <section>
                <a href="?option=order">Đơn hàng</a>
                <section><a href="?option=order&status=1">&nbsp;&nbsp;Đơn hàng chưa xử lý (<?=$chuaXuLy?>)</a></section>
                <section><a href="?option=order&status=2">&nbsp;&nbsp;Đơn hàng đang xử lý (<?=$dangXuLy?>)</a></section>
                <section><a href="?option=order&status=3">&nbsp;&nbsp;Đơn hàng đã xử lý (<?=$daXuLy?>)</a></section>
                <section><a href="?option=order&status=4">&nbsp;&nbsp;Hủy (<?=$huy?>)</a></section>
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
                    case "order":
                        include "./orders/show_order.php";
                        break;
                }
            }
            ?>
        </td>
    </tr>
</table>