<?php
$alert = "";
if (isset($_POST['change_password'])) {
    $username = $_POST['username'];
    $old_password = md5($_POST['old_password']);
    $new_password = md5($_POST['new_password']);
    $query = "SELECT * FROM member WHERE username = '$username' AND password = '$old_password' limit 1";
    $result = $connect->query($query);

    if (mysqli_num_rows($result) == 0) {
        $alert = "Sai tên đăng nhập hoặc mật khẩu";
    } else {
        $result = mysqli_fetch_array($result);
        if ($result['status'] == 0) {
            $alert = "Tài khoản bạn đang bị khóa hoặc trong quá trình xử lý";
        } else {
            $sql_update = $connect->query("update member set password = '" . $new_password . "' where username = '" . $username . "'");
            $alert = "Mật khẩu đã được cập nhật";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Book</title>
</head>

<body>
    <?php if (!empty($alert)) { ?>
        <script>
            alert("<?= $alert ?>")
        </script>
    <?php } ?>
    <section class="signup" style="margin-bottom: 50px; margin-top: 20px;">
        <div class="container">
            <div class="signin-content">
                <div class="signup-form">
                    <h2 class="form-title">Đổi mật khẩu</h2>
                    <form method="POST" class="register-form" id="register-form">
                        <div class="form-group">
                            <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="username" id="name" placeholder="Tên đăng nhập" />
                        </div>
                        <div class="form-group">
                            <label for="old"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="password" name="old_password" id="name" placeholder="Mật khẩu cũ" />
                        </div>
                        <div class="form-group">
                            <label for="new"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="new_password" id="new" placeholder="Mật khẩu mới" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="change_password" id="change_password" class="btn btn-primary btn-signup" value="Cập nhật" />
                        </div>
                    </form>
                </div>
                <div class="signin-image">
                    <figure><img src="../images/signin-image.jpg" alt="sign up image"></figure>
                    <a href="?option=show_products" class="signup-image-link" style="color: white">Tiếp tục mua hàng?</a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>