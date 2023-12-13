<?php
$author = mysqli_fetch_array($connect->query("select * from article_categories where id =" . $_GET['id']));
?>
<?php
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $query = "select * from article_categories where name='$name' and id!=" . $author['id'];
    if (mysqli_num_rows($connect->query($query)) != 0) {
        $alert = "Danh mục bài viết đã tồn tại";
    } else {
        $status = $_POST['status'];
        $connect->query("update article_categories set name = '$name', status='$status' where id =" . $author['id']);
        header("Location: ?option=article_categories");
    }
}
?>
<h1>Sửa danh mục bài viết</h1>
<section style="color: red; text-align:center"><?= isset($alert) ? $alert : '' ?></section>
<section class="container col-md-6">
    <form method="post">
        <section class="form-group">
            Tên danh mục bài viết: <input name="name" value="<?= $author['name'] ?>" class="form-control">
        </section>
        <section class="form-group">
            Trạng thái:<br>
            <input name="status" type="radio" value="1" <?= $author['status'] == 1 ? 'checked' : '' ?>>
            Active
            <input type="radio" name="status" value="0" <?= $author['status'] == 0 ? 'checked' : '' ?>>
            Unactive
        </section>
        <section>
            <input type="submit" value="Sửa" class="btn btn-success">
            <a href="?option=article_categories" class="btn btn-outline-primary">&lt;&lt;Back</a>
        </section>
    </form>
</section>