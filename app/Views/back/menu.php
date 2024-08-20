<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->

        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $foto_profile; ?>" class="img-circle" alt="User Image" style="height: 30px; width: 30px;">
            </div>
            <div class="pull-left info">
                <p><?php echo $nama; ?></p>
                <small><?php echo $nm_role; ?></small>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">

            <li class="<?php if ($menu == "home" | $menu == "/") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>/home"><i class="fa fa-home"></i>
                    <span>Beranda</span></a></li>
            <li class="header">Master Data</li>
            <li class="<?php if ($menu == "topik" | $menu == "subtopik") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>/topik"><i class="fa fa-list-ol"></i> <span>Topik dan
                        Subtopik</span></a></li>
            <li class="<?php if ($menu == "soal" | $menu == "soalnarasi" | $menu == "narasi") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>/soal"><i class="fa fa-book"></i> <span>Soal</span></a>
            </li>
            <li class="<?php if ($menu == "instansi") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>/instansi"><i class="fa fa-building"></i>
                    <span>Instansi</span></a>
            </li>
            <li class="<?php if ($menu == "admininstansi") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>/admininstansi"><i class="fa fa-university"></i>
                    <span>Admin Instansi</span></a>
            </li>
            <li class="<?php if ($menu == "SubscribeAdmin") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>/SubscribeAdmin"><i class="fa fa-thumbs-up"></i>
                    <span>Subscribe</span></a>
            </li>
            <li class="<?php if ($menu == "jadwalkonsultasi") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>/jadwalkonsultasi"><i class="fa fa-calendar"></i>
                    <span>Jadwal Konsultasi</span></a>
            </li>
            <li class="header">Hasil</li>
            <li class="<?php if ($menu == "siswa") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>/siswa"><i class="fa fa-users"></i>
                    <span>Siswa</span></a></li>
            <li class="<?php if ($menu == "rekap") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>/rekap"><i class="fa fa-check-square"></i> <span>Rekap
                        Soal</span></a></li>
            <li class="header">Pengaturan</li>
            <li class="<?php if ($menu == "pengguna") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>/pengguna"><i class="fa fa-user"></i>
                    <span>Pengguna</span></a></li>
            <li class="<?php if ($menu == "identitas" || $menu == "profile" || $menu == "hubungi" || $menu == "penutup" || $menu == "gantipass") {
                            echo 'active';
                        } ?> treeview">
                <a href="#">
                    <i class="fa fa-gears"></i>
                    <span>Pengaturan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($menu == "identitas") {
                                    echo 'active';
                                } ?>"><a href="<?php echo base_url(); ?>/identitas"><i class="fa fa-circle-o"></i>
                            Identitas</a></li>
                    <li class="<?php if ($menu == "penutup") {
                                    echo 'active';
                                } ?>"><a href="<?php echo base_url(); ?>/penutup"><i class="fa fa-circle-o"></i>
                            Penutup</a></li>
                    <li class="<?php if ($menu == "hubungi") {
                                    echo 'active';
                                } ?>"><a href="<?php echo base_url(); ?>/hubungi"><i class="fa fa-circle-o"></i>
                            Hubungi Kami</a>
                    </li>
                    <li class="<?php if ($menu == "profile") {
                                    echo 'active';
                                } ?>"><a href="<?php echo base_url(); ?>/profile"><i class="fa fa-circle-o"></i>
                            Profil</a></li>
                    <li class="<?php if ($menu == "gantipass") {
                                    echo 'active';
                                } ?>"><a href="<?php echo base_url(); ?>/gantipass"><i class="fa fa-circle-o"></i>
                            Ganti Password</a>
                    </li>
                </ul>
            </li>

        </ul>
    </section>
</aside>