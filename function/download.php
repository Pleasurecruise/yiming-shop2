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
                        <h5 class="modal-title">特别说明</h5>
                    </div>
                    <div class="modal-body">
                        <p>由于本人技术欠佳</p>
                        <p>无法搓代码供大家及时下载，只好采取人工表单以邮箱发送的方式</p>
                        <p>(服务器空间不够也是一方面原因)</p>
                        <p>（当然如果有大佬会这方面的也可以联系我合作）</p>
                        <p>如果实在觉得慢可以通过联系方式联系我</p>
                        <p>我看到了会尽快给大家回复的</p>
                        <p>只是分享多余的会员权益并不是破解</p>
                        <p>请大伙见谅！</p>
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
                            <h1 class="h2">Download History</h1>
                        </div>
                    </main>
                    <div class="col-md-9 ml-sm-auto col-lg-9 px-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="csdn.php">
                                    <div class="input-group mb-3">
                                        <input name="url" type="url" class="form-control" placeholder="Input your target URL here" required>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>
                                <p style="color: red;">
                                    <?php
                                    $err = isset($_GET["err"]) ? $_GET["err"] : "";
                                    switch ($err) {
                                        case 1:
                                            echo "Insufficient account balance.";
                                            break;

                                        case 2:
                                            echo "You have already submit.";
                                            break;

                                        case 3:
                                            echo "You have successfully submit.";
                                            break;

                                        case 4:
                                            echo "您还未绑定邮箱，请先绑定邮箱。";
                                    }
                                    ?><br></p>
                            </div>
                            <?php
                            require '../conn.php';
                            $stmt3 = $conn->prepare("SELECT * FROM file WHERE username = ?");
                            $stmt3->bind_param("s", $username);
                            $stmt3->execute();
                            $result = $stmt3->get_result();
                            $stmt3->close();
                            $conn->close();
                            ?>
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">The file name</th>
                                            <th scope="col">Target URL</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <th><?php echo htmlspecialchars($row['filename']); ?></th>
                                                <td><?php echo htmlspecialchars($row['fileurl']); ?></td>
                                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                        <tr>
                                            <th>Unknown</th>
                                            <td>Unknown</td>
                                            <td>Unknown</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                    </ul>
                                </nav>
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