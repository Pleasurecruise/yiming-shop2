<?php
session_start();
require "../conn.php";

$input = $_SESSION['input'];
$type = $_SESSION['type'];
$phonecode = $_SESSION['phonecode'];
$emailcode = $_SESSION['emailcode'];
$code = $_POST['verification2'];

$token = bin2hex(random_bytes(32));
$_SESSION['token'] = $token;

if ($code == $phonecode || $code == $emailcode) {
    if ($type == "phone") {
        $stmt = $conn->prepare("SELECT username FROM phone WHERE phone = ?");
        $stmt->bind_param("s", $input);
        $stmt->execute();
        $res1 = $stmt->get_result();
        $username = $res1->fetch_assoc();
        $_SESSION['username'] = $username;
    } else if ($type == "email") {
        $stmt = $conn->prepare("SELECT username FROM email WHERE email = ?");
        $stmt->bind_param("s", $input);
        $stmt->execute();
        $res1 = $stmt->get_result();
        $username = $res1->fetch_assoc();
        $_SESSION['username'] = $username['username'];
    } 
    header("Location:password.php?err=7");
    exit;
} else {
    header("Location:password.php?err=8");
    exit;
}
?>