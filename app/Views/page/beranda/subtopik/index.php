<!-- ======= Header ======= -->

<header style="background-color:rgba(40, 58, 90, 0.9)">
    <div class="container d-flex justify-content-between align-items-center p-3">
        <a href="<?php echo base_url(); ?>" class=" me-auto"><img
                src="<?php echo base_url(); ?>front/images/leapverse.png" class="img-fluid" alt="logo" width="90px"
                height="70px"></a>

        <div>
            <a href="<?php echo base_url() ?>" class="btn-back-home"></i>
                Back to Main Home</a>

        </div>

    </div>
</header>
<!-- End Header -->

<main id="main">
    <!-- ======= Team Section ======= -->
    <section id="team" class="team menu-area" style="height: 100vh;">
        <div class="container d-flex justify-content-center" data-aos="fade-up">

            <div class="row justify-content-center">
                <div class="col-sm-12 text-center">
                    <h5> TOPIC : <?php echo $topik; ?></h5>
                    <p>Here are all the subtopic for this topic that we have.</p>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control" name="search_text" id="search_text"
                        placeholder="Search here..">
                </div>

                <div class="row-btn" style="margin-top: 40px;" id="wadah">

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
                                    class="lab la-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


</main>
<!-- End #main -->


<!-- Vendor JS Files -->
<script src="<?php echo base_url(); ?>front/assets/js/aos.js"></script>
<script src="<?php echo base_url(); ?>front/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>front/assets/js/glightbox.min.js"></script>
<script src="<?php echo base_url(); ?>front/assets/js/isotope.pkgd.min.js"></script>
<script src="<?php echo base_url(); ?>front/assets/js/swiper-bundle.min.js"></script>
<script src="<?php echo base_url(); ?>front/assets/js/noframework.waypoints.js"></script>
<script src="<?php echo base_url(); ?>front/assets/js/validate.js"></script>

<!-- Template Main JS File -->
<script src="<?php echo base_url(); ?>front/src/js/main.js"></script>


<script>
$(document).ready(function() {

    load_data();

    function load_data(search) {
        $.ajax({
            url: "<?php echo base_url(); ?>subtopic/ajaxlist/<?php echo $idtopik; ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                query: search
            },
            success: function(data) {
                $('#wadah').html(data.status);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error load data');
            }
        });
    }

    $('#search_text').keyup(function() {
        var search = $("#search_text").val();
        if (search != '') {
            load_data(search);
        } else {
            load_data();
        }
    });

});
</script>