<?php
session_start();
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
if (isset($_SESSION['username'])) { ?>
  <!DOCTYPE html>
  <html>

  <head>
    <title>手机注册或更新</title>
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
      <h1 class="h3 mb-3 font-weight-normal">Please register/change here</h1><br>

      <form class="form-signin" id="loginform" action="./phone.php" method="post">
        <div style="display: flex; align-items: center;">
          <input type="phone" id="phone" class="form-control" name="phone" required="required" value="<?php echo $phone ?>" placeholder="Phone Number" required autofocus>
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
          case 8:
            echo "发送成功！";
            break;

          case 9:
            echo "发送失败！";
            break;

          case 12:
            echo "该手机号已被注册！";
            break;

          case 14:
            echo "手机号格式错误！";
            break;

          case 15:
            echo "请等待1分钟后再试！";
            break;
        }
        ?>
      </p>
      <form class="form-signin" id="loginform" action="./phonecheck.php" method="post">
        <div style="display: flex; align-items: center;">
          <input type="text" id="verification2" class="form-control" name="verification2" required="required" value="" placeholder="Verification Code" required autofocus>
          <button class="btn btn-md btn-secondary" id="buttonfirst" type="submit" name="send">Sure</button>
        </div>
      </form>
      <p>
        <?php
        $err = isset($_GET["err"]) ? $_GET["err"] : "";
        switch ($err) {
          case 10:
            echo "验证成功！";
            header('Refresh: 1; URL=../index.php');
            exit();
            break;

          case 11:
            echo "手机号更新成功！";
            header('Refresh: 1; URL=../index.php');
            exit();
            break;

          case 16:
            echo "验证失败！";
            break;
        }
        ?>
      </p>
    </div>
  </body>
  <script src="../jqRotateVerify.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript">
    var myRotateVerify;
    var isVerified = false; // 添加一个变量来记录滑块验证是否通过
    var shouldSubmit = false; // 添加一个变量来跟踪是否应该提交表单

    $(document).ready(function() {
      $('#buttonfirst').click(function() {
        $('#captchaModal').modal('show');
        myRotateVerify.resetSlide();
      });

      $('#loginform').submit(function(e) {
        var phone = $('#phone').val();
        if (!/^1[3-9]\d{9}$/.test(phone)) {
          window.location.replace("phoneregister.php?err=14");
          return false;
        } else if (!isVerified) { // 检查滑块验证是否通过
          e.preventDefault();
        } else if (shouldSubmit) { // 如果应该提交表单，则允许表单提交
          return true;
        } else {
          e.preventDefault();
          $('#buttonfirst').click(); // 触发滑块验证
        }
      });
    });

    $(function() {
      myRotateVerify = new RotateVerify('#rotateWrap', {
        initText: '滑动将图片转正', //默认
        slideImage: ['../image/1.jpg', '../image/2.jpg', '../image/3.jpg'], //arr  [imgsrc1,imgsrc2] 或者str 'imgsrc1'
        slideAreaNum: 10, // 误差范围角度 +- 10(默认)
        getSuccessState: function(res) { //验证通过 返回  true;
          if (res) {
            isVerified = true; // 当滑块验证通过时，更新 isVerified 变量的值
            shouldSubmit = true; // 设置应该提交表单的标志为 true
            $('#loginform').submit(); // 提交表单
            $('#captchaModal').modal('hide');
          }
        }
      })
    });
  </script>

  </html>
<?php
} else {
  header('Location: ./index1.html');
  exit;
}
?>