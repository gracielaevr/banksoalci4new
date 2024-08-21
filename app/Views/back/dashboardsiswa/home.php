<?= $this->extend('back/dashboardsiswa/default') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-xl-12 col-sm-12 mb-2">
        <div class="card shadow-leap">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-8 welcome-leap">
                        <h5>Welcome Back <br><span class="me-2"><?= $nama; ?></span><img alt="image"
                                src="<?= base_url() ?>/front/images/wave.png" width="20px">
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

<marquee behavior="scroll" direction="left">
    Your account will be deactivated after 6 months. Subscribe now to prevent deactivation.
</marquee>
<h5 class="section-title mb-2">Popular Topics</h5>
<div class="row">
    <?php $count = 0;
    $topik = $topik ?? [];
    foreach ($topik as $key => $value):
        if ($count < 3): ?>
            <div class="col-12 col-md-4 col-lg-4 mb-3">
                <div class="card shadow-leap">
                    <div class="card-header pb-2">
                        <?php $badgeClass = ($key % 3 == 0) ? 'badge-blue2' : (($key % 3 == 1) ? 'badge-yellow' : 'badge-blue'); ?>
                        <h5><span class="badge text-capitalize fw-normal <?= $badgeClass ?>"
                                style="font-size:18px;"><?= $value->nama ?></span></h5>
                    </div>
                    <div class="card-body pt-0" style="max-height: 250px; overflow: hidden;"
                        onmouseover="this.style.overflow='auto';" onmouseout="this.style.overflow='hidden';">
                        <?php foreach ($subtopikByTopik[$value->idtopik] as $subtopik): ?>
                            <p style="font-size: 14px;"><?= $subtopik->deskripsi ?></p>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <p> <?= $value->jumlah_subtopik ?> Subtopics</p>
                        <div class="ml-auto">
                            <a href="<?= base_url('subtopic1/' . $value->idtopik) ?>">
                                <img alt="image" src="<?= base_url() ?>/front/images/arrow1.png" width="30px">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    <?php $count++; // Tambahkan hitungan setiap kali iterasi
        endif;
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
<!-- <div id="notFoundMessage" style="display: none;">
    <p>Topic not found</p>
</div> -->
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
                <a href="<?= site_url('subtopic1/' . $value->idtopik) ?>">
                    <img alt="image" src="<?= base_url() ?>/front/images/arrow1.png" width="30px">
                </a>
            </div>

            <!-- Menampilkan data subtopik -->
            <div class="sub-search d-none">
                <h6 class="m-0 ps-2">Subtopic :</h6>
                <?php foreach ($subtopikByTopik[$value->idtopik] as $subtopik): ?>
                    <ul class="m-0 ps-5">
                        <li><?= $subtopik->nama ?></li>
                    </ul>
                <?php endforeach; ?>

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
                <a href="<?= site_url('subtopic1/' . $value->idtopik) ?>">
                    <img alt="image" src="<?= base_url() ?>/front/images/arrow1.png" width="30px">
                </a>
            </div>

            <!-- Menampilkan data subtopik -->
            <div class="sub-search d-none">
                <h6 class="m-0 ps-2">Subtopic :</h6>
                <?php foreach ($subtopikByTopik[$value->idtopik] as $subtopik): ?>
                    <ul class="m-0 ps-5">
                        <li><?= $subtopik->nama ?></li>
                    </ul>
                <?php endforeach; ?>

            </div>
        </div>
<?php
        $count++;
    endif;
endforeach;
?>

<script>
    function showAllTopics() {
        var hiddenTopics = document.querySelectorAll('.hidden-topic');
        hiddenTopics.forEach(function(topic) {
            topic.style.display = 'block';
            // el.classList.remove('d-none');

        });
        document.querySelector('.read-more').style.display = 'none';
    }
</script>

<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     // Tampilkan notifikasi setelah dokumen selesai dimuat
    //     var accountNotification = document.getElementById('accountNotification');
    //     if (accountNotification) {
    //         accountNotification.style.display = 'block';
    //     }
    // });
    document.addEventListener("DOMContentLoaded", function() {


        var search = document.getElementById("searchInput-top");
        var top = document.querySelectorAll(".badge-custom");
        var sub = document.querySelectorAll(".sub-search");
        var read = document.querySelector(".read-more");
        var maxButtons = 8;
        search.addEventListener("keyup", function() {
            var searchValue = search.value.toLowerCase();

            var all = [...top, ...sub];

            if (searchValue === "") {
                // Jika pencarian kosong, tampilkan kembali 8 elemen pertama dan "Read More"
                all.forEach(function(el, index) {
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
                all.forEach(function(el) {
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

                // var isAnyElementVisible = Array.prototype.some.call(all, function(el) {
                //     return el.style.display === 'block';
                // });

                // read.style.display = isAnyElementVisible ? 'none' : 'block';
            }
        });

        // document.getElementById("read-more").addEventListener("click", function(e) {
        //     e.preventDefault();
        //     var hiddenTopics = document.querySelectorAll(".hidden-topic");
        //     Array.prototype.forEach.call(hiddenTopics, function(el) {
        //         el.style.display = 'block';
        //     });
        //     read.style.display = 'none';
        // });

    });
</script>

<?= $this->endSection() ?>