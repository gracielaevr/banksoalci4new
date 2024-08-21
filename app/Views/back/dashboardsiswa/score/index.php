<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>front/dashboard_new/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?= base_url() ?>front/images/leapverse.png">
    <title>Leapverse Question Bank</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Nucleo Icons -->
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Files -->
    <link id="pagestyle" href="<?= base_url() ?>front/dashboard_new/assets/css/argon-dashboard.css?v=2.0.4"
        rel="stylesheet" />


    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard/assets/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard/assets/css/components.css">
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard_new/assets/css/style.css">
    <style>
    .error {
        color: red;
    }

    .er {
        float: left;
        margin-bottom: 10px;
    }
    </style>
    <script>
    function linkwa(nomor, text) {
        window.open("https://wa.me/" + nomor + "?text=" + text, "blank");
    }
    </script>
    <style>
    :root {
        --rating-size: 10rem;
        --bar-size: 1rem;
        --background-color: #e7f2fa;
        --rating-color-default: #2980b9;
        --rating-color-background: #c7e1f3;
        --rating-color-good: #27ae60;
        --rating-color-meh: #f1c40f;
        --rating-color-bad: #e74c3c;
    }

    /* Rating item */
    .rating {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 100%;
        overflow: hidden;
        margin-left: auto;
        margin-right: auto;
        width: 50%;

        background: var(--rating-color-default);
        color: var(--rating-color-default);
        width: var(--rating-size);
        height: var(--rating-size);

        /* Basic style for the text */
        font-size: calc(var(--rating-size) / 3);
        line-height: 1;
    }

    /* Rating circle content */
    .rating span {
        position: relative;
        display: flex;
        font-weight: bold;
        z-index: 2;
    }

    .rating span small {
        font-size: 0.5em;
        font-weight: 900;
        align-self: center;
    }

    /* Bar mask, creates an inner circle with the same color as thee background */
    .rating::after {
        content: "";
        position: absolute;
        top: var(--bar-size);
        right: var(--bar-size);
        bottom: var(--bar-size);
        left: var(--bar-size);
        background: var(--background-color);
        border-radius: inherit;
        z-index: 1;
    }

    /* Bar background */
    .rating::before {
        content: "";
        position: absolute;
        top: var(--bar-size);
        right: var(--bar-size);
        bottom: var(--bar-size);
        left: var(--bar-size);
        border-radius: inherit;
        box-shadow: 0 0 0 1rem var(--rating-color-background);
        z-index: -1;
    }

    /* Classes to give different colors to ratings, based on their score */
    .rating.good {
        background: var(--rating-color-good);
        color: var(--rating-color-good);
    }

    .rating.meh {
        background: var(--rating-color-meh);
        color: var(--rating-color-meh);
    }

    .rating.bad {
        background: var(--rating-color-bad);
        color: var(--rating-color-bad);
    }

    /* Call */

    .c-link {
        font-weight: bold;
    }
    </style>
</head>

<body class="layout-3">
    <div id="app">
        <nav class="navbar navbar-expand-lg main-navbar d-flex justify-content-between pt-3 pb-3 ps-5 pe-5 " style="background: rgb(255,255,255);
background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(47,104,170,1) 100%);
">
            <img src="<?= base_url() ?>front/images/leapverse.png" alt="" width="80px">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="ms-3"><?= $nama; ?></span>
                        <img src="<?= $foto_profile ?>" class="avatar avatar-sm  ms-3" aria-hidden="true">

                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-2 me-sm-n2"
                        aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item border-radius-md" href="<?= base_url() ?>logout">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="ni ni-bold-right text-danger me-3 text-center"></i>Logout
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="<?= base_url() ?>profilestudent">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="ni ni-single-02 text-success me-3"></i>Profile
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <nav
            class="navbar navbar-expand-lg navbar-expand-md navbar-expand-sm navbar-expand pt-2 pb-2 ps-5 pe-5 bg-white">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= base_url() ?>homesiswa" class="nav-link text-center"><i
                            class="ni ni-tv-2 text-primary text-sm opacity-10 me-2"></i><span>Dashboard</span></a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>history" class="nav-link text-center"><i
                            class="ni ni-bullet-list-67 text-warning text-sm opacity-10 me-2"></i><span>History</span></a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>session" class="nav-link text-center"><i
                            class="ni ni-app text-info text-sm opacity-10 me-2"></i><span>Session</span></a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>subscribe" class="nav-link text-center"><i
                            class="ni ni-like-2 text-danger text-sm opacity-10 me-2"></i><span>Subscribe</span></a>
                </li>
            </ul>
        </nav>

        <div class="main-wrapper container mt-5">
            <!-- Main Content -->
            <div class="main-content d-flex justify-content-center">


                <div class="col-lg-5 col-md-7 col-sm-9 shadow-leap p-5" style="border-radius:12px">
                    <form>
                        <div class="covid-test-wrap test-step thankyou-sec active">
                            <h3 style="text-align: center;">YOUR SCORE</h3>
                            <div class="rating center"><?php echo $score; ?></div>
                            <h4 style="text-align: center; color:#1e85ff; margin-bottom: 0;">
                                <?php if ($score > 79) {
                                    echo "Awesome!";
                                } else if ($score < 31) {
                                    echo "You need to redo the exercise.";
                                } else {
                                    echo "You've done an amazing work!";
                                } ?></h4>
                            <h6 class="text-center fw-bold mt-3">Thank you! <br> Your submission has been received.</h6>
                            <span class="text-center mt-3 mb-3"><?= $penutup; ?></span>

                            <a href="#"
                                onclick="linkwa(<?php echo substr_replace($wa, '62', 0, 1) ?>,'<?php echo $text; ?>')"
                                class="btn-score-wa" style="margin-bottom: 20px;">Call
                                Us <i class="fa-brands fa-whatsapp"></i> </a>
                            <?php if ($score < 100) { ?>
                            <a href="<?php echo base_url() . '/start/' . $idsub; ?>" class="btn-score-again"
                                style="margin-bottom: 20px;">Try
                                Again <i class="fa-solid fa-rotate-right"></i></a>
                            <?php } ?>
                            <a href="<?php echo base_url(); ?>homesiswa" class="btn-score-back">Back
                                to main home <i class="fa-solid fa-angles-right"></i></a>
                        </div>
                    </form>
                </div>


            </div>
        </div>


    </div>

    </div>

    <footer class="footer mt-5 pb-3">
        <hr class="horizontal dark mt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="text-start">
                        Copyright &copy; <?= date("Y"); ?> • <a href=""> Leapverse -
                            Bank Soal.</a> All Rights Reserved
                    </div>
                    <div class="footer-right">
                        2.3.0
                    </div>
                </div>

            </div>
        </div>
    </footer>

    <script>
    // Find al rating items
    const ratings = document.querySelectorAll(".rating");

    // Iterate over all rating items
    ratings.forEach((rating) => {
        // Get content and get score as an int
        const ratingContent = rating.innerHTML;
        const ratingScore = parseInt(ratingContent, 10);

        // Define if the score is good, meh or bad according to its value
        const scoreClass =
            ratingScore < 40 ? "bad" : ratingScore < 60 ? "meh" : "good";

        // Add score class to the rating
        rating.classList.add(scoreClass);

        // After adding the class, get its color
        const ratingColor = window.getComputedStyle(rating).backgroundColor;

        // Define the background gradient according to the score and color
        const gradient = `background: conic-gradient(${ratingColor} ${ratingScore}%, transparent 0 100%)`;

        // Set the gradient as the rating background
        rating.setAttribute("style", gradient);

        // Wrap the content in a tag to show it above the pseudo element that masks the bar
        rating.innerHTML = `<span>${ratingScore} ${
    ratingContent.indexOf("%") >= 0 ? "<small>%</small>" : ""
  }</span>`;
    });
    </script>




    <!--   Core JS Files   -->
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/core/popper.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/core/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/chartjs.min.js"></script>
    <!-- General JS Scripts -->
    <script src="<?= base_url() ?>front/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>front/assets/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"
        integrity="sha512-zMfrMAZYAlNClPKjN+JMuslK/B6sPM09BGvrWlW+cymmPmsUT1xJF3P4kxI3lOh9zypakSgWaTpY6vDJY/3Dig=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="<?= base_url() ?>front/dashboard/assets/js/stisla.js"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="<?= base_url() ?>front/dashboard/assets/js/scripts.js"></script>
    <script src="<?= base_url() ?>front/dashboard/assets/js/custom.js"></script>

</body>

</html>