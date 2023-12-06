<?php
    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $query = "select * from member where username ='$username'";
        if(mysqli_num_rows($connect->query($query))!=0){
            $alert = "Người dùng đã tồn tại!";
        } else{
            $password = $_POST['password'];
            $fullname = $_POST['fullname'];     
            $phonenumber = $_POST['phonenumber'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $status = $_POST['status'];
            $connect->query("insert member (username,password,fullname,
                    phonenumber,address, email, status) values ('$username', 
                    '$password', '$fullname', '$phonenumber', '$address', 
                    '$email', '$status')");
            header("Location: ?option=member");      

        }
    }
?>
<h1>Thêm người dùng</h1>
<section style="color: red; text-align:center"><?= isset($alert) ? $alert : '' ?></section>
<section class="container col-md-6">
    <form method="post">
        <section class="form-group">
            Tên người dùng: <input name="username" class="form-control">
        </section>
        <section class="form-group">
            Password: <input name="password" class="form-control">
        </section>
        <section class="form-group">
            Tên đầy đủ: <input name="fullname" class="form-control">
        </section>
        <section class="form-group">
            Số điện thoại: <input name="phonenumber" class="form-control">
        </section>
        <section class="form-group">
            Địa chỉ: <input name="address" class="form-control">
        </section>
        <section class="form-group">
            Email: <input name="email" class="form-control">
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
            <a href="?option=member" class="btn btn-outline-primary">&lt;&lt;Back</a>
        </section>
    </form>
</section>