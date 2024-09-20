<?php
session_start();
$username = $_SESSION['username'];

$url = isset($_GET['url']) ? $_GET['url'] : '';
$html = file_get_contents($url);
preg_match("/<title>(.*?)<\/title>/i", $html, $matches);
$filename = $matches[1];

require 'conn.php';
$stmt1 = $conn->prepare("SELECT account FROM account WHERE username = ?");
$stmt1->bind_param("s", $username);
$stmt1->execute();
$res1 = $stmt1->get_result();
$row = $res1->fetch_assoc();
$account = $row['account'];

$stmt = $conn->prepare("SELECT * FROM file WHERE fileurl = ? AND username = ?");
$stmt->bind_param("ss", $url, $username);
$stmt->execute();
$result = $stmt->get_result();

$stmt1 = $conn->prepare("SELECT email FROM email WHERE username = ?");
$stmt1->bind_param("s", $username);
$stmt1->execute();
$res1 = $stmt1->get_result();
$row = $res1->fetch_assoc();
$email = $row['email'];

if ($account < 0) {
    header('Location: dowmload.php?err=1');
    exit();
} 

if (empty($email)) {
    header('Location: download.php?err=4');
    exit();
}

if ($result->num_rows > 0) {
    header('Location: download.php?err=2');
    exit();
} else {
    require 'conn.php';
    
    $stmt2 = $conn->prepare("UPDATE account SET account = account - 1 WHERE username = ?");
    $stmt2->bind_param("s", $username);
    $stmt2->execute();

    $stmt = $conn->prepare("INSERT INTO file (username, filename, fileurl, status) VALUES (?, ?, ?, 0)");
    $stmt->bind_param("sss", $username, $filename, $url);
    $stmt->execute();
    header('Location: download.php?err=3');
}
?>