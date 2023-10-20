<?php
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $query = "select * from article_categories where name='$name'";
    if (mysqli_num_rows($connect->query($query)) != 0) {
        $alert = "Danh mục bài viết đã tồn tại";
    } else {
        $status = $_POST['status'];
        $connect->query("insert article_categories (name, status) values ('$name', '$status')");
        header("Location: ?option=article_categories");
    }
}
?>
<h1>Thêm danh mục bài viết</h1>
<section style="color: red; text-align:center"><?= isset($alert) ? $alert : '' ?></section>
<section class="container col-md-6">
    <form method="post">
        <section class="form-group">
            Tên danh mục bài viết: <input name="name" class="form-control">
        </section>
        <section class="form-group">
            Trạng thái:<br>
            <input name="status" type="radio" value="1" checked>
            Active
            <input type="radio" name="status" value="0">
            Unactive
        </section>
        <section>
            <input type="submit" value="Thêm" class="btn btn-success">
            <a href="?option=article_categories" class="btn btn-outline-primary">&lt;&lt;Back</a>
        </section>
    </form>
</section>