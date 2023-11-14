<?php
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashPassword = md5($password);
    $query = "SELECT * FROM `member` WHERE `username` = '$username' AND `password` = '$hashPassword'";
    $result = $connect->query($query);

    // if ($result_signin) {
    //     if ($result_signin->num_rows == 0) {
    //         $alert = "Sai tên đăng nhập hoặc mật khẩu";
    //     } else if (mysqli_fetch_array($result_signin)['status'] == 0) {
    //         $alert = "Tài khoản bị khóa hoặc đang được xử lý";
    //     } else {
    //         $_SESSION['member'] = $username;
    //         if (isset($_GET['order'])) {
    //             header("location: ?option=order");
    //         } 
    //         //phần của chức năng bình luận sản phẩm khi chưa đăng nhập
    //         else if ($_GET['product_id']){
    //             $result = mysqli_fetch_array($result_signin);
    //             echo $result, "hello";
    //             $member_id = $result['id'];
    //             $product_id = $_GET['product_id'];
    //             $content = $_SESSION['content'];
    //             $connect->query("insert comments (memberId, productId, date, content) values ($member_id, $product_id, now(), '$content')");
    //             echo "<script>alert('Bình luận đã được gửi đi và sẽ sớm xuất hiện!')</script>";
    //         }
    //         else {
    //             // navigate with js
    //             // echo "<script>location='?option=home';</script>";
    //             //navigate with php
    //             header("location: ?option=home");
    //         }
    //     }
    // } else {
    //     $alert = "Lỗi khi thực hiện truy vấn";
    // }
    if (mysqli_num_rows($result) == 0) {
        $alert = "Sai tên đăng nhập hoặc mật khẩu";
    } else {
        $result = mysqli_fetch_array($result);
        if ($result['status'] == 0) {
            $alert = "Tài khoản bạn đang bị khóa hoặc trong quá trình xử lý";
        } else {
            $_SESSION['member'] = $username;
            if (isset($_GET['order'])) {
                header("location: ?option=order");
            } elseif (isset($_GET['product_id'])) {
                $member_id = $result['id'];
                $product_id = $_GET['product_id'];
                $content = $_SESSION['content'];
                $connect->query("insert comments (memberId, productId, date, content) values ($member_id, $product_id, now(), '$content')");
                echo "
                <script>
                    alert('Bình luận đã được gửi đi và sẽ sớm xuất hiện!');
                    location='?option=detail_product&id=$product_id';
                </script>";
            } else {
                header("location: ?option=home");
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                            <input type="text" name="username" id="name" placeholder="Tên đăng nhập" />
                        </div>
                        <div class="form-group">
                            <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="pass" placeholder="Mật khẩu" />
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