<table class="table table-bordered">
    <tr>
        <td width="15%" height="100">
            Hello: <?=$_SESSION['admin']?> <br><a href="?option=logout">Logout</a>
        </td>
        <td align="center">
            ADMIN CONTROL PANEL
        </td>
    </tr>
    <tr>
        <td>
            <section><a href="?option=author">Tác giả</a></section>
            <section><a href="">Sản phẩm</a></section>
        </td>
        <td>
            <?php
                if (isset($_GET['option'])){
                    switch ($_GET['option']){
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
                    }
                }
            ?>
        </td>
    </tr>
</table>