<?php
session_start();
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$token = isset($_SESSION['token']) ? $_SESSION['token'] : '';
if (isset($_SESSION['username'])) { ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>邮箱注册或更新</title>
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
    </head>

    <body class="text-center">
        <div class="form-signin" id="loginform">
            <img class="mb-4" src="../picture/avatar2.jpg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Please register/change here</h1><br>

            <form class="form-signin" id="loginform" action="./email.php" method="post">
                <div style="display: flex; align-items: center;">
                    <input type="email" id="email" class="form-control" name="email" required="required" value="<?php echo $email ?>" placeholder="Email" required autofocus>
                    <button class="btn btn-md btn-secondary" id="buttonefirst" type="submit" name="send">Send</button>
                </div>
            </form>
            <p>
                <?php
                $err = isset($_GET["err"]) ? $_GET["err"] : "";
                switch ($err) {
                    case 1:
                        echo "<br>发送成功！";
                        break;

                    case 2:
                        echo "<br>发送失败！";
                        break;

                    case 13:
                        echo "<br>该邮箱已被注册！";
                        break;
                }
                ?>
            </p>
            <form class="form-signin" id="loginform" action="./emailcheck.php" method="post">
                <div style="display: flex; align-items: center;">
                    <input type="text" id="verification1" class="form-control" name="verification1" required="required" value="" placeholder="Email Verification Code" required autofocus>
                    <button class="btn btn-md btn-secondary" id="buttonfirst" type="submit" name="send">Sure</button>
                </div>
            </form>
            <p>
                <?php
                $err = isset($_GET["err"]) ? $_GET["err"] : "";
                switch ($err) {
                    case 3:
                        echo "<br>验证成功！";
                        break;

                    case 4:
                        echo "<br>邮箱更新成功！";
                        header('Refresh: 3; URL=../index.php');
                        exit();
                        break;

                    case 5:
                        echo "<br>验证失败！";
                        break;

                    case 6:
                        echo "<br>验证成功！请返回登录界面登录！";
                        header('Refresh: 3; URL=../index1.html');
                        exit();
                        break;
                }
                ?>
            </p>
        </div>
    </body>

    </html>
<?php
} else {
    header('Location: ../index1.html');
    exit;
}
?>