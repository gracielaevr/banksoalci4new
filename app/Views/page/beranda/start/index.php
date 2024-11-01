<script type="text/javascript">
    function mulai(t) {
        if (t > 9) {

            let attempts = localStorage.getItem('quizAttempts') || 0; // Ambil nilai dari localStorage atau default 0
            // console.log(attempts);
            if (attempts < 3) {

                attempts++;
                localStorage.setItem('quizAttempts', attempts); // Simpan nilai baru ke localStorage
                // document.getElementById('status').textContent = 'Anda bisa mengerjakan soal ini';
                window.location.href = "<?php echo base_url() . 'test/start/' . $kode; ?>";
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Ups sorry!',
                    text: 'You can only take 3 tests, register to get unlimited access',
                }).then(function () {
                    window.location.href = "<?php echo base_url() . 'register' ?>";
                })
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Ups sorry!',
                text: 'This test is not ready yet',
            });
        }
    }
</script>
<!-- <div class="ugf-wraper2">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="navigation">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>"><img
                                src="<?php echo base_url(); ?>front/images/leapverse.png" class="img-fluid" alt="logo"
                                style="height: 70px;"></a>
                    </div>
                    <div class="nav-btns">
                        <a href="<?php echo base_url(); ?>" class="get">Back to Main</span> Home</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ugf-dontation-wrap">
                    <div class="ugf-donation">
                        <div class="ugf-form-card">
                            <div class="card-header">
                                <h1 style="margin-bottom: 10px; color: black;">
                                    <?php echo substr($subtopik, 0, strpos($subtopik, "(")); ?></h1>
                                <h6 style="margin-bottom: 10px; color: black;">
                                    <?php echo substr($subtopik, strpos($subtopik, '(')); ?></h6>
                                <p style="margin-bottom: 0;"><b>TOPIC : <?php echo $topik; ?> </b></p>
                                <p style="margin-bottom: 0;"><b>Instructions !!</b></p>
                                <ul style="text-align: justify;">
                                    <li>Number of questions : <b> <?php echo $jml; ?> </b></li>
                                    <li>Must be finished in one sitting. You cannot save and finish later.</li>
                                    <li>Will not let you finish with any questions unattempted.</li>
                                </ul>
                                <div class="form">
                                    <button class="btn" style="background: #456bab;"
                                        onclick="mulai(<?php echo $tot; ?>);">I'm ready for the test!</button>
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
</div> -->

<!-- ======= Header ======= -->

<header class="menu-area">
    <div class="container d-flex justify-content-between align-items-center p-3">
        <a href="<?php echo base_url(); ?>" class=" me-auto"><img
                src="<?php echo base_url(); ?>front/images/leapverse.png" class="img-fluid" alt="logo" width="90px"
                height="70px"></a>

        <div>
            <a href="<?php echo base_url() ?>" class="btn-back-home2">
                Back to Main Home</a>

        </div>

    </div>
</header>
<!-- End Header -->

<!-- ======= Cta Section ======= -->
<section id="cta" class="cta" style="height: 100vh;">
    <div class="container">
        <div class="card-ufg mb-3">
            <div class="ufg-top">
                <h1 style="margin-bottom: 10px; color: black;">
                    <?php echo substr($subtopik, 0, strpos($subtopik, "(")); ?>
                </h1>
                <h6 style="margin-bottom: 10px; color: black;">
                    <?php echo substr($subtopik, strpos($subtopik, '(')); ?>
                </h6>
            </div>

            <div class="ufg-center">

                <p style="margin-bottom: 0;"><b>TOPIC : <?php echo $topik; ?> </b></p>
                <p style="margin-bottom: 0;"><b>Instructions !!</b></p>
                <ul style="text-align: justify;">
                    <li>Number of questions : <b> <?php echo $jml; ?> </b></li>
                    <li>Must be finished in one sitting. You cannot save and finish later.</li>
                    <li>Will not let you finish with any questions unattempted.</li>
                </ul>
            </div>
            <div class="ufg-footer">
                <div class="form">
                    <button class="ufg-btn" id="startQuizButton" onclick="mulai(<?php echo $tot; ?>);">I'm ready
                        for the test!</button>
                </div>
            </div>

        </div>
        <div class="col-lg-12">
            <div class="widget" style="min-height: 0;">
                <div class="social-link">
                    <ul>
                        <li><a style="font-size: 1rem" target="_blank"
                                href="https://leapverse.leapsurabaya.sch.id/">Leapverse</a></li>
                        <li><a style="font-size: 1rem" target="_blank" href="https://leapsurabaya.sch.id/"><i
                                    class="las la-home"></i></a>
                        </li>
                        <li><a style="font-size: 1rem" target="_blank"
                                href="https://www.facebook.com/LeapSurabaya/?locale=id_ID"><i
                                    class="lab la-facebook-f"></i></a></li>
                        <li><a style="font-size: 1rem" target="_blank"
                                href="https://www.linkedin.com/company/leap-english-digital-class/mycompany/"><i
                                    class="lab la-linkedin-in"></i></a></li>
                        <li><a style="font-size: 1rem" target="_blank"
                                href="https://www.instagram.com/leapsurabaya/?hl=en"><i
                                    class="lab la-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End Cta Section -->