<?php
session_start();
$username = $_SESSION['username'];
$userAvatarPath = "./uploads/" . $username . ".jpg";
$defaultAvatarPath = "./picture/avatar.jpg";
if (isset($_SESSION['username'])) { ?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v4.0.1">
        <title>Personal Page</title>
        <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="./bootstrap.css" rel="stylesheet">
        <link rel="icon" href="../picture/avatar.jpg" type="image">
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
        <!-- Custom styles for this template -->
        <link href="./dashboard.css" rel="stylesheet">
    </head>

    <body>
        <div class="modal" id="announcementModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">网站公告</h5>
                    </div>
                    <div class="modal-body">
                        <p>欢迎大家光临</p><br>
                        <p>因为网站刚刚搭建不久，所以在使用过程中可能会遇到一些还未来得及修复的系统错误。</p>
                        <p>如果您在使用过程中遇到了任何问题，欢迎您通过我在博客中留下的联系方式联系我。</p>
                        <p>如果您有任何建议，也欢迎您的联系。</p>
                        <a href="https://blog.yiming1234.cn" target="_blank">Yiming的personal博客</a>
                        <p>诚挚感谢您的光临！</p><br>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showModal();
            });

            function showModal() {
                var myModal = new bootstrap.Modal(document.getElementById('announcementModal'), {});
                myModal.show();
            }
        </script>
        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="./index.php">Yiming's Website</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <input id="searchInput" class="form-control form-control-dark w-100" type="text" placeholder="Search the Internet" aria-label="Search">
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a id="searchLink" href="javascript:void(0)" class="nav-link">Search</a>
                </li>
            </ul>
            <script>
                const searchLink = document.getElementById("searchLink");
                const searchInput = document.getElementById("searchInput");
                searchLink.addEventListener("click", function() {
                    const searchTerm = searchInput.value;
                    if (searchTerm) {
                        const searchUrl = `https://www.google.com/search?q=${encodeURIComponent(searchTerm)}`;
                        window.location.href = searchUrl;
                    }
                });
            </script>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="./loginsystem/logout.php">Sign out</a>
                </li>
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="sidebar-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="./index.php">
                                    <span data-feather="home"></span>
                                    User Center <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../function/shopcenter.php">
                                    <span data-feather="file"></span>
                                    Resource List
                                </a>
                            </li>
                        </ul>

                        <hr class="my-3">

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Have a good day!</span>
                        </h6>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span><a href="../function/chatyiming.php" style="text-decoration: none; color: inherit;">① AI chatbot</a></span>
                        </h6>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span><a href="../function/download.php" style="text-decoration: none; color: inherit;">② CSDN help</a></span>
                        </h6>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span><a href="../function/resource.php" style="text-decoration: none; color: inherit;">③ Digital Resource</a></span>
                        </h6>
                        <ul class="nav flex-column mb-2">
                        </ul>
                    </div>
                </nav>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <main role="main" class="col-md-9 ml-sm-auto col-lg-9 px-md-4">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">User Center</h1>
                        </div>
                    </main>
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-6 offset-md-3" id="file_upload">
                                <form method="post" enctype="multipart/form-data" action="../function/upload.php">
                                    <img id="profile-pic" src="<?php echo file_exists($userAvatarPath) ? $userAvatarPath : $defaultAvatarPath; ?>" alt="User Avatar" class="rounded-circle" style="width:200px; height:200px;">
                                    <br><input type="file" name="image" id="input-file" accept="image/*" style="display:none;">
                                    <br><label for="input-file" class="btn btn-sm btn-primary mt-2 text-center">Update avatar</label>
                                    <button type="submit" class="btn btn-sm btn-secondary mt-2 text-center">Upload avatar</button><br><br>
                                    <p>Supports only JPG format</p>
                                    <p>
                                        <?php
                                        $err = isset($_GET["err"]) ? $_GET["err"] : "";
                                        switch ($err) {
                                            case 1:
                                                echo "Upload success.";
                                                break;

                                            case 2:
                                                echo "Invalid file format.";
                                                break;

                                            case 3:
                                                echo "Image size too large.";
                                                break;

                                            case 4:
                                                echo "Image upload failed or Image already exists.";
                                                break;

                                            case 5:
                                                echo "No file uploaded.";
                                                break;
                                        } ?>
                                    </p>
                                </form>
                            </div>
                            <div class="col-md-6 offset-md-3" id="file_upload">
                                <?php
                                require "./conn.php";
                                $stmt1 = $conn->prepare("SELECT phone FROM phone WHERE username = ?");
                                $stmt1->bind_param("s", $username);
                                $stmt1->execute();
                                $res1 = $stmt1->get_result();
                                $phone = $res1->fetch_assoc();
                                $stmt2 = $conn->prepare("SELECT email FROM email WHERE username = ?");
                                $stmt2->bind_param("s", $username);
                                $stmt2->execute();
                                $res2 = $stmt2->get_result();
                                $email = $res2->fetch_assoc();
                                $stmt3 = $conn->prepare("SELECT account FROM account WHERE username = ?");
                                $stmt3->bind_param("s", $username);
                                $stmt3->execute();
                                $res3 = $stmt3->get_result();
                                $account = $res3->fetch_assoc();
                                ?>
                                <h1 class="h2">Welcome, <?php echo $_SESSION['username']; ?>!</h1>
                                <h2 class="h5">Your phone number: <?php echo $phone['phone']; ?></h2><a href="../registersystem/phoneregister.php" target="_blank">Click here to change</a>
                                <h2 class="h5">Your email address: <?php echo $email['email']; ?></h2><a href="../registersystem/emailregister.php" target="_blank">Click here to change</a>        
                                <h2 class="h5">Account Balance: <?php echo $account['account']; ?> ￥</h2><a href="payment/index.php">Click here to charge</a>
                                <br><br><p style="color: red;">Please bind your mobile phone or email for easier password recovery.</p>
                            </div>
                        </div>
                    </div>
            </div>

        </div>
        <script type="text/javascript">
            let profilePic = document.getElementById("profile-pic");
            let inputFile = document.getElementById("input-file");

            inputFile.onchange = function() {
                profilePic.src = URL.createObjectURL(inputFile.files[0]);
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script>
            window.jQuery || document.write('<script src="./jquery.slim.min.js"><\/script>')
        </script>
        <script src="./bootstrap.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    </body>

    </html>
<?php
} else {
    header('Location: ./index1.html');
    exit;
}
?>