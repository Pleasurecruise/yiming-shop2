<?php
require "../conn.php";
session_start();
$username = $_SESSION['username'];

$stmt1 = $conn->prepare("SELECT account FROM account WHERE username = ?");
$stmt1->bind_param("s", $username);
$stmt1->execute();
$res1 = $stmt1->get_result();
$row1 = $res1->fetch_assoc();
$account = $row1['account'];

$stmt = $conn->prepare("SELECT COUNT(*) FROM node WHERE username = ''");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_array();
$remain = $row[0];

if ($account < 10) {
    header("Location: shopcenter.php?err=5");
} else {
    $stmt2 = $conn->prepare("SELECT website FROM node ORDER BY id LIMIT 1");
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    $row2 = $res2->fetch_assoc();
    $website = $row2['website'];

    $stmt5 = $conn->prepare("SELECT * FROM node WHERE username = ?");
    $stmt5->bind_param("s", $username);
    $stmt5->execute();
    $res5 = $stmt5->get_result();
    if ($res5->num_rows > 0) {
        $row5 = $res5->fetch_assoc();
        $website = $row5['website'];
        header("Location: shopcenter.php?err=6&website=" . urlencode($website));
        exit;
    } elseif($remain == 0){
        header("Location: shopcenter.php?err=8");
        exit;
    }else{
        $stmt4 = $conn->prepare("UPDATE account SET account = account - 10 WHERE username = ?");
        $stmt4->bind_param("s", $username);
        $stmt4->execute();    
        
        $stmt3 = $conn->prepare("UPDATE node SET username = ? WHERE website = ?");
        $stmt3->bind_param("ss", $username, $website);
        $stmt3->execute();
        header("Location: shopcenter.php?err=7&website=" . urlencode($website));
        exit;
    }
}
