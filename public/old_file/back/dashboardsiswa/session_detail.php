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

    <!-- Font Awesome Icons -->
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
        href="<?php echo base_url(); ?>back/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/bower_components/select2/dist/css/select2.min.css">


    <!-- CSS Files -->
    <link id="pagestyle" href="<?= base_url() ?>front/dashboard_new/assets/css/argon-dashboard.css?v=2.0.4"
        rel="stylesheet" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard/assets/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard/assets/css/components.css">
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard_new/assets/css/style.css">


</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="position-absolute w-100 #86b4de" style="background: linear-gradient(90deg, rgba(47,104,170,1) 0%, rgba(133,182,228,1) 100%);
height:27%"></div>
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
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link side-leap side-dashboard" href="<?= base_url() ?>homesiswa">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link side-leap side-history" href="<?= base_url() ?>history">
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

                <?php if ($free):
                    ?>

                <div class="sidenav-footer position-absolute bottom-0 mb-3">
                    <div class="card hide-sidebar-mini card-subscribe">
                        <div class="card-header-centered">
                            <h3 class="letter-spacing-1 mb-2">Free
                                Account
                            </h3>
                            <h6 class="fw-bold m-0 p-0">Upgrade to Member</h6>
                            <a href="#" class="card-link letter-spacing-1 fw-bold m-0 p-0">Get Now <i
                                    class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
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
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item dropdown d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="ms-3"><?= $nama; ?></span>
                                <img src="<?= $foto_profile; ?>" class="avatar avatar-sm  ms-3" aria-hidden="true">

                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-2 me-sm-n2"
                                aria-labelledby="dropdownMenuButton">

                                <li>
                                    <a class="dropdown-item border-radius-md" href="<?= base_url() ?>profilestudent">
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
                                                <i class="ni ni-bold-right text-danger me-3 text-center"></i>Logout
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
            <section class="section">
                <div class="row">
                    <div class="col-xl-12 col-sm-12 mb-4">
                        <div class="card shadow-leap">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8 welcome-leap">
                                        <h5 class="m-0">Session Detail</h5>
                                    </div>
                                    <div class="col-4 welcome-leap text-end">
                                        <span id="current-day"></span>, <span id="current-date"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-sm-12 mb-4">
                        <div class="row align-items-center">
                            <div class="col-12 text-end">
                                <a href="<?= base_url('session') ?>"
                                    class="btn btn-icon m-0 icon-left btn-primary-leap"><i
                                        class="fa fa-rotate-left me-2"></i>
                                    Back to Session</a>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card p-3 shadow-leap">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Detail Table</h5>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped text-center align-items-center">
                                <thead class="text-start">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Teacher</th>
                                        <th>Note Teacher</th>
                                        <th>Question</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody class="text-start">
                                    <?php if (!empty($data_detail)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($data_detail as $row): ?>
                                    <tr class="fst-normal">
                                        <td><?= $no ?></td>
                                        <td><?= $row->tanggal ?></td>
                                        <td><?= date('H:i', strtotime($row->waktu)) ?></td>
                                        <td><?= $row->guru ?></td>
                                        <td><?= $row->catatan ?></td>
                                        <td><?= $row->pertanyaan ?></td>
                                        <td><?= $row->file_display ?></td> <!-- Menggunakan variabel file_display -->
                                    </tr>
                                    <?php $no++; ?>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Session Is Empty.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </section>


        </div>


        <footer class="footer pt-3 pb-3">
            <hr class="horizontal dark mt-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 mb-lg-0 mb-4 d-flex justify-content-between align-items-center">
                        <div class="textstart">
                            Copyright &copy; <?= date("Y"); ?> • <a href=""> Leapverse -
                                Bank Soal.</a> All Rights Reserved
                        </div>
                        <div class="footer-right">
                            2.3.0
                        </div>
                    </div>

                </div>
            </div>
        </footer>

    </main>


    <!-- Core JS Files -->
    <script src="<?= base_url(); ?>tinymce/tinymce.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/core/popper.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/core/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/chartjs.min.js"></script>

    <!-- Memuat jQuery terlebih dahulu -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Memuat DataTables -->


    <!-- jQuery and Bootstrap -->
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="<?= base_url() ?>front/assets/js/bootstrap.min.js"></script>

    <!-- Other JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"
        integrity="sha512-zMfrMAZYAlNClPKjN+JMuslK/B6sPM09BGvrWlW+cymmPmsUT1xJF3P4kxI3lOh9zypakSgWaTpY6vDJY/3Dig=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>


    <!--  Custom JS Files -->
    <script src="<?= base_url() ?>front/dashboard/assets/js/stisla.js"></script>
    <script src="<?= base_url() ?>front/dashboard/assets/js/scripts.js"></script>
    <script src="<?= base_url() ?>front/dashboard/assets/js/custom.js"></script>

    <!-- GitHub Buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Argon Dashboard JS -->
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/argon-dashboard.min.js?v=2.0.4"></script>




    <script>
    // Fungsi untuk mendapatkan tanggal dalam format "dd MMMM yyyy"
    function getCurrentDate() {
        const date = new Date();
        const day = date.getDate().toString().padStart(2, '0'); // Format hari dengan dua digit
        const month = new Intl.DateTimeFormat('en', {
            month: 'long'
        }).format(date); // Nama bulan dalam bahasa Inggris
        const year = date.getFullYear();
        return `${day} ${month} ${year}`;
    }

    // Fungsi untuk mendapatkan hari saat ini
    function getCurrentDay() {
        const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        return days[new Date().getDay()];
    }


    // Mengisi elemen HTML dengan tanggal dan hari saat ini
    document.getElementById("current-date").textContent = getCurrentDate();
    document.getElementById("current-day").textContent = getCurrentDay();
    </script>

    <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

    document.querySelector('.side-session').classList.add('active');

    //  Message
    $(document).ready(function() {
        $('#flashMessage').addClass('show');
        setTimeout(function() {
            $('#flashMessage').removeClass('show');
        }, 5000);
    });
    </script>



</body>

</html>