<?php
session_start();

$userInputCode = $_POST['verification1'];
$generatedCode = $_SESSION['email_code']; 
$email = $_SESSION["email"];
$token = $_SESSION['token'];
// 进行验证

if ($userInputCode === $generatedCode) { 
   header("Location:emailaction.php");
   exit;
} else {
   header("Location:emailregister.php?err=5");
}
?>