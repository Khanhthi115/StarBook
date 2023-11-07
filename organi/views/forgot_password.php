<?php
include "../PHPMailer/src/PHPMailer.php";
include "../PHPMailer/src/Exception.php";
// include "../PHPMailer/src/OAuth.php";
include "../PHPMailer/src/POP3.php";
include "../PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



    // $username="";
    if(isset($_POST["confirm"])){
        $username=$_POST["username"];
        $query = "SELECT `email` FROM `member` WHERE `username` = '$username' ";
        $result = $connect->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];
            $password=rand(100000,999999);

            //echo "Địa chỉ email: " . $email;
            $mail = new PHPMailer(true);                              // Khai báo hàm

            try {

                //Server settings
                $mail->SMTPDebug = 0;                                 // Bật thông báo lỗi nếu như bị sai cấu hình
                $mail->isSMTP();                                      // Sử dụng SMTP để gửi mail
                $mail->Host = 'smtp.gmail.com';                   // Server SMTP của mình
                $mail->SMTPAuth = true;                               // Bật xác thực SMTP
                $mail->Username = 'hangt7708@gmail.com';                 // Tài khoản email
                $mail->Password = 'mkts qeug zmrm snav';                           // Mật khẩu email
                $mail->SMTPSecure = 'tls';                            // Tắt SSL /TLS
                // $mail->SMTPAutoTLS = false;
                // $mail->SMTPSecure = false;
                $mail->Port = 587;                                                                                                              // Cổng kết nối SMTP sẽ là 25

                //Recipients
                $mail->setFrom('hangt7708@gmail.com', 'Star Book');           // Địa chỉ email và tên người gửi
                $mail->addAddress($email);     // Địa chỉ người nhận
                //$mail->addAddress('ellen@example.com');               // Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Nếu muốn gửi thêm tệp thì uncomment dòng này
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Và cả dòng này nữa nếu gửi trên một file

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Password Retrieval';                             // Tiêu đề
                $mail->Body = 'Your new password is: '.$password;                      // Nội dung
                $password=md5($password);
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                $sql_update = $connect->query("update member set password = '" . $password . "' where username = '" . $username . "'");

                $mail->send();
                echo '<script>alert("Mật khẩu mới đã được gửi đến email của bạn!")</script>';
                // echo 'Message has been sent';
            } catch (Exception $e) {
                // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
            
        } else {
            echo '<script>alert("Người dùng này không tồn tại!")</script>';

            // echo "Không tìm thấy người dùng với tên người dùng này.";
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
            <div class="signin-content">
                <div class="signup-form">
                    <h2 class="form-title">Lấy lại mật khẩu</h2>
                    <form method="POST" class="register-form" id="register-form">
                        <div class="form-group">
                            <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="username" id="name" placeholder="Tên đăng nhập" />
                        </div>
                        

                        <div class="form-group">
                            <input type="submit" name="confirm" id="signup" class="btn btn-primary btn-signup" value="Xác nhận" />
                        
                        </div>
                    </form>
                </div>
                <div class="signin-image">
                    <figure><img src="../images/signin-image.jpg" alt="sign up image"></figure>
                </div>
            </div>
        </div>
    </section>
    
</body>
</html>