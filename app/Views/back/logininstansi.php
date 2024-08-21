<div class="wrapper">
    <?php include('modal.php'); ?>
    <div class="container main">
        <div class="row login-card">
            <div class="col-md-6 side-image">
                <div class="logo">
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>front/images/leapverse.png"
                            class="img-fluid" alt="logo" width="150px" height="70px"></a>
                </div>
                <div class="icon">
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>front/images/icon.png"
                            class="img-fluid" alt="icon" width="550px" height="100px"></a>
                </div>
            </div>
            <div class="col-md-6 right">
                <div class="input-box">
                    <header>Hello</header>
                    <h3>Login to your School account</h3>
                    <div class="input-field">
                        <input type="text" class="input" id="email" name="email" required autocomplete="off">
                        <label for="email">Email Address</label>
                    </div>
                    <div class="input-field">
                        <input type="password" class="input" id="pass" name="pass" required>
                        <label for="pass">Password</label>
                    </div>
                    <div class="remember-input">
                        <input type="checkbox" value="lsRememberMe" id="rememberMe">
                        <label for="rememberMe">Remember me</label>
                        <div class="forgot-password">
                            <a href="">
                                Forgot Password?
                            </a>
                        </div>
                    </div>
                    <div class="input-field">
                        <!-- <input type="submit" class="submit" value="Sign Up"> -->
                        <button id="btnProses" type="button" class="btn btn-primary btn-block btn-flat submit"
                            onclick="proses();">Sign In</button>
                    </div>
                    <div class="signin">
                        <span>Don’t have an account? <a>Contact Your School Administrator</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            url: "<?php echo base_url(); ?>logininstansi/proses",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(response) {
                $('#btnProses').text('Sign In');
                $('#btnProses').attr('disabled', false);

                if (response.status === "ok_instansi") {
                    window.location.href = "<?php echo base_url(); ?>homeinstansi";
                } else if (response.status === "ok_admins") {
                    window.location.href = "<?php echo base_url(); ?>homeadmins";
                } else if (response.status === "ok_gurus") {
                    window.location.href = "<?php echo base_url(); ?>homegurus";
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

function displayModal(message, redirect = false) {
    var modal = document.getElementById('registrationModal');
    var modalMessage = document.getElementById('modalMessage');

    modalMessage.innerHTML = message;

    // Tampilkan modal
    modal.style.display = 'block';

    // Redirect jika diperlukan setelah beberapa detik
    if (redirect) {
        setTimeout(function() {
            window.location.href = "<?php echo base_url(); ?>logininstansi";
        }, 3000); // Redirect setelah 3 detik (sesuaikan sesuai kebutuhan)
    }
}

function closeModal() {
    var modal = document.getElementById('registrationModal');
    modal.style.display = 'none';
}
</script>