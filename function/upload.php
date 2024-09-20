<?php
session_start();
$username = $_SESSION['username'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = '../uploads/';
        $allowedExtensions = array('jpg');
        $maxFileSize = 500000;
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $newFileName = $username . '.' . $imageFileType;
        $targetFile = $uploadDir . $newFileName;
        if(!in_array($imageFileType, $allowedExtensions)){
            header('Location: ../index.php?err=2');
            exit();
        }
        if($_FILES['image']['size'] > $maxFileSize){
            header('Location: ../index.php?err=3');
            exit();
        }
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            header('Location: ../index.php?err=1');
        } else {
            header('Location: ../index.php?err=4');
        }
    } else {
        header('Location: ../index.php?err=5');
    }
}
?>