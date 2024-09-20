<?php
session_start();
$username = $_SESSION['username'];
$param['price'] = $_SESSION['total_fee'];
$userAvatarPath = "./uploads/" . $username . ".jpg";
$defaultAvatarPath = "./uploads/avatar.jpg";
if (isset($_SESSION['username'])) { ?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Account Recharge</title>
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="css/weui.css">
        <link rel="stylesheet" href="css/weuix.css">
        <style>
            .page-bg {
                max-width: 750px;
                margin: 0 auto;
            }

            .weui-cells {
                margin-top: 0;
                border: 1px solid #eee;
                border-radius: 1em;
            }

            .bgc-b {
                background-color: #fff;
            }
        </style>
    </head>

    <body class="page-bg">
        <div class="weui-msg">
            <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
            <div class="weui-msg__text-area">
                <h2 class="weui-msg__title">Payment Successful</h2>
            </div>
            <div class="weui-msg__opr-area">
                <p class="weui-btn-area">
                    <a href="https://shop2.yiming1234.cn/index.php" class="weui-btn weui-btn_primary">Back to Personal Center</a>
                </p>
            </div>
        </div>
        <div class="weui-footer weui-footer_fixed-bottom">
            <p class="weui-footer__text"></p>
        </div>
    </body>

    </html>
    <?php require "../conn.php";
    $stmt1 = $conn->prepare("UPDATE account SET account = account + ? WHERE username = ?");
    $stmt1->bind_param("ds", $param['price'], $username);
    $stmt1->execute();
    if (isset($_SESSION['total_fee'])) {
        unset($_SESSION['total_fee']);
    } ?>
<?php
} else {
    header('Location: ../index1.html');
    exit;
}
?>