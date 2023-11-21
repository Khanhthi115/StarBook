<?php
    if (isset($_POST['name'])){
        $name = $_POST['name'];
        $query = "select * from authors where name='$name'";
        if (mysqli_num_rows($connect->query($query))!=0){
            $alert = "Tác giả đã tồn tại";
        } else {
            $status = $_POST['status'];
            $connect->query("insert authors (name, status) values ('$name', '$status')");
            header("Location: ?option=author");
        }
    }
?>
<h1>Thêm tác giả</h1>
<section style="color: red; text-align:center"><?= isset($alert) ? $alert : '' ?></section>
<section class="container col-md-6">
    <form method="post">
        <section class="form-group">
            Tên tác giả: <input name="name" class="form-control">
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
            <a href="?option=author" class="btn btn-outline-primary">&lt;&lt;Back</a>
        </section>
    </form>
</section>