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
             echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

    }
?>
<?php
$article_cat = $connect->query("select * from article_categories");
?>

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Liên hệ</h2>
                        <div class="breadcrumb__option">
                            <a href="?option=home">Home</a>
                            <span>Liên hệ với chúng tôi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_phone"></span>
                        <h4>Điện thoại</h4>
                        <p>+01-3-8888-6868</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_pin_alt"></span>
                        <h4>Địa chỉ</h4>
                        <p>Đại học Công Nghiệp Hà Nội</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_clock_alt"></span>
                        <h4>Open time</h4>
                        <p>10:00 am to 23:00 pm</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_mail_alt"></span>
                        <h4>Email</h4>
                        <p>starbook@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Map Begin -->
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7446.9475896511685!2d105.73166127368222!3d21.053730725802723!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31345457e292d5bf%3A0x20ac91c94d74439a!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2hp4buHcCBIw6AgTuG7mWk!5e0!3m2!1svi!2s!4v1700982337261!5m2!1svi!2s" height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
    <!-- Map End -->

    <!-- Contact Form Begin -->
    <div class="contact-form spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__form__title">
                        <h2>Để lại tin nhắn</h2>
                    </div>
                </div>
            </div>
            <form method="post">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <input type="text" name="name" placeholder="Tên của bạn">
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <input type="text" name="email" placeholder="Email">
                    </div>
                    <div class="col-lg-12 text-center">
                        <textarea placeholder="Tin nhắn" name="content"></textarea>
                        <input type="submit" name="send" class="btn btn-success w-50 text-white" value="GỬI MAIL"/>
                    </div>
                </div>
            </form>
        </div>
    </div>