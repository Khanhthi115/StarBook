<table class="table table-bordered">
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
                }
            }
            ?>
        </td>
    </tr>
</table>