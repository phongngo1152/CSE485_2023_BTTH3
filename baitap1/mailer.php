<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>
<body>
<?php
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'vendor/autoload.php';

    interface EmailServerInterface {
        public function sendEmail($to, $subject, $message);
    }


    class EmailSender {
        private $emailServer;

        public function __construct(EmailServerInterface $emailServer) {
            $this->emailServer = $emailServer;
        }

        public function send($to, $subject, $message) {
            $this->emailServer->sendEmail($to, $subject, $message);
        }
    }


    class MyEmailServer implements EmailServerInterface {
        public function sendEmail($to, $subject, $message) {
            // Implementation to send email using MyEmailServer
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'ssl://smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'nihilis9999@gmail.com';                     // SMTP username
                $mail->Password   = 'lmavjpkclxpwotuf';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 465;    
                $mail->CharSet = "utf-8";                                // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('nihilis9999@gmail.com', 'Nguyễn Đức Anh');
                $mail->addAddress($to, 'First Person');     // Add a recipient
                // $mail->addAddress($to, 'Second Person');     // Add a recipient
                // $mail->addAddress($to, 'Third Person');     // Add a recipient
                // $mail->addAddress($to, 'Fourth Person');     // Add a recipient

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body = $message;

                $mail->send();
                echo "<p style='red'>Message has been sent</p>";
            } catch (Exception $e) {
                echo "<p style='blue'>Message could not be sent. Mailer Error: {".$mail->ErrorInfo."}</p>";
            }
        }
    }
?>
<style>
    form{
        display: inline-block;
        width: 50%;
    }
    div{
        /* width: 100%; */
        /* padding: 10px; */
        margin-bottom: 10px;

    }
    p{
        display: inline-block;

        width: 20%;
    }
    input{
        display: inline-block;
        height: 100%;
        width: 70%;
    }
    Textarea{
        height: 100%;
        width: 70%;
    }
    
</style>
<form action="mailer.php" method="POST">
    <div><p>Người nhận:</p> <input type="email" name="txtMail" id=""></div>
    <div><p>Tiêu đề:</p> <input type="text" name="txtTieuDe" id=""></div>
    <div><p>Nội dung:</p> <Textarea name="txtNoiDung"></Textarea></div>
    
    <button type='submit'>Gửi</button>
    
</form>
<?php
        // "<form action='Demo_DependencyInjection.php' method='POST'>
        // Người nhận: <input type='email' name='txtMail' id=''>
        // Tiêu đề: <input type='text' name='txtTieuDe' id=''>
        // Nội dung: <Textarea name='txtNoiDung'></Textarea>
        // <button type='submit'>Gửi</button>

        // </form>";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $mail = $_POST['txtMail'];
            $tieude = $_POST['txtTieuDe'];
            $noidung = $_POST['txtNoiDung'];
            $emailServer = new MyEmailServer();
            $emailSender = new EmailSender($emailServer);
            $emailSender->send($mail, $tieude, $noidung);
        }
?>
</body>
</html>