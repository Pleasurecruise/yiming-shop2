<?php
session_start();
$username = $_SESSION['username'];
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
        <link href="../bootstrap.css" rel="stylesheet">
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

            .img-size {
                width: 323.5px;
                height: 200px;
            }
        </style>
        <!-- Custom styles for this template -->
        <link href="../dashboard.css" rel="stylesheet">
    </head>

    <body>
        <div class="modal" id="announcementModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">使用说明</h5>
                    </div>
                    <div class="modal-body">
                        <p>恭喜你发现宝藏！</p><br>
                        <p>这里主要提供一些学生党可能会用的到的一些资源。</p>
                        <p>如果您对资源的使用存在疑问，欢迎您前往我的博客查阅相关资料和使用说明。存在使用异常，请及时联系站长。</p>
                        <p>如果您有任何建议，也欢迎您的联系。</p>
                        <a href="https://blog.yiming1234.cn/index.php/2024/01/01/%e5%85%b3%e4%ba%8e%e8%b5%84%e6%ba%90/" target="_blank">关于资源</a>
                        <p>密码为博客主页地址，记得带上"https://"</p>
                        <p>再次诚挚感谢您的光临！</p><br>
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
            <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="../index.php">Yiming's Website</a>
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
                    <a class="nav-link" href="../loginsystem/logout.php">Sign out</a>
                </li>
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="sidebar-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="../index.php">
                                    <span data-feather="home"></span>
                                    User Center
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="./shopcenter.php">
                                    <span data-feather="file"></span>
                                    Resource List<span class="sr-only">(current)</span>
                                </a>
                            </li>
                        </ul>

                        <hr class="my-3">

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Have a good day!</span>
                        </h6>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span><a href="chatyiming.php" style="text-decoration: none; color: inherit;">① AI chatbot</a></span>
                        </h6>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span><a href="download.php" style="text-decoration: none; color: inherit;">② CSDN help</a></span>
                        </h6>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span><a href="resource.php" style="text-decoration: none; color: inherit;">③ Digital Resource</a></span>
                        </h6>
                        <ul class="nav flex-column mb-2">
                        </ul>
                    </div>
                </nav>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <main role="main" class="col-md-9 ml-sm-auto col-lg-9 px-md-4">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">Resource List</h1>
                        </div>
                    </main>
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <?php
                                require "../conn.php";
                                $stmt1 = $conn->prepare("SELECT endtime FROM subscribe WHERE username = ?");
                                $stmt1->bind_param("s", $username);
                                $stmt1->execute();
                                $res1 = $stmt1->get_result();
                                $row = $res1->fetch_assoc();
                                $endtime = new DateTime($row['endtime']);
                                $now = new DateTime();
                                if ($endtime->format('Y-m-d H:i:s') == '-0001-11-30 00:00:00') {
                                    $remaining = DateInterval::createFromDateString('0 days');
                                } else {
                                    $remaining = $now->diff($endtime, true);
                                }
                                ?>
                                <img src="../picture/chatgpt.jpg" class="img-fluid img-size">
                                <br><br>
                                <h2 class="h5">Unlimited Monthly Subscription for ChatGPT Chinese Mirror Site</h2>
                                <h2 class="h5">10￥/month</h2>
                                <p>P.S. Due to the recent establishment of the website, many things are still undergoing improvements. Therefore, we are currently opting for this sales model as an initial trial.</p>
                                <p>Access the website by clicking on the left sidebar link.</p>
                                <p>如若余额不足，请先移步至用户界面进行充值。</p>
                                <p style="color: blue;">The remaining free usage time:<?php
                                                                                        $days = $remaining->d;
                                                                                        $hours = $remaining->h;
                                                                                        echo $days . ' days ' . $hours . ' hours';
                                                                                        ?></p>
                                <p style="color: red;">
                                    <?php
                                    $err = isset($_GET["err"]) ? $_GET["err"] : "";
                                    switch ($err) {
                                        case 1:
                                            echo "Insufficient account balance.";
                                            break;

                                        case 2:
                                            echo "You have already subscribed.";
                                            break;

                                        case 3:
                                            echo "You have successfully subscribed.";
                                            break;

                                        case 4:
                                            echo "Please renewal of Monthly Subscription.";
                                            break;
                                    }
                                    ?><br></p>
                                <form action="subscribe.php" method="post">
                                    <button type="submit" class="btn btn-primary">Subscribe for a month</button>
                                </form>
                            </div>
                            <div class="col-md-6 offset-md-3">
                                <img src="../picture/clash.jpg" class="img-fluid img-size">
                                <br><br>
                                <h2 class="h5">A tool for accessing the internet oversea freely in China</h2>
                                <h2 class="h5">10￥</h2>
                                <p>P.S. We will provide you with the corresponding installation program and nodes. You only need to copy and paste the URL into the designated field for uploading. The 30GB capacity is sufficient for almost half a year of usage if only watch videos or browse web pages.</p>
                                <p>暂未安装流量使用监控，如若无法正常使用，请联系站长查询。</p>
                                <p style="color: blue;">限量10，还剩<?php
                                                                require "../conn.php";
                                                                $stmt = $conn->prepare("SELECT COUNT(*) FROM node WHERE username = ''");
                                                                $stmt->execute();
                                                                $result = $stmt->get_result();
                                                                $row = $result->fetch_array();
                                                                echo $row[0];
                                                                ?>个！视情况后续逐步增加。</p>
                                <p style="color: red; word-wrap: break-word;">
                                    <?php
                                    $err = isset($_GET["err"]) ? $_GET["err"] : "";
                                    $website = isset($_GET["website"]) ? $_GET["website"] : "";
                                    switch ($err) {
                                        case 5:
                                            echo "Insufficient account balance.";
                                            break;

                                        case 6:
                                            echo "You have already subscribed.";
                                            if ($website) {
                                                echo "<br>Your website: " . htmlspecialchars($website);
                                            }
                                            break;

                                        case 7:
                                            echo "You have successfully subscribed.";
                                            if ($website) {
                                                echo "<br>Your website: " . htmlspecialchars($website);
                                            }
                                            break;

                                        case 8:
                                            echo "Sorry there is no available node.";
                                            break;
                                    }
                                    ?><br></p>
                                <form action="clash.php" method="post">
                                    <button type="submit" class="btn btn-primary">Subcribe it now</button>
                                </form>
                            </div>
                            <div class="col-md-6 offset-md-3">
                                <img src="../picture/csdn.jpg" class="img-fluid img-size">
                                <br><br>
                                <h2 class="h5">CSDN learning helper</h2>
                                <h2 class="h5">1￥/download</h2>
                                <p>P.S. In order to help fellow students overcome the issue of expensive CSDN community memberships encountered during the learning process, we are attempting to provide a proxy download service here.</p>
                                <form action="download.php" method="post">
                                    <button type="submit" class="btn btn-primary">Why not try it</button>
                                </form>
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
            window.jQuery || document.write('<script src="../jquery.slim.min.js"><\/script>')
        </script>
        <script src="../bootstrap.bundle.js"></script>
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