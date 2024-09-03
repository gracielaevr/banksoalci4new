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
    <style>
    .profile-image-container {
        position: relative;
        display: inline-block;
        width: 100%;
        /* Membuat elemen mengikuti lebar container */
        aspect-ratio: 3 / 4;
        /* Rasio gambar 3x4 */
    }

    #profileImage {
        width: 100%;
        /* Lebar 100% dari container */
        height: auto;
        /* Menjaga rasio aspek */
        object-fit: cover;
        /* Agar gambar sesuai dengan ukuran tanpa melar */
        border-radius: 5px;
        /* Opsional, membuat ujung gambar sedikit membulat */
    }

    .edit-overlay {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background-color: rgba(128, 128, 128, 0.8);
        /* Abu-abu dengan transparansi */
        padding: 5px 10px;
        border-radius: 20px;
        /* Membuat ujung membulat */
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .edit-text {
        font-size: 0.9rem;
        /* Ukuran teks */
    }
    </style>
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
                <li class="nav-item">
                    <a class="nav-link side-leap side-session" href="<?= base_url() ?>session">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-app text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Session</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link side-leap side-subscribe" href="<?= base_url() ?>Subscribe">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-like-2 text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Subscribe</span>
                    </a>
                </li>

        </div>
        <div class="sidenav-footer">
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
                                    <a class="dropdown-item border-radius-md" href="<?= base_url() ?>logout">
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
                                        <h5 class="m-0">Profile</h5>
                                    </div>
                                    <div class="col-4 welcome-leap text-end">
                                        <span id="current-day"></span>, <span id="current-date"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card p-3 shadow-leap">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Form Profile</h5>
                    </div>



                    <div class="card-body row">
                        <!-- Gambar Profil di sebelah kiri -->
                        <div class="col-md-4 col-12 text-center mb-3 position-relative"
                            style="border: 2px solid blue;border-radius:12px">
                            <div class="profile-image-container">
                                <img src="<?= $foto_profile; ?>" id="profileImage"
                                    style="cursor: pointer; width: 100%; height: 100%;" alt="Profile Picture">
                                <div class="edit-overlay"
                                    onclick="document.getElementById('profileImageInput').click();">
                                    <i class="fas fa-edit text-white" style="cursor: pointer; font-size: 1.5rem;"></i>
                                    <span class="edit-text text-white ms-2">Choose here</span>
                                </div>
                                <input type="file" id="profileImageInput" name="foto" style="display: none;"
                                    onchange="previewImage(event)">
                            </div>
                        </div>

                        <!-- Input lainnya di sebelah kanan -->
                        <div class="col-md-8 col-12">
                            <div class="form-profile mb-4 row align-items-center">
                                <label for="email" class=" col-form-label">Email</label>
                                <div>
                                    <input class="form-control" id="email" name="email" type="text"
                                        value="<?= $email; ?>" readonly>
                                    <small class="text-muted">* Jika ingin mengganti email hubungi admin</small>
                                </div>
                            </div>
                            <div class="form-profile mb-4 row align-items-center">
                                <label for="nama" class=" col-form-label">Nama</label>
                                <div>
                                    <input class="form-control" id="nama" name="nama" type="text" value="<?= $nama; ?>">
                                </div>
                            </div>
                            <div class="form-profile mb-4 row align-items-center">
                                <label for="wa" class=" col-form-label">No WA</label>
                                <div>
                                    <input class="form-control" id="wa" name="wa" type="number" value="<?= $wa; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button id="btnSave" type="button" class="btn btn-primary-leap"
                            onclick="proses();">Simpan</button>
                        <button type="button" class="btn btn-default shadow">Batal</button>
                    </div>



                </div>

            </section>

        </div>

        <footer class="footer mt-3 mb-3">
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

    <script type="text/javascript">
    $(document).ready(function() {

    });

    function proses() {
        var nama = document.getElementById('nama').value;
        var wa = document.getElementById('wa').value;
        var foto = $('#foto').prop('files')[0];

        if (nama === "") {
            alert("Nama personil tidak boleh kosong");
        } else {
            $('#btnSave').text('Saving...');
            $('#btnSave').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('nama', nama);
            form_data.append('wa', wa);
            form_data.append('file', foto);

            $.ajax({
                url: "<?php echo base_url(); ?>profilestudent/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(response) {
                    alert(response.status);

                    location.reload();
                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);
                },
                error: function(response) {
                    alert(response.status);
                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);
                }
            });
        }
    }
    </script>

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

    <!-- Search Subtopic -->
    <script>
    // Menampilkan preview gambar
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profileImage');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
    </script>

    <!-- Template JS File -->
    <script src="<?= base_url() ?>front/dashboard/assets/js/scripts.js"></script>
    <script src="<?= base_url() ?>front/dashboard/assets/js/custom.js"></script>

    <!-- Code injected by live-server -->
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

    //Dashboard Click

    const dashboardPaths = [
        '/public/homesiswa',
        '/public/subtopic1',
        '/public/index.php/subtopic1/',
        'https://kemitraan.leapsurabaya.sch.id/homesiswa',
        'https://kemitraan.leapsurabaya.sch.id/subtopic1',
        'https://kemitraan.leapsurabaya.sch.id/index.php/subtopic1'
    ];
    const historyPaths = [
        '/public/history',
        'https://kemitraan.leapsurabaya.sch.id/history'
    ];
    const sessionPaths = [
        '/public/session',
        'https://kemitraan.leapsurabaya.sch.id/session'
    ];
    const subscribePaths = [
        '/public/Subscribe',
        'https://kemitraan.leapsurabaya.sch.id/Subscribe'
    ];

    const activePage = window.location.pathname;
    if (dashboardPaths.some(path => activePage.includes(path))) {
        document.querySelector('.side-dashboard').classList.add('active');
    } else if ((historyPaths.some(path => activePage.includes(path)))) {
        document.querySelector('.side-history').classList.add('active');
    } else if ((sessionPaths.some(path => activePage.includes(path)))) {
        document.querySelector('.side-session').classList.add('active');
    } else if ((subscribePaths.some(path => activePage.includes(path)))) {
        document.querySelector('.side-subscribe').classList.add('active');
    }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>