<?php
session_start();
$input = $_SESSION['input'];
$username = $_SESSION['username'];
$token = $_SESSION['token'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>重置密码</title>
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
        <h1 class="h3 mb-3 font-weight-normal">Please enter the phone number or email address associated with your account</h1><br>

        <form class="form-signin" id="loginform" action="./action.php" method="post">
            <div style="display: flex; align-items: center;">
                <input type="text" id="text" class="form-control" name="text" required="required" value="<?php echo $input ?>" placeholder="Target Adress" required autofocus>
                <button class="btn btn-md btn-secondary" id="buttonfirst" type="button" name="send">Send</button>
            </div>
        </form>
        <div class="modal fade" id="captchaModal" tabindex="-1" aria-labelledby="captchaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="captchaModalLabel">验证码</h5>
                    </div>
                    <div class="modal-body">
                        <div id="rotateWrap" style="margin-top:50px;">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p>
            <?php
            $err = isset($_GET["err"]) ? $_GET["err"] : "";
            switch ($err) {
                case 1:
                    echo "地址格式不正确！";
                    break;

                case 2:
                    echo "发送成功！";
                    break;

                case 3:
                    echo "发送失败！";
                    break;

                case 4:
                    echo "请等待一分钟后再试！";
                    break;

                case 5:
                    echo "该手机号未绑定！";
                    break;

                case 6:
                    echo "该邮箱未绑定！";
                    break;
            }
            ?>
        </p>
        <form class="form-signin" id="loginform" action="passwordcheck.php" method="post">
            <div style="display: flex; align-items: center;">
                <input type="text" id="verification2" class="form-control" name="verification2" required="required" value="" placeholder="Verification Code" required autofocus>
                <button class="btn btn-md btn-secondary" id="buttonfirst" type="submit" name="send">Sure</button>
            </div>
        </form>
        <p>
            <?php
            $err = isset($_GET["err"]) ? $_GET["err"] : "";
            switch ($err) {
                case 7:
                    echo "验证成功！";
                    header("refresh:1; url=passwordreset.php");
                    break;

                case 8:
                    echo "验证失败！";
                    header('Refresh: 1; url=../index1.html');
                    exit();
                    break;
            }
            ?>
        </p>
    </div>
</body>
<script src="../jqRotateVerify.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var myRotateVerify;
    var isVerified = false;
    var shouldSubmit = false;

    $(document).ready(function() {
        $('#buttonfirst').click(function() {
            $('#captchaModal').modal('show');
            myRotateVerify.resetSlide();
        });

        $('#loginform').submit(function(e) {
            var input = $('#text').val();
            var phonePattern = /^1[3-9]\d{9}$/;
            var emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            
            if (!phonePattern.test(input) && !emailPattern.test(input)) {
                window.location.replace("password.php?err=1");
                return false;
            } else if (!isVerified) {
                e.preventDefault();
            } else if (shouldSubmit) {
                return true;
            } else {
                e.preventDefault();
                $('#buttonfirst').click(); // 触发滑块验证
            }
        });
    });

    $(function() {
        myRotateVerify = new RotateVerify('#rotateWrap', {
            initText: '滑动将图片转正',
            slideImage: ['../image/1.jpg', '../image/2.jpg', '../image/3.jpg'],
            slideAreaNum: 10, // 误差范围角度 +- 10(默认)
            getSuccessState: function(res) {
                if (res) {
                    isVerified = true;
                    shouldSubmit = true;
                    $('#loginform').submit();
                    $('#captchaModal').modal('hide');
                }
            }
        })
    });
</script>

</html>