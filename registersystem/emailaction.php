<?php
session_start();
$email = $_SESSION['email'];
$username = $_SESSION['username'];
$token = $_SESSION['token'];

require "../conn.php";
$stmt = $conn->prepare("SELECT email FROM email WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$ret = $stmt->get_result();
$num = $ret->num_rows;
if ($num < 1) {
    if (!empty($token)) {
        $stmt1 = $conn->prepare("UPDATE email SET email = ? WHERE username = ?");
        $stmt1->bind_param("ss", $username, $email);
        $stmt1->execute();
        header("Location:emailregister.php?err=6");
        
    } else {
        $stmt1 = $conn->prepare("INSERT INTO email (email, username) VALUES (?, ?)");
        $stmt1->bind_param("ss", $email, $username);
        $stmt1->execute();
        header("Location:emailregister.php?err=3");
    }
} else {
    $stmt2 = $conn->prepare("UPDATE email SET email = ? WHERE username = ?");
    $stmt2->bind_param("ss", $username, $email);
    $stmt2->execute();
    header("Location:emailregister.php?err=4");
}
