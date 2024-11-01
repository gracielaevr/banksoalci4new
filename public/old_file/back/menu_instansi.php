<div class="collapse navbar-collapse w-auto sidenav-guru" id="sidenav-collapse-main">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link side-leap side-dashboard" href="<?= base_url() ?>homeinstansi">
                <i class="ni ni-tv-2 text-primary text-sm"></i>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>
        <li class="nav-item mt-2">
            <h6 class="ps-4 ms-2 text-uppercase text-xs opacity-4">Master Data</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link side-leap side-topik" href="<?= base_url() ?>topik">
                <i class="ni ni-bullet-list-67 text-warning text-sm"></i>
                <span class="nav-link-text ms-1">Topik dan
                    Subtopik</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link side-leap side-soalinstansi" href="<?= base_url() ?>soalinstansi">
                <i class="fa fa-book text-info text-sm"></i>
                <span class="nav-link-text ms-1">Soal</span>
            </a>
        </li>

        <li class="nav-item">
            <a id="subscribe" class="nav-link side-leap side-siswa" href="<?= base_url() ?>pengguna">
                <i class="fa fa-users text-danger text-sm"></i>
                <span class="nav-link-text ms-1">Siswa</span>
            </a>
        </li>
        <li class="nav-item mt-2">
            <h6 class="ps-4 ms-2 text-uppercase text-xs opacity-4">Hasil</h6>
        </li>
        <li class="nav-item">
            <a id="subscribe" class="nav-link side-leap side-rekap" href="<?= base_url() ?>rekap">
                <i class="fa fa-book text-success text-sm"></i>
                <span class="nav-link-text ms-1">Rekap</span>
            </a>
        </li>
        <li class="nav-item mt-2">
            <h6 class="ps-4 ms-2 text-uppercase text-xs opacity-4">Pengaturan</h6>
        </li>

        <li class="nav-item">
            <a class="nav-link side-leap side-profilinstansi" href="<?= base_url() ?>profilinstansi">
                <i class="fa fa-user text-success text-sm"></i>

                <span class="nav-link-text ms-1">Profil</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url() ?>gantipassinstansi" id="gantipassinstansi"
                class="nav-link side-leap side-gantipassinstansi"> <i class="fa fa-lock text-danger text-sm"></i>

                <span class="nav-link-text ms-1">Ganti Password</span>
            </a>
        </li>
        <!-- 
         <li class="nav-item">
            <a class="nav-link side-leap" data-bs-toggle="collapse" href="#collapseExample">
                <i class="fa fa-gear text-white text-sm"></i>
                <span class="nav-link-text ms-1">Pengaturan</span>
            </a>
        </li>
      tassdr  <div class="collapse text-white" id="collapseExample">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a id="profilinstansi" class="nav-link side-leap side-profilinstansi"
                        href="<?= base_url() ?>profilinstansi">
                        <i class="fa fa-user text-success text-sm"></i>

                        <span class="nav-link-text ms-1">Profil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>gantipassinstansi" id="gantipassinstansi"
                        class="nav-link side-leap side-gantipassinstansi"> <i
                            class="fa fa-lock text-danger text-sm"></i>

                        <span class="nav-link-text ms-1">Ganti Password</span>
                    </a>
                </li>
            </ul>
        </div> -->

    </ul>


</div>

</aside>
<main class="main-content position-relative border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
        data-scroll="false">
        <div class="container-fluid align-items-center py-4 px-3 d-flex">
            <div>

                <!-- <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6> -->
                <li class="nav-item d-xl-none d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
            </div>
            <div class="collapse navbar-collapse me-md-0" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                </div>
                <ul class="navbar-nav  justify-content-end">


                    <li class="nav-item dropdown d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="ms-3"><?= $nama; ?></span>
                            <img src="<?= $foto_profile; ?>" class="avatar avatar-sm  ms-3" aria-hidden="true">

                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end sidenav-guru px-2 py-2 me-sm-n2"
                            aria-labelledby="dropdownMenuButton">

                            <li>
                                <a class="dropdown-item border-radius-md" href="<?= base_url() ?>profilinstansi">
                                    <div class="d-flex py-1">
                                        <div class="my-auto">
                                            <i class="ni ni-single-02 text-success me-3"></i>Profile
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item border-radius-md" href="<?= base_url() ?>logininstansi/logout">
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

    <div class="container-fluid py-2">