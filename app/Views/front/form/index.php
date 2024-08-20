<div class="ugf-wraper3">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="navigation">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>/"><img
                                src="<?php echo base_url(); ?>/front/images/leapverse.png" class="img-fluid" alt="logo"
                                style="height: 70px;"></a>
                    </div>
                    <div class="nav-btns">
                        <a href="<?php echo base_url(); ?>/" class="get">Back to Main</span> Home</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ugf-dontation-wrap">
                    <div class="ugf-donation">
                        <div class="ugf-form-card cc" style="margin: auto;">
                            <div class="card-header">
                                <div class="covid-wrap">
                                    <div class="form">
                                        <input type="hidden" id="idpeserta" value="<?php echo $kode; ?>">
                                        <div class="covid-test-wrap test-step active">
                                            <h3 style="text-align: center;">WELL DONE!</h3>
                                            <h3 style="text-align: center;">YOU HAVE FINISHED THIS EXCERCISE!</h3>
                                            <hr>
                                            <p style="text-align: center;">Fill out this form to get your score!</p>
                                            <div class="step-block">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="nama"
                                                                name="nama" placeholder="Your Name">
                                                            <span hidden="hidden" class="error er" id="errorname">*
                                                                Required</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input type="email" class="form-control" id="email"
                                                                name="email" placeholder="Email" required>
                                                            <span hidden="hidden" class="error er" id="errormail">*
                                                                Required</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="tlp" name="tlp"
                                                                placeholder="Phone Number"
                                                                onkeypress="return hanyaAngka(event,false);">
                                                            <span hidden="hidden" class="error er" id="errorphone">*
                                                                Required</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="button" id="btnSave" name="btnSave"
                                                    onclick="simpan();">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="footer">
                    <div class="footer-social">
                        <a target="_blank" href="https://leapverse.leapsurabaya.sch.id/">Leapverse</a>
                        <a target="_blank" href="https://leapsurabaya.sch.id/"><i class="las la-home"></i></a>
                        <a target="_blank" href="https://www.facebook.com/LeapSurabaya/?locale=id_ID"><i
                                class="lab la-facebook-f"></i></a>
                        <a target="_blank"
                            href="https://www.linkedin.com/company/leap-english-digital-class/mycompany/"><i
                                class="lab la-linkedin-in"></i></a>
                        <a target="_blank" href="https://www.instagram.com/leapsurabaya/?hl=en"><i
                                class="lab la-instagram"></i></a>
                    </div>
                    <div class="copyright-text">
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
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
    if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) {
        return true;
    } else if ((("0123456789").indexOf(keychar) > -1)) {
        return true;
    } else if (decimal && (keychar == ".")) {
        return true;
    } else {
        return false;
    }
}

function preg_match(regex, str) {
    return (new RegExp(regex).test(str))
}

function simpan() {
    // var idpeserta = document.getElementById('idpeserta').value;
    var nama = document.getElementById('nama').value;
    var email = document.getElementById('email').value;
    var tlp = document.getElementById('tlp').value;

    var tot = 0;
    if (nama === '') {
        document.getElementById("errorname").removeAttribute("hidden");
    } else {
        document.getElementById("errorname").setAttribute("hidden", "hidden");
        tot += 1;
    }
    if (email === '') {
        document.getElementById("errormail").removeAttribute("hidden");
    } else {
        document.getElementById("errormail").setAttribute("hidden", "hidden");
        tot += 1;
    }
    if (tlp === '') {
        document.getElementById("errorphone").removeAttribute("hidden");
    } else {
        document.getElementById("errorphone").setAttribute("hidden", "hidden");
        tot += 1;
    }
    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", email)) {
        document.getElementById("errormail").removeAttribute("hidden");
    } else {
        document.getElementById("errormail").setAttribute("hidden", "hidden");
        tot += 1;
    }


    if (tot === 3) {
        var url = "<?php echo base_url(); ?>/test/process/<?php echo $kode; ?>";

        var form_data = new FormData();
        // form_data.append('idpeserta', idpeserta);
        form_data.append('nama', nama);
        form_data.append('email', email);
        form_data.append('tlp', tlp);

        // ajax adding data to database
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(data) {
                if (data.status === "ok") {
                    window.location.href = "<?php echo base_url(); ?>/test/score/" + data.id;
                }

                $('#btnSimpan').text('Save'); //change button text
                $('#btnSimpan').attr('disabled', false); //set button enable 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSimpan').text('Save'); //change button text
                $('#btnSimpan').attr('disabled', false); //set button enable 
            }
        });
    }
}
</script>