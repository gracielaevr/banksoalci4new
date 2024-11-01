<?= $this->extend('back/dashboardinstansisiswa/default') ?>


<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Welcome Back <br><?= $nama ?> <img alt="image" src="<?= base_url() ?>front/images/wave.png" width="20px">
        </h1>
        <div class="date-box section-header-breadcrumb">
            <p><span id="current-day"></span>, <span id="current-date"></span></p>
        </div>
    </div>

    <div class="section-body">
        <div id="accountNotification" class="account-notification" style="display: none;">
            <marquee behavior="scroll" direction="left">
                Your account will be deactivated after 6 months. Subscribe now to prevent deactivation.
            </marquee>
        </div>
        <h2 class="section-title">Popular Topics</h2>
        <div class="row">
            <?php $count = 0;
            foreach ($topik as $key => $value):
                if ($count < 3): ?>
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <?php $badgeClass = ($key % 3 == 0) ? 'badge-blue2' : (($key % 3 == 1) ? 'badge-yellow' : 'badge-blue'); ?>
                        <h4><span class="badge <?= $badgeClass ?>"><?= $value->nama ?></span></h4>
                    </div>
                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, vel vitae libero sed suscipit
                            enim assumenda aperiam officiis neque quam sunt delectus dicta id ullam quae deserunt?
                            Laudantium, repellendus neque.</p>
                    </div>
                    <div class="card-footer d-flex">
                        <p><i class="fas fa-sticky-note"></i> <?= $value->jumlah_subtopik ?> Subtopics</p>
                        <div class="ml-auto">
                            <a href="<?= base_url('subtopic1/' . $value->idtopik) ?>">
                                <img alt="image" src="<?= base_url() ?>front/images/arrow1.png" width="30px">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php $count++; // Tambahkan hitungan setiap kali iterasi
                endif;
            endforeach; ?>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="section-title">Other Topics</h2>
            <div class="search-bar ml-auto">
                <div class="input-group">
                    <input type="text" id="searchInput" placeholder="Search topics..." class="mr-2 form-control ">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" onclick="searchTopics()"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="notFoundMessage" style="display: none;">
            <p>Topic not found</p>
        </div>
        <?php foreach ($topik as $key => $value): ?>
        <div class="badge-custom">
            <div class="d-flex searchable">
                <?php
                    $badgeClass = ($key % 3 == 0) ? 'badge-blue2' : (($key % 3 == 1) ? 'badge-yellow' : 'badge-blue');
                    ?>
                <h4><span class="badge <?= $badgeClass ?>"><?= $value->nama ?></span></h4>
                <p class="ml-auto"><i class="fas fa-sticky-note"></i> <?= $value->jumlah_subtopik ?> Subtopics</p>
                <div class="ml-3">
                    <a href="<?= site_url('subtopic1/' . $value->idtopik) ?>">
                        <img alt="image" src="<?= base_url() ?>front/images/arrow1.png" width="30px">
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tampilkan notifikasi setelah dokumen selesai dimuat
    var accountNotification = document.getElementById('accountNotification');
    if (accountNotification) {
        accountNotification.style.display = 'block';
    }
});

function searchTopics() {
    var searchInput = document.getElementById('searchInput');
    var searchTerm = searchInput.value.toLowerCase();
    var topics = document.querySelectorAll('.badge-custom');

    topics.forEach(function(topic) {
        var topicName = topic.querySelector('.badge').innerText.toLowerCase();
        if (topicName.includes(searchTerm)) {
            // Jika topik ditemukan, tampilkan
            topic.style.display = 'block';
        } else {
            // Jika topik tidak ditemukan, sembunyikan
            topic.style.display = 'none';
        }
    });

    // Tampilkan pesan "Topic not found" jika tidak ada topik yang sesuai
    var notFoundMessage = document.getElementById('notFoundMessage');
    if (document.querySelectorAll('.badge-custom:not([style*="display: none"])').length === 0) {
        notFoundMessage.style.display = 'block';
    } else {
        notFoundMessage.style.display = 'none';
    }
}
</script>

<?= $this->endSection() ?>