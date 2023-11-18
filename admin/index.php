<?php
session_start();
?>
<?php
$connect = new MySQLi('localhost', 'root', '', 'starbook_databse', 3306);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>ADMIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="../public/ckeditor5/ckeditor.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<body>
    <?php
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $query = "select * from admin where username='$username' and password='$password'";
        $result = $connect->query($query);
        if (mysqli_num_rows($result) == 0)
            $alert = "Sai tên đăng nhập hoặc mật khẩu";
        else {
            $result = mysqli_fetch_array($result);
            if ($result['status'] == 0) {
                $alert = "Tài khoản bị khóa";
            } else {
                $_SESSION['admin'] = $username;
                header("Refresh:0");
            }
        }
    }
    ?>
    <section>
        <?php
        if (isset($_SESSION['admin'])) {
            include "control_panel.php";
        } else {
            include "login.php";
        }
        ?>
    </section>
</body>

</html>
<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>
