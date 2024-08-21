<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Leapverse Question Bank</title>

    <!-- General CSS Files -->
    <link href="front/images/leapverse.png" rel="icon">
    <link rel="stylesheet" href="<?= base_url() ?>/front/dashboard/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="<?= base_url() ?>/front/dashboard/node_modules/@fortawesome/fontawesome-free/css/all.min.css">


    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/front/dashboard/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/front/dashboard/assets/css/components.css">
    <link rel="stylesheet" href="<?= base_url() ?>/front/dashboard/assets/css/custom.css">
</head>

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <img src="<?= base_url() ?>/front/images/leapverse.png" alt="" width="80px">
                <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
                <ul class="navbar-nav ml-auto">
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?= base_url() ?>/front/images/avatar.png"
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, Budi</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">Logged in 5 min ago</div>
                            <a href="features-profile.html" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href="features-activities.html" class="dropdown-item has-icon">
                                <i class="fas fa-bolt"></i> Activities
                            </a>
                            <a href="features-settings.html" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/homesiswa" class="nav-link"><i
                                    class="fas fa-school"></i><span>Dashboard</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/history" class="nav-link"><i
                                    class="fas fa-hourglass-half"></i><span>History</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/session" class="nav-link"><i
                                    class="fas fa-book"></i><span>Session</span></a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1><?= $subtopik->nama ?></h1>
                        <div class="section-header-breadcrumb buttons">
                            <a href="javascript:history.back();" class="btn btn-icon icon-left btn-primary"><i
                                    class="far fa-edit"></i>
                                Back to subtopic</a>
                        </div>
                    </div>

                    <div class="section-body">
                        <div class="card">
                            <div class="card-header">
                                <h4>TOPIC : <?= $topik->nama ?> </h4>
                            </div>
                            <div class="card-body">
                                <p><b>Instructions !!</b></p>
                                <ul>
                                    <li>Number of questions : 10 </li>
                                    <li>Must be finished in one sitting. You cannot save and finish later.</li>
                                    <li>Will not let you finish with any questions unattempted.</li>
                                </ul>

                            </div>
                            <div class="card-footer bg-whitesmoke">
                                <div class="buttons">
                                    <a href="question" class="btn btn-lg btn-primary middle"><b>Start the test</b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad
                        Nauval Azhar</a>
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="<?= base_url() ?>/front/dashboard/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>/front/dashboard/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/front/dashboard/node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js">
    </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> -->
    <script src="<?= base_url() ?>/front/dashboard/assets/js/stisla.js"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="<?= base_url() ?>/front/dashboard/assets/js/scripts.js"></script>
    <script src="<?= base_url() ?>/front/dashboard/assets/js/custom.js"></script>
</body>

</html>