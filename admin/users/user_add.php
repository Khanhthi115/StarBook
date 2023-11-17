<?php
include 'db_connection.php';

// Thêm dữ liệu (Create)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $status = $_POST["status"];

    $sql = "INSERT INTO admin (username, password, status) VALUES ('$username', '$password', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm dữ liệu thành công";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Đọc dữ liệu (Read)
$sql = "SELECT * FROM admin";
$result = $conn->query($sql);


//Cập nhật dữ liệu (Update)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $username = $_POST["username"];
    $newPassword = $_POST["new_password"];
    $newStatus = $_POST["new_status"];

    $sql = "UPDATE admin SET password='$newPassword', status='$newStatus' WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Cập nhật dữ liệu thành công";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Xóa dữ liệu (Delete)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $username = $_POST["username"];

    $sql = "DELETE FROM admin WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa dữ liệu thành công";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}
?>

<?php
$conn->close();
?>
