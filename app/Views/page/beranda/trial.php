<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">
        <a href="<?php echo base_url(); ?>" class=" me-auto"><img
                src="<?php echo base_url(); ?>front/images/leapverse.png" class="img-fluid" alt="logo" width="90px"
                height="70px"></a>

        <nav id="navbar" class="navbar ml-auto">
            <ul>
                <!-- Dropdown for Login -->
                <li class="list-inline-item dropdown ">
                    <a class="btn btn-login dropdown-toggle" href="#" role="button" id="loginDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Login
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                        <li><a class="dropdown-item" href="loginsiswa">Login as Siswa</a></li>
                        <li><a class="dropdown-item" href="logininstansi">Login as Teacher</a></li>
                    </ul>
                </li>

                <!-- Dropdown for Sign Up -->
                <li class="list-inline-item dropdown ">
                    <a class="btn btn-signup dropdown-toggle" href="#" role="button" id="signupDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Sign Up
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="signupDropdown">
                        <li><a class="dropdown-item" href="register">Sign Up as Siswa</a></li>
                        <li><a class="dropdown-item" href="registerinstansi">Sign Up as Teacher</a></li>
                    </ul>
                </li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <!-- .navbar -->

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">
    <!-- style="background: linear-gradient(to bottom, #d6eaf8, #ffffff);" -->
    <div class="container d-flex justify-content-center">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                data-aos="fade-up" data-aos-delay="200">
                <h4>Welcome to Leap-Eng - Interactive English Practice &
                    Discussion Platform
                </h4>
                <center>

                </center>
                <p>This platform is designed to help students enhance their English skills through practice questions
                    and interactive discussions. Get direct guidance from professional teachers, both local and
                    international, in <b> 25-minute </b>discussion sessions. <br>
                    We offer a wide range of English practice questions, including grammar, vocabulary, reading
                    comprehension, and more, to help you prepare for exams and academic challenges.

                </p>

                <div class="d-flex justify-content-center justify-content-lg-start">
                    <a href="#team" class="btn-get-started scrollto">Try for Free</a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                <img src="front/images/icon.png" class="img-fluid animated" alt="icon">
            </div>
        </div>
    </div>

</section><!-- End Hero -->


<main id="main">



    <!-- ======= Team Section ======= -->
    <section id="team" class="team menu-area">
        <div class="container d-flex justify-content-center" data-aos="fade-up">

            <div class="row justify-content-center">
                <div class="col-sm-12 text-center">
                    <h2>Find Your Questions</h2>
                    <p>Excited to practice? Discover the questions you want to work on right here!</p>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control" name="search_text" id="search_text"
                        placeholder="Search here..">
                </div>

                <div class="row-btn" style="margin-top: 40px;" id="wadah">

                </div>
                <div class="col-sm-12 d-flex justify-content-center mt-3">
                    <button id="btnMore" class="btn2 btn-info btn-sm m-0" onclick="more();">Read More . . .</button>
                </div>
            </div>
        </div>
    </section>


</main>
<!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="container d-flex justify-content-between">
        <div class="footer-left">
            <div class="copyright">
                &copy; Copyright <strong><span>LEAP English & Digital</span></strong>. All Rights Reserved
            </div>
        </div>

        <div class="footer-right">
            <ul>
                <li><a target="_blank" href="https://leapverse.leapsurabaya.sch.id/">Leapverse</a></li>
                <li><a target="_blank" href="https://leapsurabaya.sch.id/"><i class="las la-home"></i></a>
                </li>
                <li><a target="_blank" href="https://www.facebook.com/LeapSurabaya/?locale=id_ID"><i
                            class="lab la-facebook-f"></i></a></li>
                <li><a target="_blank" href="https://www.linkedin.com/company/leap-english-digital-class/mycompany/"><i
                            class="lab la-linkedin-in"></i></a></li>
                <li><a target="_blank" href="https://www.instagram.com/leapsurabaya/?hl=en"><i
                            class="lab la-instagram"></i></a></li>
            </ul>
        </div>
    </div>

</footer><!-- End Footer -->
<!-- End Footer -->

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="front/assets/js/aos.js"></script>
<script src="front/assets/js/bootstrap.bundle.min.js"></script>
<script src="front/assets/js/glightbox.min.js"></script>
<script src="front/assets/js/isotope.pkgd.min.js"></script>
<script src="front/assets/js/swiper-bundle.min.js"></script>
<script src="front/assets/js/noframework.waypoints.js"></script>
<script src="front/assets/js/validate.js"></script>

<!-- Template Main JS File -->
<script src="front/src/js/main.js"></script>

<script>
    var limit = 10;

    $(document).ready(function () {

        load_data("");

        $('#search_text').keyup(function () {
            var search = $("#search_text").val();
            if (search != "") {
                load_data(search);
            } else {
                load_data("");
            }
        });
    });

    function load_data(search) {
        $.ajax({
            url: "<?php echo base_url(); ?>topic/ajaxlist",
            type: "POST",
            dataType: "JSON",
            data: {
                query: search,
                limit: limit
            },
            success: function (data) {
                $('#wadah').html(data.status);
                if (data.status_bottom === "aktif") {
                    $('#btnMore').show();
                } else {
                    $('#btnMore').hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error load data');
            }
        });
    }

    // function loadmore() {
    //     limit *= 2;
    //     load_data("");
    // }

    function more() {
        Swal.fire({
            icon: 'error',
            title: 'Ups sorry!',
            text: 'Register, to get more questions ',
        }).then(function () {
            window.location.href = "<?php echo base_url() . 'register/' ?>";
        })
    }
</script>