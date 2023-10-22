<?php
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $query = "select * from member where username = '$username'";
    $result = $connect->query($query);
    if (mysqli_num_rows($result) != 0) {
        $alert = "Tên đăng nhập đã tồn tại";
    } else {
        $password = md5($_POST['password']);
        $fullname = $_POST['fullname'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $query = "insert member (
                username, password, fullname, phonenumber, address, email) values ('$username', '$password',
                '$fullname', '$phone', '$address', '$email')";
        $connect->query($query);
        echo "<script>alert('Đăng ký thành công'); location='?option=home'</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Star book</title>
</head>

<body>
    <section style="color: red"><?= isset($alert) ? $alert : "" ?></section>
    <!-- Sign up form -->
    <section class="signup" style="margin-bottom: 50px; margin-top: 20px;">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">Đăng ký tài khoản</h2>
                    <form method="POST" class="register-form" id="register-form" onsubmit="if(repassword.value!=password.value){alert('Mật khẩu nhập lại không khớp'); return false;}">
                        <div class="form-group">
                            <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="username" id="username" placeholder="Tên đăng nhập" />
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-email"></i></label>
                            <input type="email" name="email" id="email" placeholder="Email" />
                        </div>
                        <div class="form-group">
                            <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="pass" placeholder="Mật khẩu" />
                        </div>
                        <div class="form-group">
                            <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                            <input type="password" name="repassword" id="re_pass" placeholder="Nhập lại mật khẩu" />
                        </div>
                        <div class="form-group">
                            <label for="re-fullname"><i class="zmdi zmdi-lock-outline"></i></label>
                            <input type="text" name="fullname" id="fullname" placeholder="Tên đầy đủ" />
                        </div>
                        <div class="form-group">
                            <label for="phone"><i class="zmdi zmdi-lock-outline"></i></label>
                            <input type="tel" name="phone" id="phone" placeholder="Số điện thoại" />
                        </div>
                        <div class="form-group">
                            <label for="address"><i class="zmdi zmdi-lock-outline"></i></label>
                            <input type="text" name="address" id="address" placeholder="Địa chỉ" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="signup" id="signup" class="btn btn-primary btn-signup" value="Register" />
                        </div>
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img src="../images/signup-image.jpg" alt="sing up image"></figure>
                    <a href="?option=signin" class="signup-image-link">Đăng nhập</a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>