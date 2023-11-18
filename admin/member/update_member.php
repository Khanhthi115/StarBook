<?php
$member = mysqli_fetch_array($connect->query("select * from member where id =" . $_GET['id']));
?>
<?php
if (isset($_POST['username'])){
    $username = $_POST['username'];
    $query = "select * from member where username='$username' and id!=".$member['id'];
    if (mysqli_num_rows($connect->query($query))!=0){
        $alert = "Nguời dùng đã tồn tại";
    } else {
        $password = $_POST['password'];
        $fullname = $_POST['fullname'];     
        $phonenumber = $_POST['phonenumber'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $status = $_POST['status'];
        $connect->query("update member set username = '$username', password = '$password', fullname = '$fullname', 
                        phonenumber = '$phonenumber', address = '$address', email = '$email', 
                        status = '$status' WHERE id =" .$member['id']);

        header("Location: ?option=member");
    }
}
?> 
<h1>Sửa người dùng</h1>
<section style="color: red; text-align:center"><?= isset($alert) ? $alert : '' ?></section>
<section class="container col-md-6">
    <form method="post">
        <section class="form-group">
            Tên người dùng: <input name="username" value="<?= $member['username'] ?>" class="form-control">
        </section>
        <section class="form-group">
            Password: <input name="password" value="<?= $member['password'] ?>" class="form-control">
        </section>
        <section class="form-group">
            Tên đầy đủ: <input name="fullname" value="<?= $member['fullname'] ?>" class="form-control">
        </section>
        <section class="form-group">
            Số điện thoại: <input name="phonenumber" value="<?= $member['phonenumber'] ?>" class="form-control">
        </section>
        <section class="form-group">
            Địa chỉ: <input name="address" value="<?= $member['address'] ?>" class="form-control">
        </section>
        <section class="form-group">
            Email: <input name="email" value="<?= $member['email'] ?>" class="form-control">
        </section>
        <section class="form-group">
            Trạng thái:<br>
            <input name="status" type="radio" value="1" <?= $member['status'] == 1 ? 'checked' : '' ?>>
            Active
            <input type="radio" name="status" value="0" <?= $member['status'] == 0 ? 'checked' : '' ?>>
            Unactive
        </section>
        <section>
            <input type="submit" value="Sửa" class="btn btn-success">
            <a href="?option=member" class="btn btn-outline-primary">&lt;&lt;Back</a>
        </section>
    </form>
</section>