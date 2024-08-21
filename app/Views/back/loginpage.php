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
                    <h3>Please Select How you wish to login</h3>
                    <div class="input-field">
                        <!-- <input type="submit" class="submit" value="Sign Up"> -->
                        <button id="btnProses" type="button" class="btn btn-primary btn-block btn-flat submit"
                            onclick="location.href='loginsiswa';">Leap Account</button>

                        <button id="btnProses" type="button" class="btn btn-primary btn-block btn-flat submit"
                            onclick="location.href='logininstansi';">School Account</button>
                    </div>
                    <div class="signin">
                        <span>Don’t have an leap account? <a href="register">Sign Up
                                here.</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>