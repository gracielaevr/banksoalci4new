<div class="ugf-wraper3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="navigation" style="padding: 40px 0 0;">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>"><img
                                src="<?php echo base_url(); ?>front/images/leapverse.png" class="img-fluid" alt="logo"
                                style="height: 70px;"></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ugf-dontation-wrap">
                    <div class="ugf-donation">
                        <div class="ugf-form-card cc" style="margin: 0 auto;  float: none; margin-bottom: 10px;">
                            <div class="card-header">
                                <div class="form">
                                    <form>
                                        <div class="covid-test-wrap test-step thankyou-sec active"
                                            style="text-align: center;">
                                            <h3>Jawaban Anda Telah Tersimpan.</h3>
                                            <h3 style="margin-bottom : 10px; margin-top: 10px;">Berikut Hasilnya :</h3>
                                            <h4 style="color:#1e85ff; margin-bottom: 0; margin-top: 0;">
                                                <?php foreach ($komentar->getResult() as $row) {
                                                    if ($score >= $row->min && $score <= $row->max) {
                                                        echo '"' . $row->komentar . '"';
                                                    }
                                                } ?></h4>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="widget" style="min-height: 0;">
                    <div class="social-link">
                        <ul>
                            <li><a target="_blank" href="https://leapverse.leapsurabaya.sch.id/">Leapverse</a></li>
                            <li><a target="_blank" href="https://leapsurabaya.sch.id/"><i class="las la-home"></i></a>
                            </li>
                            <li><a target="_blank" href="https://www.facebook.com/LeapSurabaya/?locale=id_ID"><i
                                        class="lab la-facebook-f"></i></a></li>
                            <li><a target="_blank"
                                    href="https://www.linkedin.com/company/leap-english-digital-class/mycompany/"><i
                                        class="lab la-linkedin-in"></i></a></li>
                            <li><a target="_blank" href="https://www.instagram.com/leapsurabaya/?hl=en"><i
                                        class="lab la-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>