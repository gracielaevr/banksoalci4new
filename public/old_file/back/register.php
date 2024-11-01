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
                    <header class="header-regist text-center">Let’s create your account!</header>
                    <div class="input-field">
                        <input type="name" class="input" id="name" name="name" required autocomplete="off">
                        <label for="name">Full Name</label>
                    </div>
                    <div class="input-field">
                        <input type="text" class="input" id="email" name="email" required autocomplete="off">
                        <label for="email">Email Address</label>
                    </div>
                    <div class="input-field">
                        <input type="text" class="input" id="wa" name="wa" required autocomplete="off">
                        <label for="wa">Phone Number</label>
                    </div>
                    <div class="input-field">
                        <input type="text" class="input" id="school_name" name="school_name" required
                            autocomplete="off">
                        <label for="school_name">School Name</label>
                    </div>
                    <div class="input-field">
                        <input type="password" class="input" id="pass" name="pass" required>
                        <label for="pass">Password</label>
                    </div>
                    <!-- <div class="input-field">
                        <input type="password" class="input" id="confirmPass" name="confirmPass" required>
                        <label for="confirmPass">Confirm Password</label>
                    </div> -->
                    <div class="remember-input">
                        <input type="checkbox" value="lsRememberMe" id="agreeTerms" class="checkbox" required>
                        <label for="agreeTerms"><span>Agree to our <a href="">Terms of Services</a> and <a href="">
                                    Privacy Policy</a></span></label>
                    </div>
                    <div class="input-field">
                        <button id="btnProses" type="button" class="btn btn-primary btn-block btn-flat submit"
                            onclick="proses();">Sign Up</button>
                        <!-- <input type="submit" class="submit" value="Sign Up"> -->
                    </div>
                    <div class="signin">
                        <span>Already have an account? <a href="loginsiswa">Sign
                                in
                                here.</a></span>
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

    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var wa = document.getElementById('wa').value;
    var pass = document.getElementById('pass').value;
    var school_name = document.getElementById('school_name').value;
    // var confirmPass = document.getElementById('confirmPass').value;
    // else if (pass !== confirmPass) {
    //     displayModal("Password and confirmation password do not match!");
    // }

    if (name === "") {
        displayModal("Name cannot be empty!");
    } else if (email === "") {
        displayModal("Email cannot be empty!");
    } else if (pass === "") {
        displayModal("Password cannot be empty!");
    } else if (school_name === "") {
        displayModal("School Name cannot be empty!");
    } else {
        var agreeTermsCheckbox = document.getElementById('agreeTerms');
        if (!agreeTermsCheckbox.checked) {
            displayModal("Please agree to our Terms of Services and Privacy Policy.");
            return; // Do not proceed with registration if the checkbox is not checked
        }

        $('#btnProses').text('Processing...');
        $('#btnProses').attr('disabled', true);

        var form_data = new FormData();
        form_data.append('nama', name);
        form_data.append('email', email);
        form_data.append('wa', wa);
        form_data.append('pass', pass);
        form_data.append('school_name', school_name);

        $.ajax({
            url: "<?php echo base_url(); ?>register/proses",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(response) {
                $('#btnProses').text('Sign Up');
                $('#btnProses').attr('disabled', false);

                if (response.status === 200) {
                    displayModal(response.message, true);
                    window.location.href = "<?php echo base_url(); ?>loginsiswa";
                } else {
                    displayModal(response.message);
                }

            },
            error: function(response) {
                displayModal(response.message);
                $('#btnProses').text('Sign Up');
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
            window.location.href = "<?php echo base_url(); ?>loginsiswa";
        }, 3000); // Redirect setelah 3 detik (sesuaikan sesuai kebutuhan)
    }
}

function closeModal() {
    var modal = document.getElementById('registrationModal');
    modal.style.display = 'none';
}
</script>