<?php

$connect = new MySQLi('localhost', 'root', '12345678', 'starbook_databse', 3306);
// if($connect->connect_error){
//     die("Kết nối không thành công". $connect->connect_error);
// }


?>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Star Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <section class="wrapper">
        <header><?php include("views/layout/header.php"); ?></header>
        <nav>
            <?php include("views/layout/menu-top.php"); ?>
        </nav>
        <section class="container">
            <aside><?php include("views/layout/left.php"); ?></aside>
            <article>
                <?php include("views/layout/article.php"); ?>
            </article>
            <aside><?php include("views/layout/right.php"); ?></aside>
        </section>
        <footer><?php include("views/layout/footer.php"); ?></footer>
    </section>
</body>

</html>