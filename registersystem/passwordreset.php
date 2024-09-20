<?php
session_start();
if (!isset($_SESSION['token'])) {
    header('Location: index1.html');
    exit();
}else{
    $input = $_SESSION['input'];
    $username = $_SESSION['username'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>账户密码重置</title>
    <meta name="content-type" ; charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <link rel="icon" href="../picture/avatar2.jpg" type="image">
    <link href="../bootstrap.css" rel="stylesheet">
    <link href="../loginsystem/signin.css" rel="stylesheet">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body class="text-center">
    <div class="form-signin" id="signinform">
        <img class="mb-4" src="../picture/avatar2.jpg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Please change your password here</h1><br>
        <p>Your previous username is: <?php echo $username?></p>
        <form class="form-signin" id="loginform" action="resetaction.php" method="post">
            <input type="password" id="password" class="form-control" name="password" required="required" value="" placeholder="New Password" required autofocus>
            <input type="password" id="repassword" class="form-control" name="repassword" required="required" value="" placeholder="Re-password" required autofocus>
            <br><button class="btn btn-md btn-primary btn-block" id="buttonfirst" type="submit" name="send">Change</button>
        </form>
        <p>
            <?php
            $err = isset($_GET["err"]) ? $_GET["err"] : "";
            switch ($err) {
                case 1:
                    echo "请输入相同的密码！";
                    break;
                case 2:
                    echo "密码修改成功！";
                    header('refresh: 1;url=../index1.html');
                    break;
                case 3:
                    echo "密码修改失败！";
                    break;

                case 4:
                    echo "密码需包含：大小写英文字母，数字和特殊字符！";
                    break;
            }
            ?>
        </p>
    </div>
</body>

</html>