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
                <h1>Leapverse Question Bank</h1>
                <p>Having trouble finding English practice questions to help you study for school exams? Are you getting
                    ready to compete in an English event or Olympiad? Or perhaps you simply want to measure how well
                    your English is? Try the Leap English test questions now! It's Free!</p>
                <!-- <div class="d-flex justify-content-center justify-content-lg-start">
                    <a href="#portfolio" class="btn-get-started scrollto">Try for Free</a>
                </div> -->
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                <img src="front/images/icon.png" class="img-fluid animated" alt="icon">
            </div>
        </div>
    </div>

</section><!-- End Hero -->

<main id="main">

    <!-- ======= About Us Section ======= -->
    <!-- <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>About Us</h2>
            </div>

            <div class="row content">
                <div class="col-lg-6">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                        velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                        culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0">
                    <p>
                        Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                        velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                        culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
            </div>

        </div>
    </section> -->
    <section class="video-sec-area pb-100 pt-40 menu-area" id="about">
        <div class="container d-flex justify-content-center" data-aos="fade-up">

            <div class="row justify-content-center">

                <div class=" row justify-content-center align-items-center">
                    <div class="col-lg-6 video-right justify-content-center align-items-center d-flex"
                        data-aos="fade-right">
                        <div class="overlay overlay-bg"></div>
                    </div>
                    <div class="col-lg-6 video-left" data-aos="fade-left">
                        <h6>Data visualization.</h6>
                        <h1>Lorem ipsum dolor sit amet</h1>
                        <p><span>We are here to listen from you deliver exellence</span></p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temp or incididunt
                            ut
                            labore et dolore magna aliqua. Ut enim ad minim.
                        </p>
                    </div>
                </div>

                <div class="row justify-content-center align-items-center pt-5">
                    <div class="col-lg-6 video-left" data-aos="fade-right">
                        <h6>Data visualization.</h6>
                        <h1>Lorem ipsum dolor sit amet</h1>
                        <p><span>We are here to listen from you deliver exellence</span></p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temp or incididunt
                            ut
                            labore et dolore magna aliqua. Ut enim ad minim.
                        </p>
                    </div>
                    <div class="col-lg-6 video-right justify-content-center align-items-center d-flex"
                        data-aos="fade-left">
                        <div class="overlay overlay-bg"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End About Us Section -->

    <!-- ======= Services Section ======= -->
    <!-- <section id="services" class="services section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Explore Our <span class="yellow">Exciting</span> Features</h2>
                <p>Discover the extraordinary advantages awaiting you when you choose to engage with our platform. By logging in and subscribing, you gain access to an array of exclusive features designed to enhance your experience.</p>
            </div>

            <div class="row">
                <div class="col-xl-4 col-md-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon-box">
                        <img src="front/images/feature1.png" alt="feature" class="feature-image" width="140px">
                        <h4>Accessible Question Bank</h4>
                        <p>All questions are designed to be solvable, ensuring a positive learning experience</p>
                    </div>
                </div>

                <div class="col-xl-4 col-md-4 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
                    <div class="icon-box">
                        <img src="front/images/feature2.png" alt="feature" class="feature-image" width="140px">
                        <h4>Sessions with Instructors</h4>
                        <p>Schedule meetings with experienced instructors.</p>
                    </div>
                </div>

                <div class="col-xl-4 col-md-4 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="300">
                    <div class="icon-box">
                        <img src="front/images/feature3.png" alt="feature" class="feature-image" width="140px">
                        <h4>Track Your Progress</h4>
                        <p>Keep track of your learning journey with a comprehensive history of your solved questions.</p>
                    </div>
                </div>


            </div>

        </div>
    </section> -->

    <!-- End Services Section -->

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
        <div class="container d-flex justify-content-center " data-aos="zoom-in">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>Try it Now!!!</h1>
                    <h5> "Start improving your knowledge now! Explore our Question Bank."</h5>
                    <div class="cta-buttons">
                        <a class="cta-btn mb-3" href="trial">Test Yourself</a>
                        <a class="cta-btn" href="logininstansi">Test as School</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- End Cta Section -->

    <!-- ======= Team Section ======= -->
    <section id="team" class="team menu-area">
        <div class="container d-flex justify-content-center" data-aos="fade-up">

            <div class="row justify-content-center">

                <div class="section-title">
                    <h2>Find Your Questions</h2>
                    <p>Excited to practice? Discover the questions you want to work on right here!</p>
                </div>

                <div class="row-btn" style="margin-top: 40px;" id="wadah">

                </div>
                <button id="btnMore" class="btn2 btn-info btn-sm" style="margin-top: 20px" onclick="loadmore();">Read
                    More . . .</button>
            </div>
        </div>
    </section><!-- End Team Sectidiv-->


</main><!-- End #main -->

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
    var limit = 8;

    $(document).ready(function() {

        load_data("");

        $('#search_text').keyup(function() {
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
            success: function(data) {
                $('#wadah').html(data.status);
                if (data.status_bottom === "aktif") {
                    $('#btnMore').show();
                } else {
                    $('#btnMore').hide();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error load data');
            }
        });
    }

    function loadmore() {
        limit *= 2;
        load_data("");
    }
</script>