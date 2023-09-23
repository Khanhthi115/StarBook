<?php
if (empty($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
if (isset($_GET['action'])) {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    switch ($_GET['action']) {
        case 'add':
            // if product is already in cart we increase its quantity else the quantity of it is 1
            if (array_key_exists($id, array_keys($_SESSION['cart']))) {
                $_SESSION['cart'][$id]++;
                // change link or when reload page the quantity will increase
                header("location: ?option=cart");
            } else {
                $_SESSION['cart'][$id] = 1;
                header("location: ?option=cart");
            }
            break;
        case 'delete':
            unset($_SESSION['cart'][$id]);
            break;
        case 'delete_all':
            unset($_SESSION['cart']);
            break;
    }
}
?>
<section class="cart">
    <?php
    $total = 0;
    if (!empty($_SESSION['cart'])) :
        // $ids below must be a string
        $ids = implode(',', array_keys($_SESSION['cart']));
        $query = "Select * from products where id in ($ids)";
        $result = $connect->query($query);
    ?>
        <table border="1" cellpadding="1" cellspacing="1" width="100%">
            <thead>
                <tr>
                    <td>Image</td>
                    <td>Name</td>
                    <td>Price (VND)</td>
                    <td>Quantity</td>
                    <td>Subtotal (VND)</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($result as $item) :
                ?>
                    <tr>
                        <td width="20%"><img width="100%" src="./images/<?= $item['image'] ?>"></td>
                        <td><?= $item['name'] ?><br><input type="button" value="Delete" onclick="location='?option=cart&action=delete&id=<?=$item['id']?>';"></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?></td>
                        <td><?= $_SESSION['cart'][$item['id']] ?></td>
                        <td><?= number_format($subTotal = $item['price'] * $_SESSION['cart'][$item['id']], 0, ',', '.') ?></td>
                        <?php $total += $subTotal; ?>
                    </tr>
                <?php
                endforeach;
                ?>
                <tr>
                    <td colspan="5">
                        <section>
                            Total: <?= number_format($total, 0, ',', '.') ?> VND
                            <input type="button" value="Delete All" onclick="location='?option=cart&action=delete_all'">
                    </section> 
                    </td>
                </tr>
            </tbody>
        </table>
    <?php else : ?> <section>Giỏ hàng trống</section>
    <?php endif; ?>
</section>