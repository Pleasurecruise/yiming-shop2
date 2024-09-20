<?php
session_start();
$username = $_SESSION['username'];
$userAvatarPath = "./uploads/" . $username . ".jpg";
$defaultAvatarPath = "./uploads/avatar.jpg";
if (isset($_SESSION['username'])) { ?>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="applicable-device" content="pc,mobile">
        <link href="/favicon.ico" rel="shortcut icon" />
        <title>Account Recharge</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/m_reset.css" />
    </head>

    <body>
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-sx-12">
                    <div class="content">
                        <div class="content-head" align="center">
                            <div id='weixin-notice'><img id='paytest' height="220px" width="220px" src="https://www.xunhupay.com/wp-content/themes/hupijiao/images/web.svg"></div>
                            <form action="payment.php" method="post">
                                <div class="radio">
                                    <input type="radio" name="type" value="alipay">Alipay
                                </div>
                                </br>
                                <input id="price" type="text" name="price" class="" placeholder="Recharge Amount" required="请输入金额" />
                                </br>
                                </br>
                                <input type="submit" value="Pay Now" class="buy-button" style="width: 100px;" />
                            </form>
                        </div>
                    </div>

                    <div class="foot">
                        <p></p>
                    </div>
                </div>

            </div>
        </div>
    </body>

    </html>
<?php
} else {
    header('Location: ./index1.html');
    exit;
}
?>