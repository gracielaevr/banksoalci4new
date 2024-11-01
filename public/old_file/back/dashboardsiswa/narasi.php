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

    <!-- Swal Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">


    <!-- Nucleo Icons -->
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Files -->
    <link id="pagestyle" href="<?= base_url() ?>front/dashboard_new/assets/css/argon-dashboard.css?v=2.0.4"
        rel="stylesheet" />


    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard/assets/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard/assets/css/components.css">
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard_new/assets/css/style.css">
</head>

<body class="layout-3">
    <div id="app">
        <nav class="navbar navbar-expand-lg main-navbar d-flex justify-content-between pt-3 pb-3 ps-5 pe-5 " style="background: rgb(255,255,255);
background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(47,104,170,1) 100%);
">
            <img src="<?= base_url() ?>front/images/leapverse.png" alt="" width="80px">
            <ul class="navbar-nav ml-auto">
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
        </nav>

        <nav
            class="navbar navbar-expand-lg navbar-expand-md navbar-expand-sm navbar-expand pt-2 pb-2 ps-5 pe-5 bg-white d-flex justify-content-between align-items-center">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= base_url() ?>homesiswa" class="nav-link text-center"><i
                            class="ni ni-tv-2 text-primary text-sm opacity-10 me-2"></i><span>Dashboard</span></a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>history" class="nav-link text-center"><i
                            class="ni ni-bullet-list-67 text-warning text-sm opacity-10 me-2"></i><span>History</span></a>
                </li>

                <?php if ($showSessionMenu): // Menampilkan menu jika $showSessionMenu bernilai true 
                ?>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>session" class="nav-link text-center"><i
                                class="ni ni-app text-info text-sm opacity-10 me-2"></i><span>Session</span></a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="<?= base_url() ?>subscribe" class="nav-link text-center"><i
                            class="ni ni-like-2 text-danger text-sm opacity-10 me-2"></i><span>Subscribe</span></a>
                </li>
            </ul>
            <div class="row">

                <a href="<?php echo base_url() . 'homesiswa/subtopic/' . str_replace(' ', '-', $topik); ?>"
                    class="nav-link text-end text-primary mb-0"><i class="fa fa-rotate-left me-2"></i><span
                        class="text-dark">Back</span></a>

            </div>

        </nav>

        <div class="main-wrapper container mt-4">
            <!-- Main Content -->
            <div class="container">
                <section class="section">

                    <div class="section-body">
                        <div class="card shadow-leap">
                            <div class="card-header text-center">

                                <h2 style="margin-bottom: 10px; color: black;">
                                    <?php echo substr($subtopik, 0, strpos($subtopik, "(")); ?></h2>
                                <h6 style="margin-bottom: 10px; color: black;">
                                    <?php echo substr($subtopik, strpos($subtopik, '(')); ?></h6>

                            </div>
                            <div class="card-body">
                                <h5>TOPIC : <?= $topik ?> </h5>
                                <p><b>Instructions !!</b></p>
                                <ul>
                                    <li>Number of questions : <b> <?php echo $jml; ?> </b></li>
                                    <li>Must be finished in one sitting. You cannot save and finish later.</li>
                                    <li>Will not let you finish with any questions unattempted.</li>
                                </ul>

                            </div>
                            <div class="card-footer bg-whitesmoke">
                                <div class="buttons">


                                    <button id="startQuizButton" onclick="mulai(<?php echo $tot; ?>);"
                                        class="btn btn-lg btn-primary-leap middle w-100"><b>Start The test</b></button>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>


        </div>

    </div>

    <footer class="footer mt-5 pb-3">
        <hr class="horizontal dark mt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="text-start">
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


    <!--   Core JS Files   -->
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/core/popper.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/core/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/chartjs.min.js"></script>
    <!-- General JS Scripts -->
    <script src="<?= base_url() ?>front/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>front/assets/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"
        integrity="sha512-zMfrMAZYAlNClPKjN+JMuslK/B6sPM09BGvrWlW+cymmPmsUT1xJF3P4kxI3lOh9zypakSgWaTpY6vDJY/3Dig=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard/assets/js/stisla.js"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="<?= base_url() ?>front/dashboard/assets/js/scripts.js"></script>
    <script src="<?= base_url() ?>front/dashboard/assets/js/custom.js"></script>

    <script>
        function mulai(t) {
            var school = <?= json_encode($school); ?>;
            var only3 = <?= json_encode($hanya3); ?>;
            if (school) {
                if (only3) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ups sorry!',
                        text: 'You can only take 3 tests, call your teacher to get unlimited access',
                    }).then(function() {
                        window.location.href = "<?php echo base_url() . 'Subscribe/' ?>";
                    });
                } else {
                    if (t > 4) {
                        window.location.href = "<?php echo base_url() . 'question/start/' . $kode; ?>";
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ups sorry!',
                            text: 'This test is not ready yet',
                        });
                    }
                }
            } else {
                if (t > 4) {
                    window.location.href = "<?php echo base_url() . 'question/start/' . $kode; ?>";
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ups sorry!',
                        text: 'This test is not ready yet',
                    });
                }
            }


        }
    </script>

</body>

</html>