<?php
if (isset($_POST['content'])) {
    $content = $_POST['content'];
    $productId = $_GET['id'];
    // when user have signed in and comment
    if (isset($_SESSION['member'])) {
        $date = time();
        $memberId = mysqli_fetch_array($connect->query("select * from member where username='" . $_SESSION['member'] . "'"));
        $memberId = $memberId['id'];
        $connect->query("insert comments (memberId, productId, date, content) values ($memberId, $productId, now(), '$content')");
        echo "<script>alert('Bình luận đã được gửi đi và sẽ sớm xuất hiện!')</script>";
    } else {
        // when user have not signed in and comment
        $_SESSION['content'] = $content;
        echo "
        <script>
            alert('Đăng nhập để thực hiện chức năng này!');
            location='?option=signin&product_id=$productId';
        </script>";
    }
}
?>
<?php
$id = $_GET['id'];
$query = "select * from products where id = $id";
$result = $connect->query($query);
$item = mysqli_fetch_array($result);
?>
<section style="width: 100%">
    <h1>Chi tiết sản phẩm</h1>
    <section>
        <section class="pro_img"><img width="200px" src="images/<?= $item['image'] ?>"></section>
        <section class="pro_name"><?= $item['name'] ?></section>
        <section class="pro_name"><?= number_format($item['price'], 0, ',', '.') ?>đ</section>
        <section class="pro_name"><input type="submit" value="Đặt mua"></section>
        <section class="description">
            <?= $item['description'] ?>
        </section>
    </section>
</section>

<section>
    <h2>Bình luận về sản phẩm</h2>
    <?php
    $comment = $connect->query("select * from member a join comments b on a.id = b.memberId join products c on b.productId = c.id where b.status = 0 and productId = ".$_GET['id']);
    if (mysqli_num_rows($comment) == 0) :
        echo "<section>Chưa có bình luận nào</section>";
    else :
        foreach ($comment as $item) :
    ?>
            <b><section><?=$item['username']?></section></b>
            <section style="padding-left: 2%;"><?=$item['content']?></section>

    <?php
        endforeach;
    endif;
    ?>
    <form method="post">
        <section>
            <textarea name="content" style="width: 100%" row="5" class="form-control" placeholder="Nhập bình luận tại đây ..."></textarea>
        </section>
        <section>
            <input type="submit" value="Submit" class="btn btn-primary">
        </section>
    </form>
</section>
<?php
include("home.php");
?>