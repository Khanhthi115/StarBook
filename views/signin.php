<?php
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $query = "SELECT * FROM member WHERE username = '$username' AND password = '$password'";
    $result_signin = $connect->query($query);

    if ($result_signin) { 
        if ($result_signin->num_rows == 0) {
            $alert = "Sai tên đăng nhập hoặc mật khẩu";
        } 
        else if (mysqli_fetch_array($result_signin)['status'] == 0) {
                $alert = "Tài khoản bị khóa hoặc đang được xử lý";           
        }
        else {
            $_SESSION['member'] = $username;
            // navigate with js
            // echo "<script>location='?option=home';</script>";
            //navigate with php
            header("location: ?option=home");
        }
    } else {
        $alert = "Lỗi khi thực hiện truy vấn";
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
    <section>
        <h1>Đăng nhập tài khoản</h1>
        <section><?=isset($alert)?$alert:""?></section>
        <section>
            <form method="post">
                <section>
                    <label>Username: </label><input type="text" name="username">
                </section>
                <section>
                    <label>Password: </label><input type="password" name="password">
                </section>
                <section><input type="submit" value="Đăng nhập"></section>
            </form>
        </section>
    </section>
</body>

</html>