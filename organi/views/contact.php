<?php
include "../PHPMailer/src/PHPMailer.php";
include "../PHPMailer/src/Exception.php";
// include "../PHPMailer/src/OAuth.php";
include "../PHPMailer/src/POP3.php";
include "../PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
    if(isset($_POST["send"])){
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
            $mail->addAddress('hangt7708@gmail.com');     // Địa chỉ người nhận
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Nếu muốn gửi thêm tệp thì uncomment dòng này
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Và cả dòng này nữa nếu gửi trên một file

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Contact from '.$_POST["name"];                             // Tiêu đề
            $mail->Body = 'From: '.$_POST["email"].$_POST["content"];                      // Nội dung
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            echo '<script>alert("Phản hồi của bạn đã được gửi!")</script>';
            // echo 'Message has been sent';
        } catch (Exception $e) {
            // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

    }
?>
<?php
$article_cat = $connect->query("select * from article_categories");
?>

<h3 style="text-align: center">Liên hệ với chúng tôi</h3>
<section class="container col-md-6">
    <form method="post" enctype="multipart/form-data">
        
        <section class="form-group">
            Họ và tên: <input name="name" class="form-control">
        </section>
        
        <section class="form-group">
            <label>Email: </label>
            <textarea style="width: 100%" cols="5" id="summary" name="email"></textarea>
        </section>
        <section class="form-group">
            <label>Nội dung: </label>
            <textarea id="contact" name="content"></textarea>
        </section>
        <section>
            <input type="submit" name="send" value="Gửi" class="btn btn-success">
        </section>
    </form>
</section>