<?php
require "../conn.php";
session_start();
$username = $_SESSION['username'];

$stmt1 = $conn->prepare("SELECT account FROM account WHERE username = ?");
$stmt1->bind_param("s", $username);
$stmt1->execute();
$res1 = $stmt1->get_result();
$row = $res1->fetch_assoc();
$account = $row['account'];

if ($account < 10) {
    header("Location: resource.php?err=1");
} else {
    $stmt = $conn->prepare("UPDATE account SET account = account - 10 WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT username FROM epicglobal WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        header("Location: resource.php?err=2");
        exit;
    } else {

        $stmt = $conn->prepare("INSERT INTO epicglobal (username) VALUES (?)");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $file = 'EpicGlobal_[V31-6].zip';
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        header("Location: resource.php?err=3");

        exit;
    }
}
