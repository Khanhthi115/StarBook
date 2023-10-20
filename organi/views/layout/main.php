<?php
if (isset($_GET['option'])) {
    switch ($_GET['option']) {
        case "home":
            include "views/home.php";
            break;
        case "signin":
            include "views/signin.php";
            break;
        case "register":
            include "views/register.php";
            break;
        case "cart":
            include "views/cart.php";
            break;
        case "logout":
            unset($_SESSION['member']);
            header("location: ?option=home");
            break;
        case "change_password":
            include "views/change_password.php";
            break;
        case "detail_product":
            include "views/detail_product.php";
            break;
        case "show_products":
            include "views/show_products.php";
            break;
        case "article_detail":
            include "views/detail_article.php";
            break;
        case 'order':
            include "views/order.php";
            break;
        case 'order_success':
            include "views/order_success.php";
            break;
    }
} else {
    include "views/home.php";
}
