<table border="1" width="100%" cellpadding="1" cellspacing="1">
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
            <section><a href="">Tác giả</a></section>
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
                    }
                }
            ?>
        </td>
    </tr>
</table>