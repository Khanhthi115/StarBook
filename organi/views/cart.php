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
        case 'update':
            if ($_GET['type'] == 'asc')
                $_SESSION['cart'][$id]++;
            else if ($_GET['type'] == 'dec')
                if ($_SESSION['cart'][$id] > 1) $_SESSION['cart'][$id]--;
            header("location: ?option=cart");
            break;
        case 'order':
            if (isset($_SESSION['member'])) {
                header("location: ?option=order");
            } else {
                header("location: ?option=signin&order=1");
            }
            break;
    }
}
?>

<!-- Hero Section Begin -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All departments</span>
                    </div>
                    <ul>
                        <li><a href="#">Fresh Meat</a></li>
                        <li><a href="#">Vegetables</a></li>
                        <li><a href="#">Fruit & Nut Gifts</a></li>
                        <li><a href="#">Fresh Berries</a></li>
                        <li><a href="#">Ocean Foods</a></li>
                        <li><a href="#">Butter & Eggs</a></li>
                        <li><a href="#">Fastfood</a></li>
                        <li><a href="#">Fresh Onion</a></li>
                        <li><a href="#">Papayaya & Crisps</a></li>
                        <li><a href="#">Oatmeal</a></li>
                        <li><a href="#">Fresh Bananas</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                All Categories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="What do yo u need?">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+65 11.188.888</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="../images/background_show_products.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Shopping Cart</h2>
                    <div class="breadcrumb__option">
                        <a style="color: black;" href="?option=home">Home</a>
                        <span style="color: black;">Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <?php
    $total = 0;
    if (!empty($_SESSION['cart'])) :
        // $ids below must be a string
        $ids = implode(',', array_keys($_SESSION['cart']));
        $query = "Select * from products where id in ($ids)";
        $result = $connect->query($query);
    ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result as $item) : ?>
                                    <tr>
                                        <td class="shoping__cart__item">
                                            <img width="100px" src="../images/<?= $item['image'] ?>" alt="">
                                            <h5><?= $item['name'] ?></h5>
                                        </td>
                                        <td class="shoping__cart__price">
                                            <?= number_format($item['price'], 0, ',', '.') ?>đ
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <span class="dec qtybtn" onclick="location='?option=cart&action=update&type=dec&id=<?= $item['id'] ?>';">-</span>
                                                    <input type="text" value="<?= $_SESSION['cart'][$item['id']] ?>" disabled>
                                                    <span class="inc qtybtn" onclick="location='?option=cart&action=update&type=asc&id=<?= $item['id'] ?>';">+</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="shoping__cart__total">
                                            <?= number_format($subTotal = $item['price'] * $_SESSION['cart'][$item['id']], 0, ',', '.') ?>đ
                                            <?php $total += $subTotal; ?>
                                        </td>
                                        <td class="shoping__cart__item__close">
                                            <span class="icon_close" onclick="location='?option=cart&action=delete&id=<?= $item['id'] ?>';"></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="?option=show_products" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="" onclick="if(confirm('Are you want to delete all cart?')) location='?option=cart&action=delete_all'" class="primary-btn cart-btn cart-btn-right">
                            Delete All</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal <span><?= number_format($total, 0, ',', '.') ?>đ</span></li>
                            <li>Total <span><?= number_format($total, 0, ',', '.') ?>đ</span></li>
                        </ul>
                        <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?> <section style="text-align: center; font-size: 30px;">Giỏ hàng trống</section>
    <?php endif; ?>
</section>
<!-- Shoping Cart Section End -->