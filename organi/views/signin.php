<?php
// session_start(); // Start session if not already started

if (isset($_POST["signin"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashPassword = md5($password);
    if (empty($_POST['username'])) {
        $errorTK = "Vui lòng nhập tên đăng nhập";
    }else if(empty($_POST['password'])){
        $errorMK = "Vui lòng nhập mật khẩu";
    } else {
        $query = "SELECT * FROM `member` WHERE `username` = '$username'";
        $result = $connect->query($query);

        if ($result && $result->num_rows > 0) {
            $userData = $result->fetch_assoc();

            if ($userData['password'] === $hashPassword) {
                if ($userData['status'] == 0) {
                    $warnings = "Tài khoản bạn đang bị khóa hoặc trong quá trình xử lý";
                } else {
                    $_SESSION['member'] = $username;
                    if (isset($_GET['order'])) {
                        header("location: ?option=order");
                    } elseif (isset($_GET['product_id'])) {
                        $member_id = $userData['id'];
                        $product_id = $_GET['product_id'];
                        $content = $_SESSION['content'];
                        $connect->query("INSERT INTO `comments` (memberId, productId, date, content) VALUES ($member_id, $product_id, now(), '$content')");
                        echo "
                        <script>
                            alert('Bình luận đã được gửi đi và sẽ sớm xuất hiện!');
                            location='?option=detail_product&id=$product_id';
                        </script>";
                    } else {
                        header("location: ?option=home");
                    }
                }
            } else {
                $errors = "Sai tên đăng nhập hoặc mật khẩu";
            }
        } else {
            $errors = "Sai tên đăng nhập hoặc mật khẩu";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StarBook</title>
</head>

<body>
    <section class="signup" style="margin-bottom: 50px; margin-top: 20px;">
        <div class="container">
            <div class="signin-content" style="animation-name: fadeIn; animation-duration: 2s">
                <div class="signup-form">
                    <h2 class="form-title">Đăng nhập</h2>
                    <form method="POST" class="register-form" id="register-form">
                        <div class="form-group">
                            <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="username" value="<?php echo $username ?>" id="name" placeholder="Tên đăng nhập" />
                            <p style="color:red;"><?php echo $errorTK;?></p>
                        </div>
                        <div class="form-group">
                            <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="pass" placeholder="Mật khẩu" />
                            <p style="color:red;"><?php echo $errorMK;?></p>
                            <p style="color:red;"><?php echo $errors;?></p>
                            <p style="color:red;"><?php echo $warnings;?></p>
                        </div>
                        <a href="?option=forgot_password" class="signup-image-link">Quên mật khẩu?</a>

                        <div class="form-group">
                            <input type="submit" name="signin" id="signup" class="btn btn-primary btn-signup" value="Đăng nhập" />
                        
                        </div>
                    </form>
                </div>
                <div class="signin-image">
                    <figure><img src="../images/signin-image.jpg" alt="sign up image"></figure>
                    <a href="?option=register" class="signup-image-link">Chưa có tài khoản? Đăng ký</a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>