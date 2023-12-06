<?php
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    if (empty($username) || empty($password) || empty($repassword) || empty($fullname) || empty($phone) || empty($address) || empty($email)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin')</script>";
    } elseif ($password !== $repassword) {
        echo "<script>alert('Mật khẩu nhập lại không khớp')</script>";
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/', $password)) {
        echo "<script>alert('Mật khẩu phải gồm ít nhất 6 ký tự, bao gồm chữ và số')</script>";
    } else {
        // Kiểm tra username đã tồn tại trong database
        $query = "SELECT * FROM `member` WHERE `username` = '$username'";
        $result = $connect->query($query);
        if (mysqli_num_rows($result) != 0) {
            echo "<script>alert('Tên đăng nhập đã tồn tại')</script>";
        } else {
            $password = md5($password);
            $query = "INSERT INTO `member` (`username`, `password`, `fullname`, `phonenumber`, `address`, `email`) VALUES ('$username', '$password', '$fullname', '$phone', '$address', '$email')";
            $connect->query($query);
            echo "<script>alert('Đăng ký thành công'); location='?option=home'</script>";
        }
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
            <div class="signup-content" style="animation-name: fadeIn; animation-duration: 2s">
                <div class="signup-form">
                    <h2 class="form-title">Đăng ký tài khoản</h2>
                    <form method="POST" class="register-form" id="register-form">
                        <div class="form-group">
                            <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="username" id="username" placeholder="Tên đăng nhập" value="<?= isset($username) ? $username : '' ?>" />
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-email"></i></label>
                            <input type="email" name="email" id="email" placeholder="Email" value="<?= isset($email) ? $email : '' ?>" />
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
                            <input type="text" name="fullname" id="fullname" placeholder="Tên đầy đủ" value="<?= isset($fullname) ? $fullname : '' ?>" />
                        </div>
                        <div class="form-group">
                            <label for="phone"><i class="zmdi zmdi-lock-outline"></i></label>
                            <input type="tel" name="phone" id="phone" placeholder="Số điện thoại" value="<?= isset($phone) ? $phone : '' ?>" />
                        </div>
                        <div class="form-group">
                            <label for="address"><i class="zmdi zmdi-lock-outline"></i></label>
                            <input type="text" name="address" id="address" placeholder="Địa chỉ" value="<?= isset($address) ? $address : '' ?>" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="signup" id="signup" class="btn btn-primary btn-signup" value="Đăng ký" />
                        </div>
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img src="../images/signup-image.jpg" alt="sing up image"></figure>
                    <a href="?option=signin" class="signup-image-link">Đã có tài khoản? Đăng nhập</a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>