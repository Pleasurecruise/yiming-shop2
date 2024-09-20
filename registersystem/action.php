<?php
function identifyInput($input)
{
    $phonePattern = "/^1[34578]\d{9}$/";
    $emailPattern = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/";

    if (preg_match($phonePattern, $input)) {
        return "phone";
    } else if (preg_match($emailPattern, $input)) {
        return "email";
    } else {
        return "unknown";
    }
}

$input = $_POST["text"];
$type = identifyInput($input);
session_start();
$_SESSION['input'] = $input;
$_SESSION['type'] = $type;
if ($type == "phone") {
    require "../conn.php";
    $stmt = $conn->prepare("SELECT phone FROM phone WHERE phone = ?");
    $stmt->bind_param("s", $input);
    $stmt->execute();
    $res1 = $stmt->get_result();
    $phone2 = $res1->fetch_assoc();
    if ($phone2) {
        $now = time();
        if (isset($_SESSION['last_send_time']) && $now - $_SESSION['last_send_time'] < 60) {
            header("Location:password.php?err=4");
            exit;
        }
        
        $phonecode = rand(111111, 999999);
        $send = SmsDemo::sendSms($input, $phonecode);

        if ($send->Code == "OK") {
            $_SESSION['last_send_time'] = $now;
            header("Location:password.php?err=2");
            $_SESSION['phonecode'] = $phonecode;

        } else {
            header("Location:password.php?err=3");
        }
        exit;
    }else{
        header("Location:password.php?err=5");
    }
} else if ($type == "email") {
    require "../conn.php";
    $stmt = $conn->prepare("SELECT email FROM email WHERE email = ?");
    $stmt->bind_param("s", $input);
    $stmt->execute();
    $res1 = $stmt->get_result();
    $email2 = $res1->fetch_assoc();
    if ($email2) {
        $emailcode = rand(100000, 999999);
        require 'email2.php';
        $emailSent = sendEmail($input, $emailcode);
        if ($emailSent) {
            header("Location:password.php?err=2");
            $_SESSION['emailcode'] = $emailcode;
        } else {
            header("Location:password.php?err=3");
        }
        exit;
    }else{
        header("Location:password.php?err=6");
    }
} else {
    header("Location:password.php?err=1");
}
