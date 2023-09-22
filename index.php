<?php
$connect = new MySQLi('localhost', 'root', '', 'starbook_databse', 3310);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Star Book</title>
</head>

<body>
    <section class="wrapper">
        <header>Header</header>
        <nav>
            <a href="view/home.php">Home</a>
            <a href="?option=home">Home</a>
            <a href="?option=feedback">Feedback</a>
            <a href="?option=cart">Cart</a>
            <a href="?option=signin">SignIn</a>
            <a href="?option=register">Register</a>
        </nav>
        <section class="container">
            <aside>Left</aside>
            <article>
                <?php
                if (isset($_GET['option'])) {
                    switch ($_GET['option']) {
                        case "home":
                            include "views/home.php";
                            break;
                        case "home":
                            include "views/home.php";
                            break;
                        case "feedback":
                            include "views/feedback.php";
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
                    }
                }
                ?>
            </article>
            <aside>Right</aside>
        </section>
        <footer>Footer</footer>
    </section>
</body>

</html>