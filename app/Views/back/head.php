<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Bank Soal</title>
        <link rel="icon" href="<?php echo $logo; ?>" type="image/x-icon">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/back/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/back/bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/back/bower_components/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/back/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/back/dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/back/bower_components/jvectormap/jquery-jvectormap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/back/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/back/bower_components/bootstrap-daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/back/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/back/bower_components/select2/dist/css/select2.min.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>/back/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <script src="<?php echo base_url(); ?>/back/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>/tinymce/tinymce.min.js"></script>
        <script src="<?php echo base_url(); ?>/back/bower_components/select2/dist/js/select2.full.min.js"></script>

        <script type="text/javascript">
            
            function back(){
                window.history.back();
            }
            
            function hanyaAngka(e, decimal) {
                var key;
                var keychar;
                if (window.event) {
                    key = window.event.keyCode;
                } else if (e) {
                    key = e.which;
                } else {
                    return true;
                }
                keychar = String.fromCharCode(key);
                if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
                    return true;
                } else if ((("0123456789").indexOf(keychar) > -1)) {
                    return true;
                } else if (decimal && (keychar == ".")) {
                    return true;
                } else {
                    return false;
                }
            }
            
            function batas_angka(input, batas) {
                if (input.value < 0){ input.value = 0;}
                if (input.value > batas) {input.value = batas;}
            }
        </script>
        
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="<?php echo base_url(); ?>" class="logo">
                    <span class="logo-mini"><b>BS</b></span>
                    <span class="logo-lg">Bank<b>Soal</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo $foto_profile; ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $nama; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img src="<?php echo $foto_profile; ?>" class="img-circle" alt="User Image">
                                        <p>
                                            <?php echo $nama; ?>
                                            <small><?php echo $nm_role; ?></small>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <?php if ($role == "R00001"){?>
                                            <a href="<?php echo base_url(); ?>/profile" class="btn btn-default btn-flat">Profil</a>
                                            <?php }elseif ($role == "R00002"){?>
                                            <a href="<?php echo base_url(); ?>/profilguru" class="btn btn-default btn-flat">Profil</a>
                                            <?php }elseif ($role == "R00003"){?>
                                            <a href="<?php echo base_url(); ?>/profilsiswa" class="btn btn-default btn-flat">Profil</a>
                                            <?php }elseif ($role == "R00004"){?>
                                            <a href="<?php echo base_url(); ?>/profilinstansi" class="btn btn-default btn-flat">Profil</a>
                                            <?php }else{}?>
                                        </div>
                                        <div class="pull-right">
                                            <?php if ($role == "R00003"){?>
                                            <a href="<?php echo base_url(); ?>/loginsiswa/logout" class="btn btn-default btn-flat">Keluar</a>
                                            <?php }elseif ($role == "R00004"){?>
                                            <a href="<?php echo base_url(); ?>/logininstansi/logout" class="btn btn-default btn-flat">Keluar</a>    
                                            <?php }else{?>
                                            <a href="<?php echo base_url(); ?>/login/logout" class="btn btn-default btn-flat">Keluar</a>
                                            <?php }?>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>