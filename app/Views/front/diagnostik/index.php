<script type="text/javascript">
    function mulai(t) {
        window.location.href = "<?php echo base_url().'/diagnostictest/begin/'.$kode; ?>";
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

    function simpan() {
        var nama = document.getElementById('nama').value;
        var alamat = document.getElementById('alamat').value;
        var instansi = document.getElementById('instansi').value;
        var email = document.getElementById('email').value;
        var tlp = document.getElementById('tlp').value;

        var tot = 0;
        if (nama === '') {
            document.getElementById("errorname").removeAttribute("hidden");
        }else{  document.getElementById("errorname").setAttribute("hidden", "hidden"); tot += 1; }
        if (email === '') {
            document.getElementById("errormail").removeAttribute("hidden");
        }else{ document.getElementById("errormail").setAttribute("hidden", "hidden"); tot += 1; }
        if (tlp === '') {
            document.getElementById("errorphone").removeAttribute("hidden");
        }else{ document.getElementById("errorphone").setAttribute("hidden", "hidden"); tot += 1; }
        if (email != '' && !email.includes("@")) {
          document.getElementById("errormail2").removeAttribute("hidden");
        }else{ document.getElementById("errormail2").setAttribute("hidden", "hidden"); tot += 1; }
        if (instansi === '') {
            document.getElementById("errorinstansi").removeAttribute("hidden");
        }else{ document.getElementById("errorinstansi").setAttribute("hidden", "hidden"); tot += 1; }
        if (alamat === '') {
            document.getElementById("erroralamat").removeAttribute("hidden");
        }else{ document.getElementById("erroralamat").setAttribute("hidden", "hidden"); tot += 1; }
               
        // $.ajax({
        //     url: "<?php //echo base_url(); ?>/diagnostictest/checkmail/"+email,
        //     dataType: 'JSON',
        //     type: 'POST',
        //     success: function (data) {
        //         if (data.status === "ada") {
        //             document.getElementById("errormail3").removeAttribute("hidden");
        //         }else{ 
        //             $('[name="total"]').val(1);
        //         }
        //     }, error: function (jqXHR, textStatus, errorThrown) {
        //         alert('Error get data');
        //     }
        // });

        // if(document.getElementById('total').value === '1'){
        //     tot += 1;
        // }
        //6
        if(tot === 6){
            var url = "<?php echo base_url(); ?>/diagnostictest/process/<?php echo $kode; ?>";
            
            var form_data = new FormData();
            form_data.append('nama', nama);
            form_data.append('alamat', alamat);
            form_data.append('instansi', instansi);
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
                success: function (data) {
                    if(data.status === "ok"){
                      window.location.href = "<?php echo base_url(); ?>/diagnostictest/begin/"+data.id;
                    }

                    $('#btnSimpan').text('Save'); //change button text
                    $('#btnSimpan').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSimpan').text('Save'); //change button text
                    $('#btnSimpan').attr('disabled', false); //set button enable 
                }
            });
        }
    }
</script>
<div class="ugf-wraper2">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="navigation">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>/"><img src="<?php echo base_url(); ?>/front/images/leapverse.png" class="img-fluid" alt="logo" style="height: 70px;"></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ugf-dontation-wrap">
                    <div class="ugf-donation">
                        <div class="ugf-form-card">
                            <div class="card-header">
                                <h1 style="margin-bottom: 10px; color: black;"><?php echo $bidang; ?> Diagnostic Test</h1>
                                <h6 style="margin-bottom: 10px; color: black;">Leap English and Digital Class</h6>
                                <?php echo str_replace("<p>","<p style='margin-bottom: 0; color: black;'>",str_replace("<strong>","<b>",str_replace("</strong>","</b>",str_replace("<ol>","<ol style='color: black;  text-align: left;'>",$instruksi)))); ?>
                                <div class="form">
                                    <input type="hidden" id="total" name="total">
                                    <input type="hidden" id="idpeserta" value="<?php echo $kode; ?>">
                                    <div class="covid-test-wrap test-step active">
                                    <hr>
                                    <p style="text-align: center;">Fill out this form before you started!</p>
                                    <div class="step-block">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Your Name">
                                                <span hidden="hidden" class="error er" id="errorname">* Required</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                                                <span hidden="hidden" class="error er" id="errormail">* Required</span>
                                                <span hidden="hidden" class="error er" id="errormail2">* Invalid Email Address</span>
                                                <span hidden="hidden" class="error er" id="errormail3">* This email is already registered</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <input type="text" class="form-control" id="tlp" name="tlp"  placeholder="Your Phone Number" onkeypress="return hanyaAngka(event,false);">  
                                                <span hidden="hidden" class="error er" id="errorphone">* Required</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <input type="text" class="form-control" id="alamat" name="alamat"  placeholder="Your Domicile">  
                                                <span hidden="hidden" class="error er" id="erroralamat">* Required</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <input type="text" class="form-control" id="instansi" name="instansi"  placeholder="Your Company Name">  
                                                <span hidden="hidden" class="error er" id="errorinstansi">* Required</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <button class="button" id="btnSave" name="btnSave" style="background: #456bab;" onclick="simpan();">I'm ready for the test!</button>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="widget" style="min-height: 0; padding: 0; margin-bottom: 10px;">
                    <div class="social-link">
                        <ul>
                            <li><a target="_blank" href="https://leapverse.leapsurabaya.sch.id/">Leapverse</a></li>
                            <li><a target="_blank"  href="https://leapsurabaya.sch.id/"><i class="las la-home"></i></a></li>
                            <li><a target="_blank" href="https://www.facebook.com/LeapSurabaya/?locale=id_ID"><i class="lab la-facebook-f"></i></a></li>
                            <li><a target="_blank" href="https://www.linkedin.com/company/leap-english-digital-class/mycompany/"><i class="lab la-linkedin-in"></i></a></li>
                            <li><a target="_blank" href="https://www.instagram.com/leapsurabaya/?hl=en"><i class="lab la-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


