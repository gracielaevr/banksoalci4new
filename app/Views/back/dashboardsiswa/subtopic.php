<?= $this->extend('back/dashboardsiswa/default') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-4">
            <div class="card shadow-leap">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6 welcome-leap">
                            <h5 class="m-0">TOPIC : <?= $topik->nama ?>
                            </h5>
                        </div>
                        <div class="col-6 welcome-leap text-end btnnn">
                            <div class="section-header-breadcrumb buttons">
                                <a href="<?= base_url('homesiswa') ?>"
                                    class="btn btn-icon m-0 icon-left btn-primary-leap"><i
                                        class="fa fa-rotate-left me-2"></i>
                                    Back to Topic</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-body">

        <div class="d-flex align-items-start justify-content-between mt-3 mb-3 search-leap">

            <h5 class="section-title">Subtopic</h5>

            <div class="search-bar">
                <div class="input-group">
                    <input type="text" id="searchInput-sub" placeholder="Search topics..." class="form-control ms-2"
                        style="box-shadow: 0px 0px 23px 0px rgba(0,0,0,0.3);">
                    <div class="input-group-btn">
                        <button class="btn btn-primary-leap"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 80%;">
            <?php

            foreach ($subtopics as $subtopic): ?>
                <div class="col-12 col-md-4 col-lg-4 ">
                    <a href="<?= base_url("start/{$subtopic->idsubtopik}") ?>">
                        <div class="card shadow-leap2 mb-2">
                            <div class="card-header-centered search-sub">
                                <h5><?= $subtopic->nama ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
<?= $this->endSection() ?>