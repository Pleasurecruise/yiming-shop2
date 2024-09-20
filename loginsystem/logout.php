<?php
session_start();
if (isset($_SESSION['username'])) {
    session_destroy();
    header('refresh: 0;url=../index.php');
} else {
    header('refresh: 0;url=../index.php');
}
?>