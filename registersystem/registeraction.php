<?php
$username = $_POST['username'];
$password = $_POST['password'];
$re_password = $_POST['re_password'];
require "../conn.php";

function isPasswordComplex($password)
{
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        return false;
    } else {
        return true;
    }
}

if ($password == $re_password) {

    if (isPasswordComplex($password)) {
        $stmt_select = $conn->prepare("SELECT username FROM content WHERE username = ?");
        $stmt_select->bind_param("s", $username);
        $stmt_select->execute();
        $ret = $stmt_select->get_result();
        $num = $ret->num_rows;
        if ($num < 1) {
            $stmt_insert_content = $conn->prepare("INSERT INTO content (username,password) VALUES(?,?)");
            $stmt_insert_content->bind_param("ss", $username, $password);
            $stmt_insert_content->execute();
            $result = $stmt_insert_content->get_result();

            $stmt_insert_account = $conn->prepare("INSERT INTO account (username) VALUES(?)");
            $stmt_insert_account->bind_param("s", $username);
            $stmt_insert_account->execute();

            $stmt_insert_email = $conn->prepare("INSERT INTO email (username) VALUES(?)");
            $stmt_insert_email->bind_param("s", $username);
            $stmt_insert_email->execute();

            $stmt_insert_phone = $conn->prepare("INSERT INTO phone (username) VALUES(?)");
            $stmt_insert_phone->bind_param("s", $username);
            $stmt_insert_phone->execute();

            $stmt_insert_subscribe = $conn->prepare("INSERT INTO subscribe (username) VALUES(?)");
            $stmt_insert_subscribe->bind_param("s", $username);
            $stmt_insert_subscribe->execute();

            if ($stmt_insert_content->affected_rows > 0) {
                session_start();
                $_SESSION['username'] = $username;
                $remaining = new DateTime('1000-01-01 00:00:00');
                $_SESSION['remaining'] = $remaining;
                $token = bin2hex(random_bytes(16));
                $_SESSION['token'] = $token;
                header('refresh: 0;url=./registersuccess.php');
                exit;
            } else {
                header('refresh: 0;url=./loginfail.php');
            }
        } else {
            header('refresh: 0;url=./loginexit.php');
        }
    } else {
        header('refresh: 0;url=./registerfail.php');
    }
} else {
    header('refresh: 0;url=./registerfail2.php');
}
