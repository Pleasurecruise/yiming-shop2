<?php
require "./conn.php";
session_start();
$username = $_SESSION['username'];

$stmt1 = $conn->prepare("SELECT account FROM account WHERE username = ?");
$stmt1->bind_param("s", $username);
$stmt1->execute();
$res1 = $stmt1->get_result();
$row = $res1->fetch_assoc();
$account = $row['account'];

if ($account < 10) {
    header("Location: shopcenter.php?err=1");
} else {
    $stmt2 = $conn->prepare("SELECT starttime FROM subscribe WHERE username = ?");
    $stmt2->bind_param("s", $username);
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    $row = $res2->fetch_assoc();
    $starttime = new DateTime($row['starttime']);
    $endtime = new DateTime($row['starttime']);
    $endtime->add(new DateInterval('P30D'));
    $now = new DateTime();
    if (new DateTime() > $starttime && new DateTime() < $endtime) {
        header("Location: shopcenter.php?err=1");
        exit();
    } else {
        $stmt3 = $conn->prepare("UPDATE account SET account = account - 10 WHERE username = ?");
        $stmt3->bind_param("s", $username);
        $stmt3->execute();

        $stmt4 = $conn->prepare("UPDATE subscribe SET starttime = NOW() WHERE username = ?");
        $stmt4->bind_param("s", $username);
        $stmt4->execute();

        $Endtime = new DateTime();
        $Endtime->add(new DateInterval('P30D'));
        $stmt5 = $conn->prepare("UPDATE subscribe SET endtime = ? WHERE username = ?");
        $stmt5->bind_param("ss", $Endtime->format('Y-m-d H:i:s'), $username);
        $stmt5->execute();

        $_SESSION['remaining'] = $now->diff($endtime, true);
        header("Location: shopcenter.php?err=3");
    }
}
