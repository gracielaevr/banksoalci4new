<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bank Soal</title>
    <link rel="icon" href="<?php echo $logo; ?>" type="image/x-icon">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/plugins/iCheck/square/blue.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-box-body">
            <div class="login-logo">
                <img src="<?php echo $logo; ?>" style="width: 80px;">
                <br>
                <a href="<?php echo base_url(); ?>login">BANK<b>SOAL</b></a>
                <p style="font-size: 14px;"><b>LEAP ENGLISH AND DIGITAL</b></p>
            </div>
            <p style="font-size: 12px; text-align: center;">Silakan masukkan email dan password</p>
            <div class="form-group has-feedback">
                <input id="email" name="email" type="email" class="form-control" placeholder="Email" autocomplete="off"
                    autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input id="pass" name="pass" type="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <p style="font-size: 12px; text-align: center;">don't have an account? <a target="_blank"
                    href="/banksoal/public/register">Join Us</a></p>
            <div class="row">
                <div class="col-xs-8">
                </div>
                <div class="col-xs-4">
                    <button id="btnProses" type="button" class="btn btn-primary btn-block btn-flat"
                        onclick="proses();">Masuk</button>
                </div>
            </div>
            <!--
                <a href="register.html" class="text-center">Pendaftaran mahasiswa</a>
                -->
        </div>
    </div>
    <script src="<?php echo base_url(); ?>back/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>back/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>back/plugins/iCheck/icheck.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#email').keypress(function(e) {
            var key = e.which;
            if (key === 13) {
                $('#pass').focus();
                $('#pass').select();
            }
        });

        $('#pass').keypress(function(e) {
            var key = e.which;
            if (key === 13) {
                proses();
            }
        });
    });

    function proses() {

        var email = document.getElementById('email').value;
        var pass = document.getElementById('pass').value;

        if (email === "") {
            alert("Email tidak boleh kosong");
        } else if (pass === "") {
            alert("Password lama tidak boleh kosong");
        } else {
            $('#btnProses').text('Prosessing...');
            $('#btnProses').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('email', email);
            form_data.append('pass', pass);

            $.ajax({
                url: "<?php echo base_url(); ?>login/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(response) {
                    $('#btnProses').text('Sign In');
                    $('#btnProses').attr('disabled', false);

                    if (response.status === "ok") {
                        window.location.href = "<?php echo base_url(); ?>home";
                    } else if (response.status === "ok_guru") {
                        window.location.href = "<?php echo base_url(); ?>homeguru";
                    } else {
                        alert(response.status);
                    }

                },
                error: function(response) {
                    alert(response.status);
                    $('#btnProses').text('Sign In');
                    $('#btnProses').attr('disabled', false);
                }
            });
        }
    }
    </script>
</body>

</html>