<script type="text/javascript">
    function showAllTopics() {
        var hiddenTopics = document.querySelectorAll('.hidden-topic');
        hiddenTopics.forEach(function (topic) {
            topic.style.display = 'block';
            // el.classList.remove('d-none');

        });
        document.querySelector('.read-more').style.display = 'none';
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {


        var search = document.getElementById("searchInput-top");
        var top = document.querySelectorAll(".badge-custom");
        var sub = document.querySelectorAll(".sub-search");
        var read = document.querySelector(".read-more");
        var maxButtons = 8;
        var minButtons = 2;
        search.addEventListener("keyup", function () {
            var searchValue = search.value.toLowerCase();

            var all = [...top, ...sub];


            if (!read) {
                if (searchValue === "") {
                    // Jika pencarian kosong, tampilkan kembali 8 elemen pertama dan "Read More"
                    all.forEach(function (el, index) {
                        if (index < minButtons) {
                            el.classList.remove('d-none');
                            el.style.display = 'block';
                        } else {
                            el.classList.remove('d-none');
                            el.style.display = 'none';
                        }
                    });
                    // read.style.display = 'block';
                    // read.classList.remove('d-none');

                } else {
                    // Jika ada nilai pencarian, filter elemen berdasarkan pencarian
                    all.forEach(function (el) {
                        var content = el.textContent.trim().toLowerCase();
                        if (content.indexOf(searchValue) > -1) {
                            // read.style.display = 'none';
                            el.classList.remove('d-none');
                            el.style.display = 'block';
                        } else {
                            // read.style.display = 'none';
                            el.classList.add('d-none');
                            el.style.display = 'none';
                        }
                    });

                }
            } else {
                if (searchValue === "") {
                    // Jika pencarian kosong, tampilkan kembali 8 elemen pertama dan "Read More"
                    all.forEach(function (el, index) {
                        if (index < maxButtons) {
                            el.classList.remove('d-none');
                            el.style.display = 'block';
                        } else {
                            el.classList.remove('d-none');
                            el.style.display = 'none';
                        }
                    });
                    read.style.display = 'block';
                    // read.classList.remove('d-none');

                } else {
                    // Jika ada nilai pencarian, filter elemen berdasarkan pencarian
                    all.forEach(function (el) {
                        var content = el.textContent.trim().toLowerCase();
                        if (content.indexOf(searchValue) > -1) {
                            read.style.display = 'none';
                            el.classList.remove('d-none');
                            el.style.display = 'block';
                        } else {
                            read.style.display = 'none';
                            el.classList.add('d-none');
                            el.style.display = 'none';
                        }
                    });

                }
            }
        });



    });

    // Fungsi untuk memulai animasi penghitungan
    function animateValue(id, start, end, duration) {
        const element = document.getElementById(id);
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            element.innerText = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Inisialisasi animasi penghitungan untuk setiap elemen dengan kelas "count-number"
    document.addEventListener("DOMContentLoaded", function () {
        const counters = document.querySelectorAll('.count-number');
        counters.forEach(counter => {
            const endValue = parseInt(counter.getAttribute('data-count'), 10);
            animateValue(counter.id, 0, endValue, 2000); // Animasi selama 2 detik
        });

    });

    function openmodal_subs() {
        var modal = document.getElementById('subModal');
        modal.style.display = 'block';
    }
</script>

<div class="row">
    <div class="col-xl-12 col-sm-12 mb-2">
        <div class="card shadow-leap">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-8 welcome-leap">
                        <h5>Welcome Back <br><span class="me-2"><?= $nama; ?></span><img alt="image"
                                src="<?= base_url() ?>front/images/wave.png" width="20px">
                        </h5>
                    </div>
                    <div class="col-4 text-end welcome-leap">
                        <span id="current-day"></span>, <span id="current-date"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Message
<php if (session()->getFlashdata('error')): ?>
    <script>
        alert("<= session()->getFlashdata('error'); ?>");
    </script>
<php endif; ?> -->

<?php if (session()->getFlashdata('notification_free')): ?>
    <marquee behavior="scroll" direction="left" class="text-danger">
        <?= session()->getFlashdata('notification_free'); ?>
    </marquee>
<?php endif; ?>
<?php if (session()->getFlashdata('notification_pending')): ?>
    <div id="ofBar" style="background: #facf2a; color:#000;">
        <div id="ofBar-content">
            <?= session()->getFlashdata('notification_pending') ?>
        </div>
        <button id="closeOfBar">&times;</button>
    </div>
<?php endif; ?>
<h5 class="section-title mb-2">Popular Topics</h5>
<div class="row">
    <?php $count = 0;
    $topik = $topik ?? [];
    foreach ($topik as $key => $value):
        if ($count < 3): ?>
            <div class="col-12 col-md-4 col-lg-4 mb-3">
                <div class="card shadow-leap" style="display: flex; flex-direction: column; height: 100%;">
                    <div class="card-header pb-2" style="flex-shrink: 0;">
                        <?php $badgeClass = ($key % 3 == 0) ? 'badge-blue2' : (($key % 3 == 1) ? 'badge-yellow' : 'badge-blue'); ?>
                        <h5 class="m-0">
                            <span class="badge text-capitalize fw-normal <?= $badgeClass ?>" style="font-size:18px;">
                                <?= $value->nama ?>
                            </span>
                        </h5>
                    </div>
                    <div class="card-body d-flex justify-content-center flex-column align-items-center text-center"
                        style="flex: 1;">
                        <!-- Menampilkan jumlah peserta -->
                        <span class="fw-bold" style="font-family:sans-serif">ATTEMPTED</span>
                        <h1 id="jumlahPeserta<?= $key ?>" class="m-0 count-number" data-count="<?= $value->jumlah_peserta ?>"
                            style="font-size: 5rem; color: #FFC300; font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                            0
                        </h1>
                        <span style="font-family:monospace">times</span>
                    </div>

                    <div class="card-footer d-flex justify-content-between align-items-center"
                        style="background-color: #f8f9fa; border-top: 1px solid #ddd;">
                        <!-- Menampilkan jumlah subtopik -->
                        <p class="m-0 ps-2"><?= $value->jumlah_subtopik ?> Subtopics</p>
                        <div class="ml-auto">
                            <a href="<?= base_url() . 'homesiswa/subtopic/' . str_replace(' ', '-', $value->nama) ?> "><img
                                    alt="image" src="<?= base_url() ?>front/images/arrow1.png" width="30px">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php $count++; ?>
        <?php endif;
    endforeach; ?>
</div>

<div class="d-flex align-items-start justify-content-between mt-3 mb-3 search-leap">

    <h5 class="section-title">Other Topics</h5>

    <div class="search-bar">
        <div class="input-group">
            <input type="text" id="searchInput-top" placeholder="Search topics..." class="form-control ms-2"
                style="box-shadow: 0px 0px 23px 0px rgba(0,0,0,0.3);">
            <div class="input-group-btn">
                <button class="btn btn-primary-leap"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- // Khusus Akun Dari Guru  -->
<?php if ($school_name):
    $topik = $topik ?? [];
    foreach ($topik_school as $key => $value):
        ?>
        <div class="badge-custom shadow-leap">
            <div class="d-flex align-items-center justify-content-between">
                <div class="ml-3">
                    <?php
                    $badgeClass = ($key % 3 == 0) ? 'badge-blue2' : (($key % 3 == 1) ? 'badge-yellow' : 'badge-blue');
                    ?>
                    <span class="badge m-0 text-capitalize fw-normal <?= $badgeClass ?>" style="font-size:18px ;">
                        <?= $value->nama ?>
                    </span>

                    <p class="m-0 ps-2"><?= $value->jumlah_subtopik ?> Subtopics</p>


                </div>
                <a href="<?= base_url() . 'homesiswa/subtopic/' . str_replace(' ', '-', $value->nama) ?> ">

                    <img alt="image" src="<?= base_url() ?>front/images/arrow1.png" width="30px">
                </a>
            </div>

            <!-- Menampilkan data subtopik -->
            <div class="sub-search d-none">
                <h6 class="m-0 ps-2">Subtopic :</h6>
                <?php if (isset($subtopikByTopik[$value->idtopik]) && !empty($subtopikByTopik[$value->idtopik])): ?>
                    <?php foreach ($subtopikByTopik[$value->idtopik] as $subtopik): ?>
                        <ul class="m-0 ps-5">
                            <li><?= $subtopik->nama ?></li>
                        </ul>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Tampilkan pesan atau data kosong jika tidak ada subtopik -->
                    <ul class="m-0 ps-5">
                        <li>Tidak ada subtopik yang tersedia</li>
                    </ul>
                <?php endif; ?>
            </div>

        </div>
        <?php
    endforeach;
endif; ?>

<!-- Other topik -->
<?php
$maxButtons = 8;
$count = 0;
$topik = $topik ?? [];
foreach ($topik as $key => $value):
    if ($count < $maxButtons):
        ?>
        <div class="badge-custom shadow-leap">
            <div class="d-flex align-items-center justify-content-between">
                <div class="ml-3">
                    <?php
                    $badgeClass = ($key % 3 == 0) ? 'badge-blue2' : (($key % 3 == 1) ? 'badge-yellow' : 'badge-blue');
                    ?>
                    <span class="badge m-0 text-capitalize fw-normal <?= $badgeClass ?>" style="font-size:18px ;">
                        <?= $value->nama ?>
                    </span>

                    <p class="m-0 ps-2"><?= $value->jumlah_subtopik ?> Subtopics</p>


                </div>
                <a href="<?= base_url() . 'homesiswa/subtopic/' . str_replace(' ', '-', $value->nama) ?> ">

                    <img alt="image" src="<?= base_url() ?>front/images/arrow1.png" width="30px">
                </a>
            </div>

            <!-- Menampilkan data subtopik -->
            <div class="sub-search d-none">
                <h6 class="m-0 ps-2">Subtopic :</h6>
                <?php if (isset($subtopikByTopik[$value->idtopik]) && !empty($subtopikByTopik[$value->idtopik])): ?>
                    <?php foreach ($subtopikByTopik[$value->idtopik] as $subtopik): ?>
                        <ul class="m-0 ps-5">
                            <li><?= $subtopik->nama ?></li>
                        </ul>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Tampilkan pesan atau data kosong jika tidak ada subtopik -->
                    <ul class="m-0 ps-5">
                        <li>Tidak ada subtopik yang tersedia</li>
                    </ul>
                <?php endif; ?>
            </div>



        </div>
        <?php
        $count++;
    elseif ($count == $maxButtons):
        ?>
        <div class="read-more text-center">
            <a onclick="showAllTopics()" class="badge badge-danger shadow-leap text-capitalize fw-normal"
                style="font-size:18px ; cursor:pointer">
                Read more ....</a>
        </div>
        <?php
        $count++;
    endif;
endforeach;
?>



<?php
foreach ($topik as $key => $value):
    if ($count > $maxButtons):
        ?>
        <div class="badge-custom shadow-leap hidden-topic" style="display: none;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="ml-3">
                    <?php
                    $badgeClass = ($key % 3 == 0) ? 'badge-blue2' : (($key % 3 == 1) ? 'badge-yellow' : 'badge-blue');
                    ?>
                    <span class="badge m-0 text-capitalize fw-normal search-top <?= $badgeClass ?>" style="font-size:18px ;">
                        <?= $value->nama ?>
                    </span>
                    <p class="m-0 ps-2"><?= $value->jumlah_subtopik ?> Subtopics</p>
                </div>
                <a href="<?= base_url() . 'homesiswa/subtopic/' . str_replace(' ', '-', $value->nama) ?> ">
                    <img alt="image" src="<?= base_url() ?>front/images/arrow1.png" width="30px">
                </a>
            </div>

            <!-- Menampilkan data subtopik -->
            <div class="sub-search d-none">
                <h6 class="m-0 ps-2">Subtopic :</h6>
                <?php if (isset($subtopikByTopik[$value->idtopik]) && !empty($subtopikByTopik[$value->idtopik])): ?>
                    <?php foreach ($subtopikByTopik[$value->idtopik] as $subtopik): ?>
                        <ul class="m-0 ps-5">
                            <li><?= $subtopik->nama ?></li>
                        </ul>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Tampilkan pesan atau data kosong jika tidak ada subtopik -->
                    <ul class="m-0 ps-5">
                        <li>Tidak ada subtopik yang tersedia</li>
                    </ul>
                <?php endif; ?>
            </div>

        </div>
        <?php
        $count++;
    endif;
endforeach;
?>