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
    <h1>Đăng ký tài khoản</h1>
    <section style="color: red"><?= isset($alert) ? $alert : "" ?></section>
    <section>
        <form method="post" onsubmit="if(repassword.value!=password.value){alert('Mật khẩu nhập lại không khớp'); return false;}">
            <section>
                Username: <input type="text" name="username" required>
            </section>
            <section>
                Password: <input type="password" name="password">
            </section>
            <section>
                Re-Password: <input type="password" name="repassword" required>
            </section>
            <section>
                Fullname: <input type="text" name="fullname" required>
            </section>
            <section>
                Phone number: <input type="tel" name="phone" required pattern="(0|\+84)\d{9}">
            </section>
            <section>
                Address: <textarea name="address"></textarea>
            </section>
            <section>
                Email: <input type="email" name="email">
            </section>
            <section>
                <input type="submit" value="Đăng ký">
            </section>
        </form>
    </section>
</body>

</html>