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
        case "show_articles":
            include "views/show_articles.php";
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
        case 'wishlist':
            include "views/wishlist.php";
            break;
        case 'forgot_password':
            include "views/forgot_password.php";
            break;
        case 'contact':
            include "views/contact.php";
            break;
        case 'order_history':
            include "views/order_history.php";
            break;
        case 'update_members':
            include "views/update_members.php";
            break;
    }
} else {
    include "views/home.php";
}