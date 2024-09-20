<?php
session_start();

$userInputCode = $_POST['verification2'];
$code = $_SESSION['code']; 
$phone = $_SESSION['phone'];
// 进行验证

if ((int)$userInputCode === (int)$code) { 
   header("Location:phoneaction.php");
   exit;
} else {
   header("Location:phoneregister.php?err=16");
}
?>