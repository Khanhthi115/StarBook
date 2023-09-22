<a href="views/home.php">Home</a>
<a href="?option=home">Home</a>
<a href="?option=feedback">Feedback</a>
<a href="?option=cart">Cart</a>
<?php if (empty($_SESSION['member'])) : ?>
    <a href="?option=signin">SignIn</a>
    <a href="?option=register">Register</a>
<?php else : ?>
    <section>
        Hello: <span style="color: red"><?= $_SESSION['member'] ?></span>
        <a href="?option=logout">Đăng xuất</a>
    </section>
<?php endif; ?>