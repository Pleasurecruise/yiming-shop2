<?php
require "../conn.php";
$username = $_POST['username'];
$password = $_POST['password'];
$stmt = $conn->prepare("SELECT username,password FROM content WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$res = $stmt->get_result();
$rows = $res->num_rows;

$stmt1 = $conn->prepare("SELECT endtime FROM subscribe WHERE username = ?");
$stmt1->bind_param("s", $username);
$stmt1->execute();
$res1 = $stmt1->get_result();
$row = $res1->fetch_assoc();
$endtime = new DateTime($row['endtime']);
$now = new DateTime();

if ($rows == 1) {
    session_start();
    $_SESSION['username'] = $username;
    if ($endtime->format('Y-m-d H:i:s') == '-0001-11-30 00:00:00') {
        $_SESSION['remaining'] = DateInterval::createFromDateString('0 days');
    } else {
        $_SESSION['remaining'] = $now->diff($endtime, true);
    }
    header('refresh: 0;url=./loginsuccess.php');
    exit;
} else {
    header('refresh: 0;url=./loginfail.php');
}
?>
