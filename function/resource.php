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
                                <a class="nav-link" href="./shopcenter.php">
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
                            <h1 class="h2">Digital Resource</h1>
                        </div>
                    </main>
                    <div class="col-md-9 ml-sm-auto col-lg-9 px-md-4">
                        <div class="row">
                            <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-success rounded shadow-sm">
                                <img class="mr-3" src="../picture/avatar.jpg" alt="" width="48" height="48">
                                <div class="lh-100">
                                    <h6 class="mb-0 text-white lh-100">Packege</h6>
                                    <small>For free part</small>
                                </div>
                            </div>

                            <div class="my-3 p-3 bg-white rounded shadow-sm">
                                <h6 class="border-bottom border-gray pb-2 mb-0">免费</h6>
                                <div class="media text-muted pt-3">
                                    <img class="bd-placeholder-img mr-2 rounded" width="32" height="32" src="../picture/logoclash.jpg" role="img" aria-label="Placeholder: 32x32">
                                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <strong class="d-block text-gray-dark">Clash for Windows</strong>
                                        For specific instructions on how to use proxy software, please refer to the blog.
                                        <a href="https://blog.yiming1234.cn/clashforwindows.exe" download="">Download it Now!</a>
                                    </p>
                                </div>
                                <div class="media text-muted pt-3">
                                    <img class="bd-placeholder-img mr-2 rounded" width="32" height="32" src="../picture/logoclash.jpg" role="img" aria-label="Placeholder: 32x32">
                                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <strong class="d-block text-gray-dark">Clash for Android</strong>
                                        For specific instructions on how to use proxy software, please refer to the blog.
                                        <a href="https://blog.yiming1234.cn/clashforandroid.apk" download="">Download it Now!</a>
                                    </p>
                                </div>
                                <div class="media text-muted pt-3">
                                    <img class="bd-placeholder-img mr-2 rounded" width="32" height="32" src="../picture/logoclash.jpg" role="img" aria-label="Placeholder: 32x32">
                                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <strong class="d-block text-gray-dark">Clash for MacOS</strong>
                                        For specific instructions on how to use proxy software, please refer to the blog.
                                        <a href="https://blog.yiming1234.cn/clashx.dmg" download="">Download it Now!</a>
                                    </p>
                                </div>
                                <div class="media text-muted pt-3">
                                    <img class="bd-placeholder-img mr-2 rounded" width="32" height="32" src="../picture/logoarknights.jpg" role="img" aria-label="Placeholder: 32x32">
                                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <strong class="d-block text-gray-dark">Arknights</strong>
                                        The current version provided is just one version of the script. The author will update the script as the game version iterates. Simply follow the prompts in the script to update it.The script only replaces some repetitive clicking operations with code and does not tamper with the game content.
                                        <a href="https://blog.yiming1234.cn/MAA-v4.28.7-win-x64.zip" download="">Download it Now!</a>
                                    </p>
                                </div>
                                <div class="media text-muted pt-3">
                                    <img class="bd-placeholder-img mr-2 rounded" width="32" height="32" src="../picture/logostarrailway.jpg" role="img" aria-label="Placeholder: 32x32">
                                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <strong class="d-block text-gray-dark">Star Railway</strong>
                                        The current version provided is just one version of the script. The author will update the script as the game version iterates. Simply follow the prompts in the script to update it.The script only replaces some repetitive clicking operations with code and does not tamper with the game content.
                                        <a href="https://blog.yiming1234.cn/StarRailAssistant-1.8.7.zip" download="">Download it Now!</a>
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-danger rounded shadow-sm">
                                <img class="mr-3" src="../picture/avatar.jpg" alt="" width="48" height="48">
                                <div class="lh-100">
                                    <h6 class="mb-0 text-white lh-100">Packege</h6>
                                    <small>For paid part</small>
                                </div>
                            </div>

                            <div class="my-3 p-3 bg-white rounded shadow-sm">
                                <h6 class="border-bottom border-gray pb-2 mb-0">收费</h6>
                                <div class="media text-muted pt-3">
                                    <img class="bd-placeholder-img mr-2 rounded" width="32" height="32" src="../picture/logogenshin.jpg" role="img" aria-label="Placeholder: 32x32">
                                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <strong class="d-block text-gray-dark">EpicGlobal</strong>
                                        In another word, it is Genshiin Impact cheat. Please use it cautiously.若下载错误，出示截图联系。
                                        <a href="https://shop2.yiming1234.cn/resource/download2.php">Download it Now!</a>
                                    </p>
                                </div>
                                <div class="media text-muted pt-3">
                                    <img class="bd-placeholder-img mr-2 rounded" width="32" height="32" src="../picture/logoburpsuite.jpg" role="img" aria-label="Placeholder: 32x32">
                                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <strong class="d-block text-gray-dark">Burpsuite</strong>
                                        A famous packet capture tool in network security.
                                        <a href="https://shop2.yiming1234.cn/resource/download2.php">Download it Now!</a>
                                    </p>
                                </div>
                            </div>
                            <p style="color: red;">
                                    <?php
                                    $err = isset($_GET["err"]) ? $_GET["err"] : "";
                                    switch ($err) {
                                        case 1:
                                            echo "Insufficient account balance.";
                                            break;

                                        case 2:
                                            echo "You have already download.";
                                            break;

                                        case 3:
                                            echo "You have successfully download.";
                                            break;;
                                    }
                                    ?><br></p>
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
    header('Location: ../index1.html');
    exit;
}
?>