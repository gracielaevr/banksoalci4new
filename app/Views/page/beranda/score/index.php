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
</style>
<div class="menu-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="navigation" style="padding: 20px 0 0;">
                    <div class="logo-das">
                        <a href="<?php echo base_url(); ?>"><img
                                src="<?php echo base_url(); ?>front/images/leapverse.png" class="img-fluid"
                                alt="logo-das" style="height: 70px;"></a>
                    </div>
                    <div class="nav-btns">
                        <div class="widget p-0" style="min-height:0">
                            <div class="social-link">
                                <ul>
                                    <li><a target="_blank" href="https://leapverse.leapsurabaya.sch.id/">Leapverse</a>
                                    </li>
                                    <li><a target="_blank" href="https://leapsurabaya.sch.id/"><i
                                                class="las la-home"></i></a></li>
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
            <div class="col-lg-12">
                <div class="ugf-dontation-wrap">
                    <div class="ugf-donation" style="padding: 20px 0;">
                        <div class="ugf-form-card cc" style="margin: auto;">
                            <div class="card-header">
                                <div class="covid-wrap">
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
                                                } ?>
                                            </h4>
                                            <h3>Thank you! <br> Your submission has been received.</h3>

                                            <!-- <a href="<php echo base_url() . 'test/subscribe/' ?>" class="
                                                button-reloads" style="margin-bottom: 20px;">Pembahasan
                                                Soal</a> -->
                                            <?php if ($score < 100) { ?>
                                                <a href="<?php echo base_url() . 'subtopic/start/' . $idsub; ?>"
                                                    class="buttons-reloads" style="margin-bottom: 20px;">Try Again</a>
                                            <?php } ?>
                                            <a href="<?php echo base_url(); ?>" class="button-reload">Back to main
                                                home</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
        rating.innerHTML = `<span>${ratingScore} ${ratingContent.indexOf("%") >= 0 ? "<small>%</small>" : ""
            }</span>`;
    });
</script>