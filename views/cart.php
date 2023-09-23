<?php
if (empty($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
if (isset($_GET['action'])) {
    $id = $_GET['id'];
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
    }
}
?>
<section class="cart">
    <?php
    if (isset($_SESSION['cart'])) :
        $ids="0";
        foreach(array_keys($_SESSION['cart']) as $key)
        $ids .= ",".$key;
        // $ids below must be a string not an array so we need add each item from array_keys($_SESSION['cart'] like before 
        $query = "Select * from products where id in ($ids)";
        $result = $connect->query($query);
    ?>
        <table border="1" cellpadding="1" cellspacing="1" width="100%">
            <thead>
                <tr>
                    <td>Image</td>
                    <td>Name</td>
                    <td>Price</td>
                    <td>Quantity</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($result as $item) :
                ?>
                <tr>
                    <td width="20%"><img width="100%" src="./images/<?=$item['image']?>"></td>
                    <td><?=$item['name']?></td>
                    <td><?=$item['price']?></td>
                    <td><?=$_SESSION['cart'][$item['id']]?></td>
                </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>