<?php
session_start();
$input = $_SESSION['input'];
$username = $_SESSION['username'];

require "../conn.php";
$password = $_POST['password'];
$repassword = $_POST['repassword'];

function isPasswordComplex($password) {
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        return false;
    } else {
        return true;
    }
}

if ($password == $repassword) {
    if (isPasswordComplex($password)) {
        $stmt = $conn->prepare("UPDATE content SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $password, $username);
        $stmt->execute();
        header('refresh: 0;url=passwordreset.php?err=2');
    } else {
        header('refresh: 0;url=passwordreset.php?err=4');
    }
}else{
    header('refresh: 0;url=passwordreset.php?err=1');
}
?>