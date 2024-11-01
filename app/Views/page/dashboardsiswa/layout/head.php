<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>front/dashboard_new/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?= base_url() ?>front/images/leapverse.png">
    <title>Leapverse Question Bank</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Nucleo Icons -->
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">

    <!-- Font Awesome Icons -->
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Files -->
    <link id="pagestyle" href="<?= base_url() ?>front/dashboard_new/assets/css/argon-dashboard.css?v=2.0.4"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css">

    <script src="<?= base_url(); ?>back/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url(); ?>tinymce/tinymce.min.js"></script>

    <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard/assets/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard/assets/css/components.css">
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard_new/assets/css/style.css">
    <style>
        .box {
            background: linear-gradient(90deg, rgba(47, 104, 170, 1) 0%, rgba(133, 182, 228, 1) 100%);
            height: 25%;
        }

        .modal-backdrop2 {
            --bs-backdrop-zindex: -1;
            --bs-backdrop-bg: #000;
            opacity: 0.5 !important;
            position: fixed;
            top: 0;
            left: 0;
            z-index: var(--bs-backdrop-zindex);
            width: 100vw;
            height: 100vh;
            background-color: var(--bs-backdrop-bg);
        }
    </style>
    <script>
        function openmodal_subs() {
            var modal = document.getElementById('subModal');
            modal.style.display = 'block';
        }
    </script>
</head>

<body class="g-sidenav-show bg-gray-100">

    <div class="position-absolute w-100 #86b4de box"></div>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-2 fixed-start ms-4  shadow-leap"
        id="sidenav-main">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <div class="sidenav-header d-block align-items-center mt-2 mb-2 text-center">
            <img src="<?= base_url() ?>front/images/leapverse.png" class="navbar-br and-img" alt="main_logo" width="40%"
                height="80%">
        </div>
        <hr class="horizontal dark mb-0 mt-0">
        <div class="collapse navbar-collapse w-auto sidenav-murid" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a id="dashboard" class="nav-link side-leap side-dashboard" href="<?= base_url() ?>homesiswa">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a id="history" class="nav-link side-leap side-history" href="<?= base_url() ?>history">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-bullet-list-67 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">History</span>
                    </a>
                </li>
                <?php if ($showSessionMenu):
                    ?>
                    <li class="nav-item">
                        <a id="session" class="nav-link side-leap side-session" href="<?= base_url() ?>session">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-app text-info text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Session</span>
                        </a>
                    </li>

                <?php else: // Menampilkan Subscribe jika $showSessionMenu bernilai false 
                    ?>
                    <li class="nav-item">
                        <a id="subscribe" class="nav-link side-leap side-subscribe" href="<?= base_url() ?>Subscribe">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-like-2 text-danger text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Subscribe</span>
                        </a>
                    </li>

                <?php endif; ?>


                <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs opacity-4">Pengaturan</h6>
                </li>
                <li class="nav-item">
                    <a id="profile" class="nav-link side-leap side-profile" href="<?= base_url() ?>profile">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-user text-success text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Profil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a id="logout" class="nav-link side-leap side-ganti" href="<?= base_url() ?>gantipass">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-lock text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Ganti Password</span>
                    </a>
                </li>

                <?php if ($free || $pakethabis): ?>


                    <div class="sidenav-footer mt-3">
                        <div class="card hide-sidebar-mini card-subscribe">
                            <div class="card-header-centered">
                                <h3 class="letter-spacing-1">Free
                                    Account
                                </h3>
                                <h6 class="fw-bold m-0 p-0">Upgrade to Member</h6>
                                <button onclick="openmodal_subs();"
                                    class="btn btn-transparent text-white letter-spacing-1 p-0 m-0 shadow-none">Get
                                    Now <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </ul>


        </div>

    </aside>
    <main class="main-content position-relative border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
            data-scroll="false">
            <div class="container-fluid align-items-center py-4 px-3 d-flex">
                <nav aria-label="breadcrumb" class="nav-das">

                    <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
                </nav>
                <div class="collapse navbar-collapse me-md-0" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                    </div>
                    <ul class="navbar-nav  justify-content-end">

                        <li class="nav-item d-xl-none d-flex align-items-center">
                            <a href="javascript:;" class="nav-link navbar-toggler text-white p-2"
                                id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner" style="z-index: -1;">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item dropdown d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="ms-3"><?= $pro->nama; ?></span>
                                <img src="<?= $foto_profile; ?>" class="avatar avatar-sm  ms-3" aria-hidden="true">
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end sidenav-murid  px-2 py-2 me-sm-n2"
                                aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a class="dropdown-item border-radius-md" href="<?= base_url() ?>profile">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <i class="ni ni-single-02 text-success me-3"></i>Profile
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="<?= base_url() ?>loginsiswa/logout">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <i class="fa fa-sign-out text-danger me-3 text-center"></i>Logout
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <div class="container-fluid py-2">

            <?php include('modal.php'); ?>