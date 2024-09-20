<?php

session_start();
$_SESSION['emailcode'] = $emailcode;
$input = $_SESSION['input'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-6.9.1/src/Exception.php';
require '../PHPMailer-6.9.1/src/PHPMailer.php';
require '../PHPMailer-6.9.1/src/SMTP.php';

function sendEmail($input, $emailcode)
{
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.exmail.qq.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pleasure@yiming1234.com';
        $mail->Password = '';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('pleasure@yiming1234.com');

        $mail->addAddress($input);

        $mail->isHTML(true);

        $mail->Subject = "Verification Code";
        $mail->Body = "感谢您光临一鸣的小站,您正在重置密码，请在5分钟内使用验证码，如非本人操作请忽略。祝您生活愉快。您用于重置密码的验证码是： $emailcode";

        session_start();
        ini_set('session.cookie_lifetime', 300);
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
?>
