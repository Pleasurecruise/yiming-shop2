<?php
session_start();
$username = $_SESSION['username'];
$phone = $_SESSION['phone'];

require "../conn.php";
$stmt = $conn->prepare("SELECT phone FROM phone WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$ret = $stmt->get_result();
$num = $ret->num_rows;
if ($num < 1) {
    $stmt1 = $conn->prepare("INSERT INTO phone (phone, username) VALUES (?, ?)");
    $stmt1->bind_param("ss", $phone, $username);
    $stmt1->execute();
    header("Location:phoneregister.php?err=10");
} else {
    $stmt2 = $conn->prepare("UPDATE phone SET phone = ? WHERE username = ?");
    $stmt2->bind_param("ss", $username, $phone);
    $stmt2->execute();
    header("Location:phoneregister.php?err=11");
}
