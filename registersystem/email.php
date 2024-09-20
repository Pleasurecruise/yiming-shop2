<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-6.9.1/src/Exception.php';
require '../PHPMailer-6.9.1/src/PHPMailer.php';
require '../PHPMailer-6.9.1/src/SMTP.php';

function generateRandomCode()
{
    $code = '';
    for ($i = 0; $i < 6; $i++) {
        $code .= mt_rand(0, 9);
    }
    return $code;
}

$randomCode = generateRandomCode();

if (isset($_POST['send'])) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.exmail.qq.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'pleasure@yiming1234.com';
    $mail->Password = '';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('pleasure@yiming1234.com');

    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);

    $mail->Subject = "Verification Code";
    $mail->Body = "感谢您光临一鸣的小站,请在5分钟内使用验证码，祝您生活愉快。您的验证码是：$randomCode ";



    ini_set('session.cookie_lifetime', 300);
    session_start();
    $_SESSION['email_code'] = $randomCode;
    $_SESSION['email'] = $_POST["email"];
    $username = $_SESSION['username'];
    $email = $_POST["email"];
    $token = $_SESSION['token'];

    require "../conn.php";
    $stmt = $conn->prepare("SELECT email FROM email WHERE email = ? AND username != ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $res1 = $stmt->get_result();
    $email2 = $res1->fetch_assoc();

    if ($email2['email'] == $_POST['email']) {
        header("Location:emailregister.php?err=13");
        exit;
    }
    if ($mail->send()) {
        header("Location:emailregister.php?err=1");
    } else {
        header("Location:emailregister.php?err=2");
    }
}
