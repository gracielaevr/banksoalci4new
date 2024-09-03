<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->

        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $foto_profile; ?>" class="img-circle" alt="User Image"
                    style="height: 30px; width: 30px;">
            </div>
            <div class="pull-left info">
                <p><?php echo $nama; ?></p>
                <small><?php echo $nm_role; ?></small>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">

            <li class="<?php if ($menu == "homeadmins") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>homeadmins"><i class="fa fa-home"></i>
                    <span>Beranda</span></a></li>
            <li class="header">Master Data</li>
            <li class="<?php if ($menu == "soalinstansi") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>soalinstansi/index"><i class="fa fa-book"></i>
                    <span>Soal</span></a>
            </li>
            <li class="<?php if ($menu == "pengguna") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>pengguna/index"><i class="fa fa-user"></i>
                    <span>Siswa</span></a>
            </li>
            <li class="header">Hasil</li>
            <li class="<?php if ($menu == "rekap") {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(); ?>rekap"><i class="fa fa-book"></i>
                    <span>Rekap Soal</span></a></li>
            <li class="header">Pengaturan</li>
            <li class="<?php if ($menu == "profilsiswa" || $menu == "gantipass") {
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
                    <li class="<?php if ($menu == "profilsiswa") {
                                    echo 'active';
                                } ?>"><a href="<?php echo base_url(); ?>profilsiswa"><i class="fa fa-circle-o"></i>
                            Profil</a></li>
                    <li class="<?php if ($menu == "gantipasssiswa") {
                                    echo 'active';
                                } ?>"><a href="<?php echo base_url(); ?>gantipasssiswa"><i class="fa fa-circle-o"></i>
                            Ganti
                            Password</a></li>
                </ul>
            </li>

        </ul>
    </section>
</aside>