<?php
require '../vendor/autoload.php';

use Aliyun\Api\Sms\Request\V20170525 as SmsDemo;

ini_set('session.cookie_lifetime', 300);
session_start();

$cooldownSeconds = 60; // 冷却时间为120秒
$lastSentTime = isset($_SESSION['last_sent_time']) ? $_SESSION['last_sent_time'] : 0;
$currentTime = time();

if ($currentTime - $lastSentTime < $cooldownSeconds) {
       header("Location:phoneregister.php?err=15");
       exit;
}

$phone = $_POST['phone'];
$_SESSION['phone'] = $phone;

$username = $_SESSION['username'];
require "../conn.php";
$stmt = $conn->prepare("SELECT phone FROM phone WHERE phone = ? AND username != ?");
$stmt->bind_param("ss", $phone, $username);
$stmt->execute();
$res1 = $stmt->get_result();
$phone2 = $res1->fetch_assoc();
if ($phone2) {
       header("Location:phoneregister.php?err=12");
       exit;
}

$code = rand(111111, 999999);
$send = SmsDemo::sendSms($phone, $code);

if ($send->Code == "OK") {
       header("Location:phoneregister.php?err=8");

       $_SESSION['last_sent_time'] = $currentTime;
       $_SESSION['code'] = $code;
       $_SESSION['phone'] = $_POST["phone"];
} else {
       header("Location:phoneregister.php?err=9");
}
